<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Omer\TeamBundle\Entity\ForeignTeam;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            ]);
        if ($this->getSubject()->getProblemT()) {
            $formMapper
                ->add('problem_t', TextType::class, [
                'label' => 'label.team.problem',
                'required' => false
            ]);
        }
            //@toDo move 'problem' and 'division' to BaseTeamAdmin after '_t' fields removing
        $formMapper
            ->add('problem', null, [
                'label' => 'label.team.problem',
                'expanded' => true,
                'required' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')->orderBy('p.type');
                }
            ]);
        if ($this->getSubject()->getDivisionT()) {
            $formMapper
                ->add('division_t', TextType::class, [
                    'label' => 'label.team.division',
                    'required' => false
                ]);
        }
        $formMapper
            ->add('division', null, [
                'label' => 'label.team.division',
                'expanded' => true,
                'required' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')->orderBy('p.number');
                }
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