<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Omer\UserBundle\Entity\CoachUser;
use Sonata\AdminBundle\Form\Type\CollectionType;


class TeamAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nativeTeamName', TextType::class)
            ->add('englishTeamName', TextType::class)
            ->add('memberNumber', NumberType::class)
            ->add('guo', TextType::class)
            ->add('guoAddress', TextType::class)
            ->add('principalFullName', TextType::class)
            ->add('educationDepartment', TextType::class)
            ->add('educationDepartmentAddress', TextType::class)
            ->add('headOfEduFullName', TextType::class)
            ->add('coach', EntityType::class, [
                'class' => CoachUser::class
            ])
            ->add('members', 'sonata_type_collection', [
                    'required' => false,
                    'btn_add' => 'Добавить'
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nativeTeamName')
            ->add('guo')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nativeTeamName')
            ->add('guo')
        ;
    }
}