<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 30.03.17
 * Time: 16:40
 */

namespace Omer\UserBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class OfficialUserAdminController extends CRUDController
{
    public function getSummaryTableAction()
    {
        $request = $this->getRequest();
        $role = $request->get('role');

        $em = $this->get('doctrine')->getManager();

        if(!$role) {
            $officials = $em->getRepository('OmerUserBundle:OfficialUser')->findNotAdmin();
        }
        else {
            $officials = $em->getRepository('OmerUserBundle:OfficialUser')->findByRole($role);
        }

        $excel = $this->get('user.builder.summary_excel')->formSummaryExcel($role, $officials);

        $writer = $this->get('phpexcel')->createWriter($excel, 'Excel5');

        $response = $this->get('phpexcel')->createStreamedResponse($writer);

        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'Summary table.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}