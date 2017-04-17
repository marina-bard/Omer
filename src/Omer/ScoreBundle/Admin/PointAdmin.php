<?php

namespace Omer\ScoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sonata\AdminBundle\Show\ShowMapper;

class PointAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('criterion')
        ;

        $criterion = $this->getSubject()->getCriterion();
        if ($criterion->getIsBoundaryValues()) {
            $placeholder = $criterion->getMinValue() . ' or ' . $criterion->getMaxValue();
        }
        else {
            $placeholder = $criterion->getMinValue() . ' to ' . $criterion->getMaxValue();
        }

        if (!$criterion->getChildNodes()) {
            $formMapper
                ->add('value', NumberType::class, [
                    'attr' => [
                        'readonly' => true,
                        'placeholder' => $placeholder
                    ]
                ]);
        }
        else {
            $formMapper
                ->add('value', NumberType::class, [
                    'attr' => [
                        'placeholder' => $placeholder
                    ]
                ]);
        }
    }
}
