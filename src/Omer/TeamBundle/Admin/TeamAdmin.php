<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Omer\UserBundle\OmerUserBundle;
use Omer\UserBundle\Traits\CurrentUserTrait;
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


class TeamAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nativeTeamName', TextType::class, [
                'label' => 'label.team.native_team_name'
            ])
            ->add('englishTeamName', TextType::class, [
                'label' => 'label.team.english_team_name'
            ])
            ->add('memberNumber', NumberType::class, [
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
            ->add('coaches', EntityType::class, [
                'label' => 'coaches',
                'class' => 'Omer\UserBundle\Entity\CoachUser',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->innerJoin('u.teams', 't')
                        ->andWhere('t.memberNumber = :memberNumber')
                        ->andWhere('u.isMain = 1')
                        ->setParameter('memberNumber', $this->getSubject()->getMemberNumber());
                },
            ])
            ->add('members', 'sonata_type_collection', [
                    'required' => false,
                    'label' => 'label.team.members',
                    'translation_domain' => 'OmerTeamBundle',
                    'btn_add' => 'Add'
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
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
            ->add('guo', null, [
                'label' => 'label.team.native_team_name'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete');
    }

    public function createQuery($context = 'list')
    {
        /**
         * @var ProxyQuery $query
         */
        $query = parent::createQuery($context);

        if($this->getCurrentUser()->hasRole('ROLE_COACH')) {
            $query
                ->innerJoin($query->getRootAlias().'.coaches', 'c')
                ->innerJoin('c.teams', 't')
                ->andWhere('c.username LIKE :user')
                ->setParameter('user', $this->getCurrentUser()->getUsername());
        }

        return $query;
    }
}