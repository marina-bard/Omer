<?php

namespace Omer\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoachUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surname', TextType::class, [
                'label' => 'label.surname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.surname'
                ]
            ])
            ->add('latinSurname', TextType::class, [
                'label' => 'label.latin_surname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.latin_surname'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'label.name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.name'
                ]
            ])
            ->add('latinName', TextType::class, [
                'label' => 'label.latin_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.latin_name'
                ]
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'label.patronymic',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.patronymic'
                ]
            ])
            ->add('latinPatronymic', TextType::class, [
                'label' => 'label.latin_patronymic',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.latin_patronymic'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'label.phone',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.phone'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.email'
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Omer\UserBundle\Entity\CoachUser',
            'translation_domain' => 'OmerUserBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omer_userbundle_coachuser';
    }
}
