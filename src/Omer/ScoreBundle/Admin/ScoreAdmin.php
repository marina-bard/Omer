<?php

namespace Omer\ScoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ScoreAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('points', 'sonata_type_collection', [
                'required' => true,
                'label' => false,
                'btn_add' => false,
                'type_options' => array('delete' => false),
                'data_class' => null
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )))
        ;
    }

    public function postUpdate($object)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $points = $object->getPoints();
        foreach ($points as $point) {
            if (!$point->getCriterion()->getMaterializedPath()) {
                $object->setTotalScore($point->getValue());
                $em->merge($object);
            }
        }
        $em->flush();
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.team', ':id')
        );
        $query->setParameter('id', $this->getRequest()->get('id'));
        return $query;
    }
}
