<?php

namespace App\Form;

use App\Entity\User;
use App\Subscribers\ImageFileSubscriber;
use App\Utils\FileManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private $fileManager;

    /**
     * UserType constructor.
     * @param $fileManager
     */
    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var User $currentUser */
        $currentUser = $options['user'];
        $editedUser = $builder->getData();

        $builder
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_name' => 'Password',
                'second_name' => 'RepeatPassword',
                'mapped' => false,
                'required' =>false,
            ])
            ->add('image', FilesType::class, [
                'required'=>false,
                'label'=>'Avatar'
            ])
        ;

        if(
            !$options['isSelfEdit'] &&
            (in_array('ROLE_ROOT', $currentUser->getRoles()) || (in_array('ROLE_ADMIN', $currentUser->getRoles()))
            )
        ){
            $builder->add('roles', ChoiceType::class, [
                'choices' =>$options['roles'],
                'multiple' => false,
                'expanded' => true
            ]);
            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function ($rolesArray) {
                        return count($rolesArray)? $rolesArray[0]: null;
                    },
                    function ($rolesString) {
                        return [$rolesString];
                    }
                ));
        }

        if((in_array('ROLE_ADMIN', $currentUser->getRoles()) || in_array('ROLE_ROOT', $currentUser->getRoles()))
            && !$options['isSelfEdit']
            && in_array('ROLE_USER', $editedUser->getRoles())
        ){
            $builder
                ->add('parent', EntityType::class, [
                    'class'=> User::class,
                    'choice_label' => 'username',
                    'query_builder' => function(EntityRepository $entityRepository){

                        return $entityRepository->createQueryBuilder('u')
                            ->where('u.roles LIKE :role')
                            ->setParameters(['role' => '%ROLE_SUPERVISOR%']);
                    }
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
        $resolver->setRequired(['roles', 'user', 'isSelfEdit']);
    }
}
