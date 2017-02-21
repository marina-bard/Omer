<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Omer\TeamBundle\Entity\BaseTeam;
use Omer\UserBundle\OmerUserBundle;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Omer\UserBundle\Traits\FullNameTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Omer\UserBundle\Entity\CoachUser;
use Sonata\AdminBundle\Form\Type\CollectionType;


class NativeTeamAdmin extends BaseTeamAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nativeTeamName', TextType::class, [
                'label' => 'label.team.native_team_name'
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
        ;
    }
}