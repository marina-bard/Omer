<?php

namespace Omer\TeamBundle\Form;

use Omer\TeamBundle\OmerTeamBundle;
use Omer\UserBundle\Form\PassportDataType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamMemberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surname', TextType::class, [
                'label' => 'label.team_member.surname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.surname'
                ]
            ])
            ->add('latinSurname', TextType::class, [
                'label' => 'label.team_member.latin_surname',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.latin_surname'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'label.team_member.name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.name'
                ]
            ])
            ->add('latinName', TextType::class, [
                'label' => 'label.team_member.latin_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.latin_name'
                ]
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'label.team_member.patronymic',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.patronymic'
                ]
            ])
            ->add('latinPatronymic', TextType::class, [
                'label' => 'label.team_member.latin_patronymic',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.latin_patronymic'
                ]
            ])
            ->add('age', TextType::class, [
                'label' => 'label.team_member.age',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.age'
                ]
            ])
            ->add('allergy', TextareaType::class, [
                'label' => 'label.team_member.allergy',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team_member.allergy'
                ]
            ])
//            ->add('passportDataLabel', PassportDataType::class, [
//                'data_class' => 'Omer\TeamBundle\Entity\TeamMember',
//                ''
//            ])
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
