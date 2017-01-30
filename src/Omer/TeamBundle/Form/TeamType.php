<?php

namespace Omer\TeamBundle\Form;

use Omer\UserBundle\Form\CoachUserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nativeTeamName', TextType::class, [
                'label' => 'label.team.native_team_name'
            ])
            ->add('englishTeamName', TextType::class, [
                'label' => 'label.team.english_team_name'
            ])
            ->add('memberNumber', TextType::class, [
                'label' => 'label.team.member_number'
            ])
            ->add('guo', TextType::class, [
                'label' => 'label.team.guo'
            ])
            ->add('guoAddress', TextType::class, [
                'label' => 'label.team.guo_address'
            ])
            ->add('principalFullName', TextType::class, [
                'label' => 'label.team.principal_name'
            ])
            ->add('educationDepartment', TextType::class, [
                'label' => 'label.team.edu_dep'
            ])
            ->add('educationDepartmentAddress', TextType::class, [
                'label' => 'label.team.edu_dep_address'
            ])
            ->add('headOfEduFullName', TextType::class, [
                'label' => 'label.team.head_edu_name'
            ])
            ->add('coach', CoachUserType::class)
            ->add('members',  CollectionType::class, [
                'label'         => 'label.team.members',
                'entry_type'    => TeamMemberType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection',
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
            'data_class' => 'Omer\TeamBundle\Entity\Team'
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
