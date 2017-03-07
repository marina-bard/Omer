<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 23:00
 */

namespace Omer\UserBundle\Admin;

use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CoachUserAdmin extends PersonalDataAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->add('address', TextType::class, [
                'label' => 'label.coach_user.address'
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.coach_user.email'
            ])
            ->add('dietaryConcerns', TextareaType::class, [
                'label' => 'label.dietary_concerns'
            ])
            ->add('medicalConcerns', TextareaType::class, [
                'label' => 'label.medical_concerns'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => false,
                'type' => 'password',
                'options' => ['translation_domain' => 'FOSUserBundle'],
                'first_options' => ['label' => 'form.password'],
                'second_options' => ['label' => 'form.password_confirmation'],
                'invalid_message' => 'fos_user.password.mismatch'
            ]);
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email', null, [
                'label' => 'label.coach_user.email'
            ])
            ->add('surname', null, [
                'label' => 'label.coach_user.surname'
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
//                    'show' => array(),
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

    public function preUpdate($object) {
        $um = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
        $um->updateCanonicalFields($object);
        $um->updatePassword($object);
    }

    public function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('add');
    }
}