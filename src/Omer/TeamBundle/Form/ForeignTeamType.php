<?php

namespace Omer\TeamBundle\Form;

use Omer\UserBundle\Form\CoachUserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForeignTeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('englishTeamName', TextType::class, [
                'label' => 'label.team.english_team_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.english_team_name'
                ]
            ])
            ->add('memberNumber', TextType::class, [
                'label' => 'label.team.member_number',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.member_number'
                ]
            ])
            ->add('school', TextType::class, [
                'label' => 'label.team.school',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.school'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'label.team.country',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.country'
                ]
            ])
            ->add('district', TextType::class, [
                'label' => 'label.team.district',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.district'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'label.team.city',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.city'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'label.team.address',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.address'
                ]
            ])
            ->add('problem', TextType::class, [
                'label' => 'label.team.problem',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.problem'
                ]
            ])
            ->add('division', TextType::class, [
                'label' => 'label.team.division',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.division'
                ]
            ])
            ->add('dateOfArrival', DateType::class, [
                'label' => 'label.team.date_of_arrival',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'days',
                    'data-date-start-date' => '23-04-2017',
                    'data-date-end-date' => '28-04-2017',
                    'data-date-locale' => 'label.locale',
                    'placeholder' => 'label.team.date_of_arrival'
                ]
            ])
            ->add('dateOfDeparture', DateType::class, [
                'label' => 'label.team.date_of_departure',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'days',
                    'data-date-start-date' => '23-04-2017',
                    'data-date-end-date' => '28-04-2017',
                    'data-date-locale' => 'label.locale',
                    'placeholder' => 'label.team.date_of_departure'
                ]
            ])
            ->add('paymentCurrency', TextType::class, [
                'label' => 'label.team.payment_currency',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.payment_currency'
                ]
            ])
            ->add('concerns', TextareaType::class, [
                'label' => 'label.team.concerns',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.concerns'
                ]
            ])
            ->add('coaches',  CollectionType::class, [
                'label'         => false,
                'entry_type'    => CoachUserType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_coaches',
                ]
            ])
            ->add('members',  CollectionType::class, [
                'label'         => false,
                'entry_type'    => TeamMemberType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_members',
                ]
            ])
            ->add('otherPeople',  CollectionType::class, [
                'label'         => false,
                'entry_type'    => OtherPeopleType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_other',
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
            'data_class' => 'Omer\TeamBundle\Entity\ForeignTeam',
             'translation_domain' => 'OmerTeamBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omer_teambundle_team';
    }


}
