<?php

namespace Omer\ScoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Omer\ScoreBundle\Entity\Point;

class ScoreAdminController extends CRUDController
{
    public function createAction()
    {
        $request = $this->getRequest();
        $teamId = $request->get('id');
        // the key used to lookup the template
//        $templateKey = 'edit';
//
        $this->admin->checkAccess('create');
//
//        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());
//
//        if ($class->isAbstract()) {
//            return $this->render(
//                'SonataAdminBundle:CRUD:select_subclass.html.twig',
//                array(
//                    'base_template' => $this->getBaseTemplate(),
//                    'admin' => $this->admin,
//                    'action' => 'create',
//                ),
//                null,
//                $request
//            );
//        }

        $object = $this->admin->getNewInstance();

//        $preResponse = $this->preCreate($request, $object);
//        if ($preResponse !== null) {
//            return $preResponse;
//        }

//        dump($teamId);
        if ($teamId) {
            $team = $this->get('doctrine')->getRepository('OmerTeamBundle:BaseTeam')->find($teamId);
            $object->setTeam($team);
            $team->addScore($object);

            $criterions = $this->get('doctrine')->getRepository('OmerScoreBundle:Criterion')->findBy(['problem' => $team->getProblem()->getId()]);
            foreach ($criterions as $criterion) {
                $point = new Point();
                $criterion->addPoint($point);
                $point->setCriterion($criterion);
                $object->addPoint($point);
                $point->setScore($object);
            }
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

}
