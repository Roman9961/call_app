<?php

namespace App\Form;

use App\Entity\CallingList;
use App\Entity\CallingTask;
use App\Entity\CallingTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('callingTimes', EntityType::class,[
                'class'=>CallingTime::class,
                'required'=>false,
                'choice_label'=>function($timeObject){
                    return "{$timeObject->getCallingDay()} ( {$timeObject->getStartCallingTime()->format('H:i')}-{$timeObject->getEndCallingTime()->format('H:i')} )";
                },
                'multiple' => true,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('ct')
                        ->andWhere('ct.user=:user')
                        ->setParameter('user', $options['user']);
                },
            ])
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
