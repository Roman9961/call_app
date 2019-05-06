<?php

namespace App\Form;

use App\Entity\CallingTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CallingTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('callingDay', IntegerType::class, [
                'attr'=>[
                    'min'=>1,
                    'max'=>7
                ]
            ])
            ->add('startCallingTime')
            ->add('endCallingTime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CallingTime::class,
        ]);
    }
}
