<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 08.02.17
 * Time: 2:36
 */

namespace Omer\TeamBundle\Builder;

use Omer\TravelBundle\Entity\TravelInfo;
use Omer\UserBundle\Entity\OfficialUser;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class OfficialUserExcelBuilder
{
    const USER_INFO_FILEPATH = '/../web/uploads/official_users/';

    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var PHPExcel $excel
     */
    protected $excel;

    /**
     * @var PHPExcel_Worksheet $sheet
     */
    protected $sheet;

    protected $translator;

    private $label_row;

    private $value_row;

    public function __construct($container)
    {
        $this->container = $container;
        $this->translator = $this->container->get('translator');
        $this->label_row = 0;
        $this->value_row = 0;
    }

    private function getUserExcelFile($fileName)
    {
        return $this->container->get('kernel')->getRootDir().'/'.self::USER_INFO_FILEPATH.$fileName.'.xls';
    }

    public function buildOfficialUserExcel(OfficialUser $user)
    {
        $this->excel = new PHPExcel();
        $this->sheet = $this->excel->setActiveSheetIndex(0);

        $role = $user->getRoles()[0];

        $role = $this->translator->trans(array_search($role, OfficialUser::ROLES), [], 'OmerUserBundle');

        $this->sheet->setTitle($this->translator->trans($role, [], 'OmerUserBundle'));
        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans($role, [], 'OmerUserBundle'));
        $this->sheet->getDefaultRowDimension()->setRowHeight(15);

        $this->sheet = $this->addMainInfo($this->sheet, $user, $this->label_row);

        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('travel_info', [], 'OmerTravelBundle'));

        $this->sheet = $this->addTravelInfo($this->sheet, $user, $this->label_row);

        foreach(range('A','C') as $columnID) {
            $this->sheet->getColumnDimension($columnID)->setAutoSize(true);

        }

        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

        $fileName = $user->getAssociation() . ' - ' . $role . ' - ' . $user->getFirstName() . ' ' . $user->getSurname() . ' - ' . date('d-m-Y H:i:s');
        $writer->save($this->getUserExcelFile($fileName));

        return $this->getUserExcelFile($fileName);
    }

    private function addTravelInfo(PHPExcel_Worksheet $sheet, OfficialUser $team, $label_row)
    {
        $travels = $team->getTravelAttributes();
        /**
         * @var TravelInfo $arrival
         */
        $arrival = $travels[0];
        $departures = $travels[1];
        $value_row = $label_row;
        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.date_of_arrival', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.go_by', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.transport_number', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.depart_from', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.arrive_to', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.arrival_time', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.date_of_departure', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.go_by', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.transport_number', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.depart_from', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.arrive_to', [], 'OmerTravelBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.arrival_time', [], 'OmerTravelBundle'))
        ;

        $sheet
            ->setCellValue('C'.(++$value_row), date_format($arrival->getDate(), 'd-m-Y'))
            ->setCellValue('C'.(++$value_row), $this->translator->trans($arrival->getGoBy(), [], 'OmerTravelBundle'))
            ->setCellValue('C'.(++$value_row), $arrival->getTransportNumber())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), $arrival->getStationFrom())
            ->setCellValue('C'.(++$value_row), $arrival->getStationTo())
            ->setCellValue('C'.(++$value_row), $arrival->getTime());
        $sheet
            ->setCellValue('C'.(++$value_row), date_format($departures->getDate(), 'd-m-Y'))
            ->setCellValue('C'.(++$value_row), $this->translator->trans($departures->getGoBy(), [], 'OmerTravelBundle'))
            ->setCellValue('C'.(++$value_row), $departures->getTransportNumber())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), $departures->getStationFrom())
            ->setCellValue('C'.(++$value_row), $departures->getStationTo())
            ->setCellValue('C'.(++$value_row), $departures->getTime())
        ;

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    private function addMainInfo(PHPExcel_Worksheet $sheet, OfficialUser $user, $label_row)
    {
        $number = 0;

        $value_row = $label_row;

        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.first_name', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.surname', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.user.gender', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.t_shirt_size', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.user.association', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.citizenship', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.user.address', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.date_of_birth', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.passport_number', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.date_of_issue', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.date_of_expiry', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.user.mobile_phone', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.dietary_concerns', [], 'OmerUserBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.medical_concerns', [], 'OmerUserBundle'))
        ;

        $sheet
            ->setCellValue('C'.(++$value_row), $user->getFirstName())
            ->setCellValue('C'.(++$value_row), $user->getSurname())
            ->setCellValue('C'.(++$value_row), $this->translator->trans($user->getGender(), [], 'OmerUserBundle'))
            ->setCellValue('C'.(++$value_row), $user->getTShirtSize())
            ->setCellValue('C'.(++$value_row), $user->getAssociation())
            ->setCellValue('C'.(++$value_row), $user->getCitizenship())
            ->setCellValue('C'.(++$value_row), $user->getAddress())
            ->setCellValue('C'.(++$value_row), date_format($user->getDateOfBirth(), 'd-m-Y'))
            ->setCellValue('C'.(++$value_row), $user->getPassportNumber())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), date_format($user->getDateOfIssue(),'d-m-Y'))
            ->setCellValue('C'.(++$value_row), date_format($user->getDateOfExpiry(),'d-m-Y'))
            ->setCellValue('C'.(++$value_row), $user->getMobilePhone())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), $user->getDietaryConcerns())
            ->setCellValue('C'.(++$value_row), $user->getMedicalConcerns())
        ;

        $this->label_row = ++$value_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    private function setHeader(PHPExcel_Worksheet $sheet, $row, $title)
    {
        /**
         * @var PHPExcel_Worksheet $sheet
         */
        $sheet->setCellValue('B'.$row, $title);
        $sheet->getCell('B'.$row)->getStyle()->getFont()->setBold(true);
        $sheet->mergeCells('B'.$row.':C'.$row);
        $style = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $sheet->getStyle('B'.$row.':C'.$row)->applyFromArray($style);

        return $sheet;
    }

    private function getAlignLeft()
    {
        return $align_left = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ]
        ];
    }

}