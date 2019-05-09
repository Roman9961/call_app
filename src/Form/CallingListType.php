<?php

namespace App\Form;

use App\Entity\CallingList;
use App\Entity\ClientMsisdn;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CallingListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('clientMsisdns', EntityType::class,[
                'class' => ClientMsisdn::class,
                'required' => false,
                'choice_label' => 'msisdn',
                'multiple' => true,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('ms')
                        ->andWhere('ms.user=:user')
                        ->setParameter('user', $options['user'])
                        ->setMaxResults(10)
                        ;
                },
            ])
        ->add("file", FileType::class, [
            'mapped'=>false,
            'required' => false,
            'constraints'=>[
                new File([
                    'maxSize' => '2M',
                    'mimeTypes' => [
                        'text/plain',
                    ],
                    'mimeTypesMessage' => 'Please upload a CSV file',
                ])
            ],
            'label'=>false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CallingList::class,
        ]);
        $resolver->setRequired('user');
    }
}
