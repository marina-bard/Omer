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

        return $this->get('omer_default.downloader.excel')->download($excel, 'Summary_Table_' . date('d.m.Y_H:i:s'));
    }
}