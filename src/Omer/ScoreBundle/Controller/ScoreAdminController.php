<?php

namespace Omer\ScoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Omer\ScoreBundle\Entity\Point;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ScoreAdminController extends CRUDController
{
    public function createAction()
    {
        $request = $this->getRequest();

        $this->admin->checkAccess('create');
        $object = $this->admin->getNewInstance();

        $doctrine = $this->get('doctrine');

        $teamId = $request->get('id');
        $team = $doctrine->getRepository('OmerTeamBundle:BaseTeam')->find($teamId);

        if (!$team) {
            $this->addFlash(
                'sonata_flash_error',
                $this->trans('error.score.invalid_team', [],'SonataAdminBundle')
            );
            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        $scoreTypeId = $request->get('scoreTypeId');
        $scoreType = $doctrine->getRepository('OmerScoreBundle:ScoreType')->find($scoreTypeId);

        if (!$scoreType) {
            $this->addFlash(
                'sonata_flash_error',
                $this->trans('error.score.invalid_score_type', [],'SonataAdminBundle')
            );
            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        $object->setTeam($team);
        $team->addScore($object);

        if ($scoreType->getIsDependsOnProblem()) {
            $criterions = $this->get('doctrine')->getRepository('OmerScoreBundle:Criterion')->findBy([
                'problem' => $team->getProblem()->getId(),
                'scoreType' => $scoreType
            ]);
        }
        else {
            $criterions = $this->get('doctrine')->getRepository('OmerScoreBundle:Criterion')->findBy([
                'scoreType' => $scoreType
            ]);
        }

        if (!$criterions) {
            $this->addFlash(
                'sonata_flash_error',
                $this->trans('error.score.no_criterions', [],'SonataAdminBundle')
            );
            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        foreach ($criterions as $criterion) {
            $point = new Point();
            $criterion->addPoint($point);
            $point->setCriterion($criterion);
            $object->addPoint($point);
            $point->setScore($object);
        }

        $object = $this->admin->create($object);

        return $this->redirectTo($object);
    }

    public function editAction($id = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('edit', $object);

        $preResponse = $this->preEdit($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $object = $this->admin->update($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                            'objectName' => $this->escapeHtml($this->admin->toString($object)),
                        ), 200, array());
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_edit_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                } catch (LockException $e) {
                    $this->addFlash('sonata_flash_error', $this->trans('flash_lock_error', array(
                        '%name%' => $this->escapeHtml($this->admin->toString($object)),
                        '%link_start%' => '<a href="'.$this->admin->generateObjectUrl('edit', $object).'">',
                        '%link_end%' => '</a>',
                    ), 'SonataAdminBundle'));
                }
            }
            else {
                $object = $this->admin->update($object);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'error.value.out_of_range',
                            [],
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form' => $formView,
            'object' => $object,
        ), null);
    }

//    protected function redirectTo($object)
//    {
//        $request = $this->getRequest();
//
//        $url = false;
//
//        if (null !== $request->get('btn_update_and_list')) {
//            $url = $this->admin->generateUrl('list');
//        }
//        if (null !== $request->get('btn_create_and_list')) {
//            $url = $this->admin->generateUrl('list');
//        }
//
//        if (null !== $request->get('btn_create_and_create')) {
//            $params = array();
//            if ($this->admin->hasActiveSubClass()) {
//                $params['subclass'] = $request->get('subclass');
//            }
//            $url = $this->admin->generateUrl('create', $params);
//        }
//
////        if ($this->getRestMethod() === 'DELETE') {
////            $url = $this->admin->generateUrl('admin_omer_score_judgescoring_list');
////        }
//
//        if (!$url) {
//            foreach (array('edit', 'show') as $route) {
//                if ($this->admin->hasRoute($route) && $this->admin->isGranted(strtoupper($route), $object)) {
//                    $url = $this->admin->generateObjectUrl($route, $object);
//                    break;
//                }
//            }
//        }
//
//        if (!$url) {
//            $url = $this->admin->generateUrl('list');
//        }
//
//        return new RedirectResponse($url);
//    }
}
