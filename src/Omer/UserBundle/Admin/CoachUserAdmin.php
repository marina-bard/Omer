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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CoachUserAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('surname', TextType::class, [
                'label' => 'label.surname'
            ])
            ->add('name', TextType::class, [
                'label' => 'label.name'
            ])
            ->add('patronymic', TextType::class, [
                'label' => 'label.patronymic'
            ])
            ->add('latinSurname', TextType::class, [
                'label' => 'label.latin_surname'
            ])
            ->add('latinName', TextType::class, [
                'label' => 'label.latin_name'
            ])
            ->add('latinPatronymic', TextType::class, [
                'label' => 'label.latin_patronymic'
            ])
            ->add('phone', TextType::class, [
                'label' => 'label.phone'
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email'
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'required' => false,
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch'
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email', null, [
                'label' => 'label.email'
            ])
            ->add('surname', null, [
                'label' => 'label.surname'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('surname', null, [
                'label' => 'label.surname'
            ])
            ->add('name', null, [
                'label' => 'label.name'
            ])
            ->add('patronymic', null,[
                'label' => 'label.patronymic'
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
        $collection->remove('create');
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
}