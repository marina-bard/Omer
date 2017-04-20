<?php

namespace Omer\ScoreBundle\Admin;

use Omer\UserBundle\Entity\OfficialUser;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ScoreAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('team', null, [
                'required' => true
            ])
            ->add('judge', 'sonata_type_model', [
                'multiple' => false,
                'required' => true,
                'btn_add' => false,
                'query' => $this->getConfigurationPool()
                    ->getContainer()
                    ->get('doctrine')
                    ->getRepository('OmerUserBundle:OfficialUser')
                    ->findByRoleQB('ROLE_JUDGE')
            ], [
                'admin_code' => 'sonata.admin.official_user'
            ])
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
            ->add('judge', null, [
                'admin_code' => 'sonata.admin.official_user'
            ])
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
