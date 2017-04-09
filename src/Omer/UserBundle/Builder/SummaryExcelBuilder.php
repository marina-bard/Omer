<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 30.03.17
 * Time: 16:59
 */

namespace Omer\UserBundle\Builder;

use Doctrine\Tests\Common\DataFixtures\OrderedFixture1;
use Omer\TravelBundle\Entity\TravelInfo;
use Omer\UserBundle\Entity\OfficialUser;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SummaryExcelBuilder
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    protected $translator;

    const PREFIX = 'FILE_';

    public function __construct($container)
    {
        $this->container = $container;
        $this->translator = $this->container->get('translator');
    }

    public function formSummaryExcel($role, $users)
    {
        $excel = new \PHPExcel();
        $sheet = $excel->setActiveSheetIndex(0);

        $row = 1;
        $column = 'A';
        if ($role) {
            $role = $this->translator->trans(array_search($role, OfficialUser::ROLES), [], 'OmerUserBundle');
        }
        $sheet->getDefaultRowDimension()->setRowHeight(15);

        $sheet
            ->setCellValue(($column++).$row,'№')
            ->setCellValue(($column++).$row, $this->translator->trans('label.user.role', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.first_name', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.surname', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.user.gender', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.t_shirt_size', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.user.association', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.user.email', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.citizenship', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.user.address', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.date_of_birth', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.passport_number', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.date_of_issue', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.personal_data.date_of_expiry', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.user.mobile_phone', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.dietary_concerns_short', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.medical_concerns_short', [], 'OmerUserBundle'))
            ->setCellValue(($column++).($row), $this->translator->trans('label.user.preferences', [], 'OmerUserBundle'))

            ->setCellValue(($column++).$row, $this->translator->trans('label.native.surname', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.native.first_name', [], 'OmerUserBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.native.patronymic', [], 'OmerUserBundle'))

            ->setCellValue(($column++).$row, $this->translator->trans('label.date_of_arrival', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.go_by', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.transport_number', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.depart_from', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.arrive_to', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.arrival_time', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.date_of_departure', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.go_by', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.transport_number', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.depart_from', [], 'OmerTravelBundle'))
            ->setCellValue(($column++).$row, $this->translator->trans('label.arrive_to', [], 'OmerTravelBundle'))
            ->setCellValue(($column).($row++), $this->translator->trans('label.arrival_time', [], 'OmerTravelBundle'));

        /**
         * @var OfficialUser $user
         */
        $i = 0;
        foreach ($users as $user) {
            $column = 'A';
            $i++;

            $roles = $user->getRoles();
            $arrival = $user->getTravelAttributes()[0];
            $departures = $user->getTravelAttributes()[1];
            $role = reset($roles);
            $sheet
                ->setCellValue(($column++).$row, $i)
                ->setCellValue(($column++).$row, $this->translator->trans(array_search($role, OfficialUser::ROLES), [], 'OmerUserBundle'))
                ->setCellValue(($column++).$row, $user->getFirstName())
                ->setCellValue(($column++).$row, $user->getSurname())
                ->setCellValue(($column++).$row, $this->translator->trans(OfficialUser::GENDER[$user->getGender()], [], 'OmerUserBundle'))
                ->setCellValue(($column++).$row, $user->getTShirtSize())
                ->setCellValue(($column++).$row, $user->getAssociation())
                ->setCellValue(($column++).$row, $user->getEmail())
                ->setCellValue(($column++).$row, $user->getCitizenship())
                ->setCellValue(($column++).$row, $user->getAddress())
                ->setCellValue(($column++).$row, date_format($user->getDateOfBirth(), 'd-m-Y'))
                ->setCellValue(($column++).$row, $user->getPassportNumber())
                ->setCellValue(($column++).$row, date_format($user->getDateOfIssue(),'d-m-Y'))
                ->setCellValue(($column++).$row, date_format($user->getDateOfExpiry(),'d-m-Y'))
                ->setCellValue(($column++).$row, $user->getMobilePhone())
                ->setCellValue(($column++).$row, $user->getDietaryConcerns())
                ->setCellValue(($column++).$row, $user->getMedicalConcerns())
                ->setCellValue(($column).$row, "-");

            if ($role == 'ROLE_JUDGE') {
                $prefs = "";
                if ($user->getPreferences()) {
                    foreach ($user->getPreferences() as $item) {
                        $prefs .= $this->translator->trans(array_search($item,OfficialUser::PREFERENCES), [], 'OmerUserBundle') . ", ";
                    }
                    $sheet->setCellValue(($column).$row, $prefs);
                }
            }

            $column++;
            $sheet
                ->setCellValue(($column++).$row, $user->getNativeSurname())
                ->setCellValue(($column++).$row, $user->getNativeFirstName())
                ->setCellValue(($column++).$row, $user->getNativePatronymic())


                ->setCellValue(($column++).$row, date_format($arrival->getDate(), 'd-m-Y'))
                ->setCellValue(($column++).$row, $this->translator->trans(TravelInfo::TRANSPORT[$arrival->getGoBy()], [], 'OmerTravelBundle'))
                ->setCellValue(($column++).$row, $arrival->getTransportNumber())
                ->setCellValue(($column++).$row, $arrival->getStationFrom())
                ->setCellValue(($column++).$row, $arrival->getStationTo())
                ->setCellValue(($column++).$row, $arrival->getTime())
                ->setCellValue(($column++).$row, date_format($departures->getDate(), 'd-m-Y'))
                ->setCellValue(($column++).$row, $this->translator->trans(TravelInfo::TRANSPORT[$arrival->getGoBy()], [], 'OmerTravelBundle'))
                ->setCellValue(($column++).$row, $departures->getTransportNumber())
                ->setCellValue(($column++).$row, $departures->getStationFrom())
                ->setCellValue(($column++).$row, $departures->getStationTo())
                ->setCellValue(($column).$row, $departures->getTime());
            $row++;
        }

        $row--;
        $sheet->getStyle('A1:'. $column . '1')->getFont()->setBold(true);
        $sheet->getStyle('A1:'. $column . $row)->applyFromArray($this->getAlignLeft());
        $sheet->getStyle('A1:'. $column . $row)->applyFromArray($this->setTableBorder());

        foreach(range('A', 'Z') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        foreach(range('A', 'F') as $columnID) {
            $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
        }

        return $excel;
    }

    private function getTempExcelFile()
    {
        $temp_file_name = tempnam(sys_get_temp_dir(), self::PREFIX);
        $temp_out_file_name = $temp_file_name.'.xls';
        return $temp_out_file_name;
    }

    private function getAlignLeft()
    {
        return $align_left = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ]
        ];
    }

    private function setTableBorder()
    {
        return [
            'borders' => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
    }
}