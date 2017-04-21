<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.04.17
 * Time: 22:41
 */

namespace Omer\ScoreBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class JudgeScoringAdmin extends AbstractAdmin
{
//    protected $baseRouteName = 'admin_omer_score_judgescoring';

//    protected $baseRoutePattern = 'omer/score/judgescoring';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('englishTeamName')
            ->add('memberNumber')
            ->add('problem')
            ->add('division')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'create_score' => array('template' => array('OmerScoreBundle:CRUD:action/list__action_create_score.html.twig')),
                    'list_scores' => array('template' => array('OmerScoreBundle:CRUD:action/list__action_list_scores.html.twig')),
                )))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('create_score', $this->getRouterIdParameter().'/create_score')
            ->add('list_scores', $this->getRouterIdParameter().'/list_scores');
    }
}