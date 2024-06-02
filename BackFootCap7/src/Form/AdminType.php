<?php

namespace App\Form;

use App\Entity\Admin;
use App\Entity\Rol;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('surname1')
            ->add('surname2')
            ->add('email')
            ->add('password')
            ->add('birthdate', null, [
                'widget' => 'single_text',
            ])
            ->add('phone')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('created_by')
            ->add('modified_at', null, [
                'widget' => 'single_text',
            ])
            ->add('modified_by')
            ->add('deleted_at', null, [
                'widget' => 'single_text',
            ])
            ->add('deleted_by')
            ->add('rol', EntityType::class, [
                'class' => Rol::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
