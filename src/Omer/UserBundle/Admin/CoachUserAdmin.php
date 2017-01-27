<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 23:00
 */

namespace Omer\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CoachUserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('surname', TextType::class)
            ->add('name', TextType::class)
            ->add('patronymic', TextType::class)
            ->add('phone', NumberType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'required' => false
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('surname')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
        ;
    }
}