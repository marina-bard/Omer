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
        $data = "";
        if($this->getSubject()) {
            $type = $this->getSubject()->getType();
            $data = $this->getTranslator()->trans(array_search($type,TravelInfo::TYPE), [], 'OmerTravelBundle');
        }
        $formMapper
            ->add('type', null, [
                'label' => 'label.type',
                'data' => $data,
                'mapped' => false,
                'attr' => [
                    'readonly' => true
                ],
            ])
            ->add('date', 'sonata_type_date_picker', [
                'label' => 'label.date',
                'format' => 'dd.MM.yyyy',
                'dp_default_date' => '23.04.2017',
                'dp_min_date' => '18.04.2017',
                'dp_max_date' => '02.05.2017',
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('goBy', ChoiceType::class, [
                'label' => 'label.go_by',
                'choices' => array_flip(TravelInfo::TRANSPORT)
            ])
            ->add('transportNumber', TextType::class, [
                'label' => 'label.transport_number',
                'required' => false
            ])
            ->add('stationFrom', TextType::class, [
                'label' => 'label.from',
                'required' => false
            ])
            ->add('stationTo', TextType::class, [
                'label' => 'label.to',
                'required' => false
            ])
            ->add('time', TextType::class, [
                'label' => 'label.time',
                'required' => false,
                'attr' => [
                    'placeholder' => 'placeholder.time'
                ]
            ])
        ;
    }
}