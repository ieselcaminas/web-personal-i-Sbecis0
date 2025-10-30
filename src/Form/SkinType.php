<?php

namespace App\Form;

use App\Entity\Skin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('weapon')
            ->add('rarity')
            ->add('price')
            ->add('float')
            ->add('pattern')
            ->add('stattrak')
            ->add('image')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skin::class,
        ]);
    }
}
