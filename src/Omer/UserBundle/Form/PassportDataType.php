<?php

namespace Omer\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PassportDataType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latinSurname', TextType::class, [
                'label' => 'label.latin_surname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.latin_surname'
                ]
            ])
            ->add('latinName', TextType::class, [
                'label' => 'label.latin_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.latin_name'
                ]
            ])
            ->add('latinPatronymic', TextType::class, [
                'label' => 'label.latin_patronymic',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.latin_patronymic'
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
