<?php

namespace App\Form;

use App\Entity\Vocabulary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VocabularyEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nativePhrase')
            ->add('foreignPhrase')
            ->add('Unit', EntityType::class, [
                'class' => 'App\Entity\Unit',
                'choice_label' => 'identifier',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vocabulary::class,
        ]);
    }
}
