<?php

namespace Omer\UserBundle\Form;

use Omer\TravelBundle\Form\TravelInfoType;
use Omer\UserBundle\Entity\DirectorUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DirectorUserType extends AbstractType
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
            ->add('gender', ChoiceType::class, [
                'choices' => array_flip(DirectorUser::GENDER),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user_type.gender'
                ]
            ])
            ->add('association', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user_type.association'
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user_type.address'
                ]
            ])
            ->add('T_shirtSize', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user_type.t_shirt_size'
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
                    'placeholder' => 'label.personal_data.date_of_birth'
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
                    'placeholder' => 'label.personal_data.date_of_birth'
                ]
            ])
            ->add('citizenship', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.citizenship'
                ]
            ])
            ->add('mobilePhone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.mobile_phone'
                ]
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user_type.dietary_concerns'
                ]
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user_type.medical_concerns'
                ]
            ])
            ->add('travelAttributes', CollectionType::class, [
                'label'         => false,
                'entry_type'    => TravelInfoType::class,
                'allow_add'     => false,
                'allow_delete'  => false,
                'by_reference'  => false,
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Omer\UserBundle\Entity\DirectorUser',
            'translation_domain' => 'OmerUserBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omer_userbundle_directoruser';
    }


}
