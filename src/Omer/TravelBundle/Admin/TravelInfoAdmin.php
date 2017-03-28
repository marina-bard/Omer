<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 19.03.17
 * Time: 23:24
 */

namespace Omer\TravelBundle\Admin;

use Omer\TravelBundle\Entity\TravelInfo;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TravelInfoAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', ChoiceType::class, [
                'label' => 'label.type',
                'choices' => TravelInfo::TYPE,
                'attr' => [
                    'disabled' => true
                ]
            ])
            ->add('date', 'sonata_type_date_picker', [
                'label' => 'label.date',
                'format' => 'dd.MM.yyyy',
                'dp_min_date' => '18.04.2017',
                'dp_max_date' => '02.04.2017',
                'dp_default_date' => '23.04.2017',
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('goBy', ChoiceType::class, [
                'label' => 'label.go_by',
                'choices' => array_flip(TravelInfo::TRANSPORT)
            ])
            ->add('transportNumber', TextType::class, [
                'label' => 'label.transport_number'
            ])
            ->add('stationFrom', TextType::class, [
                'label' => 'label.from'
            ])
            ->add('stationTo', TextType::class, [
                'label' => 'label.to'
            ])
            ->add('time', TextType::class, [
                'label' => 'label.time',
                'attr' => [
                    'placeholder' => 'placeholder.time'
                ]
            ])
        ;
    }
}