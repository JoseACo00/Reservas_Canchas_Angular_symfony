<?php

namespace App\Form;

use App\Entity\Arbitro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ArbitroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 45,
                    ])
                ]
            ])
            ->add('surname1', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 30
                    ])
                ]
            ])
            ->add('surname2', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 30
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            ->add('password', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'max' => 50,
                    ])
                ]
            ])
            ->add('age', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 3,
                    ])
                ]
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' =>  9,
                        'max' => 12,
                    ]),
                ]
            ])
            ->add('experiences', TextType::class, [
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arbitro::class,
            'csrf_protection' => false, //NECESARIO SI IMPORATAMOS EL MAKEBULDER MAKE BUILDER
        ]);
    }
}
