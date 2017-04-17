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
            ->add('parentNode'. 'string', [
                // 'template' => 'OmerScoreBundle:Admin:list__tree_parentNode.html.twig'
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
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

        $object = $this->getSubject();
        if ($object && $object->getId()) {
            $this->buildTree($object);
        }

        $formMapper
            ->add('parentNode', 'sonata_type_model' ,[
                'multiple' => false,
                'class' => Criterion::class
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
            ->add('maxValue')
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
