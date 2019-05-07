<?php

namespace App\Form;

use App\Entity\CallingList;
use App\Entity\CallingTask;
use App\Entity\CallingTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CallingTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('callingList', EntityType::class,[
                'class'=>CallingList::class,
                'choice_label'=>'name',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('cl')
                        ->andWhere('cl.user=:user')
                        ->setParameter('user', $options['user']);
                },
            ])
            ->add('callingTimes', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CallingTask::class,
        ]);
        $resolver->setRequired('user');
    }
}
