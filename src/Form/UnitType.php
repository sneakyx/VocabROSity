<?php

namespace App\Form;

use App\Entity\Unit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identifier')
            ->add('nativeLanguage', EntityType::class, [
                'class' => 'App\Entity\Language',
                'choice_label' => 'identifier',
            ])
            ->add('foreignLanguage', EntityType::class, [
                'class' => 'App\Entity\Language',
                'choice_label' => 'identifier',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Unit::class,
        ]);
    }
}
