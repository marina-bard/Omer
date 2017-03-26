<?php

namespace Omer\UserBundle\Form;

use Omer\TravelBundle\Form\TravelInfoType;
use Omer\UserBundle\Entity\OfficialUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficialUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices' => OfficialUser::ROLES,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user.gender'
                ]
            ])
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
                'choices' => array_flip(OfficialUser::GENDER),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user.gender'
                ]
            ])
            ->add('T_shirtSize', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.t_shirt_size'
                ]
            ])
            ->add('association', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user.association'
                ]
            ])
            ->add('citizenship', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.citizenship'
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user.address'
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
            ->add('mobilePhone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user.mobile_phone'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.user.email'
                ]
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.dietary_concerns'
                ]
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.medical_concerns'
                ]
            ])
            ->add('travelAttributes', CollectionType::class, [
                'label'         => false,
                'entry_type'    => TravelInfoType::class,
                'allow_add'     => false,
                'allow_delete'  => false,
                'by_reference'  => false,
            ])
            ->add('nativeSurname', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.native.surname'
                ]
            ])
            ->add('nativeFirstName', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.native.first_name'
                ]
            ])
            ->add('nativePatronymic', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.native.patronymic'
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
            'data_class' => 'Omer\UserBundle\Entity\OfficialUser',
            'translation_domain' => 'OmerUserBundle',
            'validation_groups' => [
                'Registration'
            ]
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
