<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Date;



/**
 * Formulario para la entidad Admin.
 *
 * Esta clase define el formulario utilizado para crear y editar entidades Admin.
 */
class AdminType extends AbstractType
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
            ->add('birthdate',  DateType::class,[
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new Date(),
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
            'csrf_protection' => false, //NECESARIO SI IMPORATAMOS EL MAKEBULDER MAKE BUILDER
        ]);
    }
}
