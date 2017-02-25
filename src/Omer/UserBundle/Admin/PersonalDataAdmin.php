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


class PersonalDataAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('firstName', TextType::class, [
                'label' => 'label.personal_data.first_name',
                'translation_domain' => 'OmerUserBundle',
            ])
            ->add('surname', TextType::class, [
                'label' => 'label.personal_data.surname',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('T_shirtSize', TextType::class, [
                'label' => 'label.personal_data.t_shirt_size',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('dateOfBirth', 'sonata_type_datetime_picker', [
                'format' => 'dd.MM.yyyy',
                'label' => 'label.personal_data.date_of_birth',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('passportNumber', TextType::class, [
                'label' => 'label.personal_data.passport_number',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('dateOfIssue', 'sonata_type_datetime_picker', [
                'format' => 'dd.MM.yyyy',
                'label' => 'label.personal_data.date_of_issue',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('dateOfExpiry', 'sonata_type_datetime_picker', [
                'format' => 'dd.MM.yyyy',
                'label' => 'label.personal_data.date_of_expiry',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('citizenship', TextType::class, [
                'label' => 'label.personal_data.citizenship',
                'translation_domain' => 'OmerUserBundle'
            ])
        ;
    }
}