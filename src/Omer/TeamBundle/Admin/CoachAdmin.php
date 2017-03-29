<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 23:00
 */

namespace Omer\TeamBundle\Admin;

use Omer\TeamBundle\Entity\BaseTeam;
use Omer\UserBundle\Admin\PersonalDataAdmin;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CoachAdmin extends PersonalDataAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('teams', null, [
                'label' => 'label.coach_user.team',
                'class' => BaseTeam::class,
                'multiple' => true,
                'attr' => ['disabled' => true]
            ])
        ;

        parent::configureFormFields($formMapper);

        $formMapper
            ->add('address', TextType::class, [
                'label' => 'label.coach_user.address'
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.coach_user.email'
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'label' => 'label.dietary_concerns',
                'required' => false
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'label' => 'label.medical_concerns',
                'required' => false
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email', null, [
                'label' => 'label.coach_user.email'
            ])
            ->add('surname', null, [
                'label' => 'label.personal_data.surname'
            ])
            ->add('teams', null, [
                'label' => 'label.coach_user.team'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fullName', null, [
                'label' => 'label.personal_data.full_name'
            ])
            ->add('email', null, [
                'label' => 'label.coach_user.email'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                )
            ))
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if($this->getCurrentUser()->hasRole('ROLE_COACH')){
            $query
                ->innerJoin($query->getRootAlias().'.teams', 't')
                ->innerJoin('t.coaches', 'c')
                ->andWhere('c.username LIKE :user')
                ->setParameter('user', $this->getCurrentUser()->getUsername());
        }

        return $query;
    }

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('add');
    }
}