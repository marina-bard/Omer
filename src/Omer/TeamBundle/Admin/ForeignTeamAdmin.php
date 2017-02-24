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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Omer\UserBundle\Entity\CoachUser;
use Sonata\AdminBundle\Form\Type\CollectionType;


class ForeignTeamAdmin extends BaseTeamAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('school', TextType::class, [
                'label' => 'label.team.school'
            ])
            ->add('address', TextType::class, [
                'label' => 'label.team.address'
            ])
            ->add('problem', TextType::class, [
                'label' => 'label.team.problem',
            ])
//            ->add('problem', 'sonata_type_model', [
//                'label' => 'label.team.problem',
//                'multiple' => false
//            ])
            ->add('division', NumberType::class, [
                'label' => 'label.team.division'
            ])
            ->add('dateOfArrival', TextType::class, [
                'label' => 'label.team.edu_dep'
            ])
            ->add('DateOfDeparture', TextType::class, [
                'label' => 'label.team.edu_dep_address'
            ])
            ->add('concerns', TextareaType::class, [
                'label' => 'label.team.concerns'
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nativeTeamName', null, [
                'label' => 'label.team.native_team_name'
            ])
            ->add('guo', null, [
                'label' => 'label.team.guo'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nativeTeamName', null, [
                'label' => 'label.team.native_team_name'
            ])
            ->add('city', null, [
                'label' => 'label.team.city'
            ])
            ->add('guo', null, [
                'label' => 'label.team.guo'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }
}