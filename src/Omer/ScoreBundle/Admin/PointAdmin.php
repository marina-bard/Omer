<?php

namespace Omer\ScoreBundle\Admin;

use Omer\ScoreBundle\Entity\Criterion;
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

        $criterion = $this->getSubject()->getCriterion();
        $this->buildTree($criterion);

        $childIds = $this->getChildNodesIds($criterion);
        $childIds = $this->arrayToString($childIds);

        $parentNode = $this->getParentNode($criterion);
        $formMapper
            ->add('value', NumberType::class, [
                'required' => true,
                'attr' => [
                    'parent_id' => $parentNode,
                    'child_nodes_ids' => $childIds,
                    'placeholder' => $placeholder
                ]
            ]);
    }

    private function getChildNodesIds(Criterion $criterion)
    {
        $childNodes = $criterion->getChildNodes();
        $ids = [];
        foreach ($childNodes as $node) {
            $ids[] = $node->getId();
        }

        return $ids;
    }

    private function buildTree(Criterion $criterion)
    {
        $this->getConfigurationPool()->getContainer()->get('doctrine')
            ->getRepository('OmerScoreBundle:Criterion')
            ->getTree($criterion->getRootMaterializedPath());
    }

    private function arrayToString($array)
    {
        if ($array) {
            return implode(',', $array);
        }
        else {
            return '0';
        }
    }

    private function getParentNode(Criterion $criterion)
    {
        if ($criterion->getMaterializedPath()) {
            return $criterion->getParentNode()->getId();
        }
        else {
            return '0';
        }
    }
}
