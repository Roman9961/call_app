<?php

namespace App\Form;

use App\Entity\CallingList;
use App\Entity\ClientMsisdn;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CallingListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('clientMsisdns', EntityType::class,[
                'class' => ClientMsisdn::class,
                'choice_label' => 'msisdn',
                'multiple' => true,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('ms')
                        ->andWhere('ms.user=:user')
                        ->setParameter('user', $options['user']);
                },
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
