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
use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\UserBundle\OmerUserBundle;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('concerns', TextareaType::class, [
                'label' => 'label.team.concerns',
                'required' => false
            ])
            ->add('paymentCurrency', ChoiceType::class, [
                'label' => 'label.team.payment_currency',
                'choices' => array_flip(ForeignTeam::PAYMENT_CURRENCY),
            ])
            ->add('travelAttributes', 'sonata_type_collection', [
                'label' => $this->getTranslator()
                    ->trans('travel_info', [], 'OmerTravelBundle'),
                'translation_domain' => 'OmerTravelBundle',
                'btn_add' => false
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;
    }
}