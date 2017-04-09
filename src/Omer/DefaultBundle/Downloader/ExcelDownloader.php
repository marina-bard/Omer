<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 09.04.17
 * Time: 19:23
 */

namespace Omer\DefaultBundle\Downloader;

use Liuggio\ExcelBundle\Factory;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExcelDownloader
{
    const XLS = '.xls';

    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function download($excel, $filenameToView)
    {
        $writer = $this->factory->createWriter($excel, 'Excel5');

        $response = $this->factory->createStreamedResponse($writer);

        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            \Nette\Utils\Strings::toAscii($filenameToView)  . self::XLS
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}