<?php

namespace Omer\TeamBundle\Form;

use Omer\UserBundle\Form\CoachUserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('nativeTeamName')
            ->add('englishTeamName')
            ->add('memberNumber')
            ->add('guo')
            ->add('guoAdress')
            ->add('principalFullName')
            ->add('educationDepartment')
            ->add('educatuionDepartmentAdress')
            ->add('headOfEduFullName')
            ->add('coach', CoachUserType::class)
            ->add('members',  CollectionType::class, [
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
