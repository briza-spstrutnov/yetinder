<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegisterFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('username', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Uživatelské jméno',
                ),
                'label' => false
            ])
            ->add('password', PasswordType::class, [
                'attr' => array(
                    'placeholder' => 'Heslo'
                ),
                'label' => false
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => array('Male' => 'Male', 'Female' => 'Female'
                ),
            ])
            ->add('height', NumberType::class, [
                'attr' => array(
                    'placeholder' => 'Výška'
                ),
                'label' => false
            ])
            ->add('weight', NumberType::class, [
                'attr' => array(
                    'placeholder' => 'Váha'
                ),
                'label' => false
            ])
            ->add('rating', NumberType::class, [
                'attr' => array(
                    'value' => 100,
                ),
                'label' => false
            ])
            ->add('phoneNumber',TelType::class, [
                'attr' => array(
                    'placeholder' => 'Telefonní číslo'
                ),
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
