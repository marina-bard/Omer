<?php

namespace Omer\TeamBundle\Form;

use Omer\TeamBundle\OmerTeamBundle;
use Omer\UserBundle\Form\PassportDataType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class OtherPeopleType extends AbstractType
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
                ],
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('surname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.surname'
                ],
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('T_shirtSize', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.other_people.t_shirt_size'
                ]
            ])
            ->add('teamRole', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.other_people.team_role'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.team_member.email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.other_people.email'
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
                ],
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('passportNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.personal_data.passport_number'
                ],
                'translation_domain' => 'OmerUserBundle'
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
                ],
                'translation_domain' => 'OmerUserBundle'
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
                ],
                'translation_domain' => 'OmerUserBundle'
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
                    'placeholder' => 'label.other_people.address'
                ]
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.dietary_concerns'
                ]
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.medical_concerns'
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
            'data_class' => 'Omer\TeamBundle\Entity\OtherPeople',
            'translation_domain' => 'OmerTeamBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omer_teambundle_teammember';
    }

}
