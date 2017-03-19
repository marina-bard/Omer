<?php

namespace Omer\TravelBundle\Form;

use Omer\TravelBundle\Entity\TravelInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravelInfoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-date-format' => 'DD-MM-YYYY',
                    'data-date-view-mode' => 'days',
                    'data-date-start-date' => '18-04-2017',
                    'data-date-end-date' => '02-05-2017',
                    'data-date-locale' => 'label.locale',
                ]
            ])
            ->add('goBy', ChoiceType::class, [
                'choices' => array_flip(TravelInfo::TRANSPORT),
                'choice_translation_domain' => 'OmerTravelBundle',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('transportNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.transport_number'
                ]
            ])
            ->add('stationFrom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.depart_from'
                ]
            ])
            ->add('stationTo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.arrive_to'
                ]
            ])
            ->add('time', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'placeholder.time'
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Omer\TravelBundle\Entity\TravelInfo',
            'translation_domain' => 'OmerTravelBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omer_travelbundle_travelinfo';
    }
}
