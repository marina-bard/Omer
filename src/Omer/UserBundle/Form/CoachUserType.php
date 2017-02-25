<?php

namespace Omer\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.first_name'
                ]
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.surname'
                ]
            ])
            ->add('T_shirtSize', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.coach_user.t_shirt_size'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.coach_user.email'
                ]
            ])
            ->add('dateOfBirth', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'years',
                    'data-date-locale' => 'label.locale',
                    'placeholder' => 'label.personal_data.date_of_birth'
                ]
            ])
            ->add('passportNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.passport_number'
                ]
            ])
            ->add('dateOfIssue', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'years',
                    'data-date-locale' => 'label.locale',
                    'placeholder' => 'label.personal_data.date_of_issue'
                ]
            ])
            ->add('dateOfExpiry', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'years',
                    'data-date-locale' => 'label.locale',
                    'placeholder' => 'label.personal_data.date_of_expiry'
                ]
            ])
            ->add('citizenship', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.citizenship'
                ],
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.coach_user.address'
                ]
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.coach_user.dietary_concerns'
                ]
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.coach_user.medical_concerns'
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
