<?php

namespace Omer\ScoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Omer\ScoreBundle\Entity\Criterion;
use Omer\ScoreBundle\Entity\ScoreType;
use Omer\CompetitionBundle\Entity\Problem;

class CriterionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('minValue')
            ->add('maxValue')
            ->add('isBoundaryValues')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('parentNode'. 'string')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();
        if ($object && $object->getId()) {
            $this->buildTree($object);
            $formMapper
                ->add('parentNode', 'sonata_type_model' ,[
                    'multiple' => false,
                    'class' => Criterion::class,
                    'query' => $this->getConfigurationPool()
                        ->getContainer()
                        ->get('doctrine')
                        ->getRepository('OmerScoreBundle:Criterion')
                        ->getTreeExceptNodeAndItsChildrenQB($this->getSubject())
                ])
            ;
        }
        else {
            $formMapper
                ->add('parentNode', 'sonata_type_model' ,[
                    'multiple' => false,
                    'required' => false,
                    'class' => Criterion::class,
                ])
            ;
        }

        $formMapper
            ->add('title')
            ->add('minValue')
            ->add('maxValue')
            ->add('isBoundaryValues')
            ->add('scoreType', null, [
                'required' => true,
                'multiple' => false,
            ])
            ->add('problem', null, [
                'multiple' => false,
                'required' => true,
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('minValue')
            ->add('maxVxalue')
            ->add('isBoundaryValues')
        ;
    }

    public function buildTree(Criterion $criterion)
    {
        $this->getConfigurationPool()->getContainer()->get('doctrine')
            ->getRepository('OmerScoreBundle:Criterion')
            ->getTree($criterion->getRootMaterializedPath());
    }
}
