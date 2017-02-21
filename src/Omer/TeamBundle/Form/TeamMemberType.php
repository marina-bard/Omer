<?php

namespace Omer\TeamBundle\Form;

use Omer\TeamBundle\OmerTeamBundle;
use Omer\UserBundle\Form\PassportDataType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class TeamMemberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'label.team_member.first_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.first_name'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'label.team_member.surname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.surname'
                ]
            ])
            ->add('T_shirtSize', TextType::class, [
                'label' => 'label.team_member.t_shirt_size',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.t_shirt_size'
                ]
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'label.team_member.date_of_birth',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('passportNumber', TextType::class, [
                'label' => 'label.team_member.passport_number',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.passport_number'
                ]
            ])
            ->add('dateOfIssue', DateType::class, [
                'label' => 'label.team_member.date_of_issue',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('dateOfExpiry', DateType::class, [
                'label' => 'label.team_member.date_of_expiry',
                'placeholder' => [
                    'year' => 'Year',
                    'month' => 'Month',
                    'day' => 'Day'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'label.team_member.address',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.address'
                ]
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'label' => 'label.team_member.dietary_concerns',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.dietary_concerns'
                ]
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'label' => 'label.team_member.medical_concerns',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.medical_concerns'
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
            'data_class' => 'Omer\TeamBundle\Entity\TeamMember',
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
