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
        parent::configureFormFields($formMapper);
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
            ->add('division', TextType::class, [
                'label' => 'label.team.division'
            ])
            ->add('dateOfArrival','sonata_type_date_picker',[
                'label' => 'label.team.date_of_arrival',
                'format' => 'dd.MM.yyyy',
                'dp_min_date' => '18.04.2017',
                'dp_max_date' => '02.05.2017',
                'dp_default_date' => '23.04.2017',
                'attr' => ['readonly' => true]
            ])
            ->add('dateOfDeparture', 'sonata_type_date_picker', [
                'label' => 'label.team.date_of_departure',
                'format' => 'dd.MM.yyyy',
                'dp_min_date' => '18.04.2017',
                'dp_max_date' => '02.04.2017',
                'dp_default_date' => '23.04.2017',
                'attr' => ['readonly' => true]
            ])
            ->add('concerns', TextareaType::class, [
                'label' => 'label.team.concerns'
            ])
        ;
    }
}