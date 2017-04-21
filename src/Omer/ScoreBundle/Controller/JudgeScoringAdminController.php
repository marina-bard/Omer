<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 20.04.17
 * Time: 23:04
 */

namespace Omer\ScoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JudgeScoringAdminController extends CRUDController
{
    public function listScoresAction()
    {
        return new RedirectResponse($this->generateUrl(
            'admin_omer_score_score_list', [
                'id' => $this->admin->getSubject()->getId()
            ]));
    }

    public function createScoreAction()
    {
        $scoreTypes = $this->get('doctrine')->getRepository('OmerScoreBundle:ScoreType')->findAll();

        return $this->render('OmerScoreBundle:CRUD:new_score.html.twig',[
            'scoreTypes' => $scoreTypes,
            'teamId' => $this->admin->getSubject()->getId()
        ]);
    }

}