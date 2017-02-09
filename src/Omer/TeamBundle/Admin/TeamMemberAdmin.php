<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TeamMemberAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('surname', TextType::class, [
                'label' => 'label.team_member.surname'
            ])
            ->add('name', TextType::class, [
                'label' => 'label.team_member.name'
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'label.team_member.patronymic'
            ])
            ->add('latinSurname', TextType::class, [
                'label' => 'label.team_member.latin_surname'
            ])
            ->add('latinName', TextType::class, [
                'label' => 'label.team_member.latin_name'
            ])
            ->add('latinPatronymic', TextType::class, [
                'label' => 'label.team_member.latin_patronymic'
            ])
            ->add('age', NumberType::class, [
                'label' => 'label.team_member.age'
            ])
            ->add('allergy', TextareaType::class, [
                'required' => false,
                'label' => 'label.team_member.allergy'
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('surname', null, [
                'label' => 'label.team_member.surname'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('surname', null, [
                'label' => 'label.team_member.surname'
            ])
            ->add('name', null, [
                'label' => 'label.team_member.name'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('fullName', null, [
                'label' => 'label.team_member.name'
            ])
            ->add('age', null, [
                'label' => 'label.team_member.age'
            ])
            ->add('allergy', null, [
                'label' => 'label.team_member.allergy'
            ])
        ;
    }

    public function createQuery($context = 'list')
    {
        /**
         * @var ProxyQuery $query
         */
        $query = parent::createQuery($context);

        if($this->getCurrentUser()->hasRole('ROLE_COACH')){
            $query
                ->innerJoin($query->getRootAlias().'.team', 't')
                ->innerJoin('t.coaches', 'c')
                ->andWhere('c.username LIKE :user')
                ->setParameter('user', $this->getCurrentUser()->getUsername());
        }

        return $query;
    }
}