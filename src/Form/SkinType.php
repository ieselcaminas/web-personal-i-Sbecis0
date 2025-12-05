<?php

namespace App\Form;

use App\Entity\Skin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;

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
            ->add('imageFile', FileType::class, [
            'label' => 'Imagen (JPG, PNG, WEBP)',
            'required' => false,
            'mapped' => false,
            'constraints' => [
                new Image([
                    'maxSize' => '5M',
                    'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                ])
            ],
        ])
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
