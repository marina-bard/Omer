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
            ->add('teamRole', TextType::class, [
                'label' => 'label.team_member.team_role',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.team_role'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.team_member.email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.email'
                ]
            ])
            ->add('dateOfBirth', DateTimeType::class, [
                'label' => 'label.team_member.date_of_birth',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'years',
                    'data-date-locale' => 'label.team_member.locale',
                    'placeholder' => 'label.team_member.date_of_birth'
                ]
            ])
            ->add('passportNumber', TextType::class, [
                'label' => 'label.team_member.passport_number',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.passport_number'
                ]
            ])
            ->add('dateOfIssue', DateTimeType::class, [
                'label' => 'label.team_member.date_of_issue',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'years',
                    'data-date-locale' => 'label.team_member.locale',
                    'placeholder' => 'label.team_member.date_of_issue'
                ]
            ])
            ->add('dateOfExpiry', DateTimeType::class, [
                'label' => 'label.team_member.date_of_expiry',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'years',
                    'data-date-locale' => 'label.team_member.locale',
                    'placeholder' => 'label.team_member.date_of_expiry'
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
