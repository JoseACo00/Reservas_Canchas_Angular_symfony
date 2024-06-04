<?php

namespace App\Form;

use App\Entity\Cancha;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;

class CanchaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                            'min' => 5,
                            'max' => 120,
                    ])
                ]
            ])
            ->add('localidad', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 30,
                    ])
                ]
            ])
            ->add('direccion', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 255,
                    ])
                ]
            ])
            ->add('precio', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                            'min' => 25,
                            'max' => 120
                        ]
                    )
                ]
            ] )
            ->add('imagen',FileType::class, [
                'label' => 'imagen (JPEG/PNG/WEBP/HEIC/HEIF file)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '3000k', // Máximo 3.0 MB
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/heic',
                            'image/heif',
                        ]
                    ])
                ],
            ])
            ->add('disponibilidad', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 30,
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cancha::class,
        ]);
    }
}
