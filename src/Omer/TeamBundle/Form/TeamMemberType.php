<?php

namespace Omer\TeamBundle\Form;

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
                'label' => 'label.team_member.surname'
            ])
            ->add('name', TextType::class, [
                'label' => 'label.team_member.name'
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'label.team_member.patronymic'
            ])
            ->add('age', TextType::class, [
                'label' => 'label.team_member.age'
            ])
            ->add('allergy', TextareaType::class, [
                'label' => 'label.team_member.allergy'
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
