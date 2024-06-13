<?php

namespace App\Form;


use App\Entity\Cancha;
use App\Entity\Reserva;
use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;



/**
 * Formulario para la entidad Reserva.
 *
 * Esta clase define el formulario utilizado para crear y editar entidades Reserva.
 */
class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usuario', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'id',
                'required' => true,
            ])
            ->add('cancha', EntityType::class, [
                'class' => Cancha::class,
                'choice_label' => 'id',
                'required' => true,
            ])
            ->add('fecha_reserva', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('hora_reserva', TextType::class, [
                'required' => true,
            ])
            ->add('hora_fin', TextType::class, [
                'required' => true,
            ])
            ->add('arbitro_opcion', CheckboxType::class, [
                'required' => false,
                'mapped' => true,
            ])
            ->add('metodo_pago', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('comprobante_pago', TextType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
            'csrf_protection' => false,
        ]);
    }
}
