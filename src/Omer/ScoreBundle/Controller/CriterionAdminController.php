<?php

namespace Omer\ScoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CriterionAdminController extends CRUDController
{
    public function listAction(Request $request = null)
    {
        if ($request->get('filter') || $request->get('filters')) {
            return new RedirectResponse($this->admin->generateUrl('list', $request->query->all()));
        }

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('OmerScoreBundle:Criterion');

        $criterions = $repository->getRootNodes();

        foreach ($criterions as &$criterion) {
            $criterion = $repository->getTree($criterion->getRootMaterializedPath());
        }
        unset($criterion);

        $datagrid = $this->admin->getDatagrid();

        $formView = $datagrid->getForm()->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render('OmerScoreBundle:Admin:list__tree.html.twig', array(
            'action' => 'tree',
            'criterion' => $criterions,
            'form' => $formView,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    public function createAction()
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                'SonataAdminBundle:CRUD:select_subclass.html.twig',
                array(
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ),
                null,
                $request
            );
        }

        $object = $this->admin->getNewInstance();

        $em = $this->get('doctrine')->getManager();

        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        if ($request->isMethod('POST')) {
           $object = $this->admin->create($object);

           $form->submit($request->request->get($form->getName()));
           if ($form->isSubmitted()) {


               //TODO: remove this check for 4.0
               if (method_exists($this->admin, 'preValidate')) {
                   $this->admin->preValidate($object);
               }
               $isFormValid = $form->isValid();

               // persist if the form was valid and if in preview mode the preview was approved
               if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                   $this->admin->checkAccess('create', $object);

                   try {
                         $object = $this->admin->update($object);

                       if ($this->isXmlHttpRequest()) {
                           return $this->renderJson(array(
                               'result' => 'ok',
                               'objectId' => $this->admin->getNormalizedIdentifier($object),
                           ), 200, array());
                       }

                       $this->addFlash(
                           'sonata_flash_success',
                           $this->trans(
                               'flash_create_success',
                               array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                               'SonataAdminBundle'
                           )
                       );

                       // redirect to edit mode
                       return $this->redirectTo($object);
                   } catch (ModelManagerException $e) {
                       $this->handleModelManagerException($e);

                       $isFormValid = false;
                   }
               }

               // show an error message if the form failed validation
               if (!$isFormValid) {
                   if (!$this->isXmlHttpRequest()) {
                       $this->addFlash(
                           'sonata_flash_error',
                           $this->trans(
                               'flash_create_error',
                               array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                               'SonataAdminBundle'
                           )
                       );
                   }
               } elseif ($this->isPreviewRequested()) {
                   // pick the preview template if the form was valid and preview was requested
                   $templateKey = 'preview';
                   $this->admin->getShow();
               }
           }
        }
        // $form->handleRequest($request);

        $formView = $form->createView();

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form' => $formView,
            'object' => $object,
        ), null);
    }
}
