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
                            'min' => 1,
                            'max' => 120
                        ]
                    )
                ]
            ] )
            ->add('imagen', TextType::class, [
                'required' => false

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
            'csrf_protection' => false, //NECESARIO SI IMPORATAMOS EL MAKEBULDER MAKE BUILDER
        ]);
    }
}
