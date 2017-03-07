<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 08.02.17
 * Time: 2:36
 */

namespace Omer\TeamBundle\Builder;

use Omer\TeamBundle\Entity\BaseTeam;
use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\TeamBundle\Entity\OtherPeople;
use Omer\TeamBundle\Entity\Team;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\TravelBundle\Entity\TravelInfo;
use Omer\UserBundle\Entity\CoachUser;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeamExcelBuilder
{
    const TEAM_INFO_FILEPATH = '/../web/uploads/teams/';

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

    private function getTeamExcelFile($teamName)
    {
        return $this->container->get('kernel')->getRootDir().'/'.self::TEAM_INFO_FILEPATH.$teamName.'.xls';
    }

    public function buildTeamExcel(ForeignTeam $team)
    {
        $coaches = $team->getCoaches();
        $members = $team->getMembers();
        $others = $team->getOtherPeople();

        $this->excel = new PHPExcel();
        $this->sheet = $this->excel->setActiveSheetIndex(0);

        $this->sheet->setTitle($this->translator->trans('Team', [], 'OmerTeamBundle'));
        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('Team', [], 'OmerTeamBundle'));
        $this->sheet->getDefaultRowDimension()->setRowHeight(15);

        $this->sheet = $this->addTeam($this->sheet, $team, $this->label_row);

        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('travel_info', [], 'OmerTravelBundle'));

        $this->sheet = $this->addTravelInfo($this->sheet,$team, $this->label_row);

        $this->sheet = $this->addCoaches($this->sheet, $coaches, ++$this->label_row);

        $this->sheet = $this->addTeamMembers($this->sheet, $members, $this->label_row);

        $this->sheet = $this->addOtherPeople($this->sheet, $others, $this->label_row);

        foreach(range('A','M') as $columnID) {
            $this->sheet->getColumnDimension($columnID)->setAutoSize(true);

        }

        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $teamName = $team->getEnglishTeamName();
        $writer->save($this->getTeamExcelFile($teamName));

        return $this->getTeamExcelFile($teamName);
    }

    private function addTravelInfo(PHPExcel_Worksheet $sheet, ForeignTeam $team, $label_row)
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

    private function addTeam(PHPExcel_Worksheet $sheet, $team, $label_row)
    {
        $value_row = $label_row;
        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.english_team_name', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.member_number', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.school', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.country', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.district', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.city', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.address', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.problem', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.division', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.payment_currency', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.concerns', [], 'OmerTeamBundle'))
        ;

        $sheet
            ->setCellValue('C'.(++$value_row), $team->getEnglishTeamName())
            ->setCellValue('C'.(++$value_row), $team->getMemberNumber())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), $team->getSchool())
            ->setCellValue('C'.(++$value_row), $team->getCountry())
            ->setCellValue('C'.(++$value_row), $team->getDistrict())
            ->setCellValue('C'.(++$value_row), $team->getCity())
            ->setCellValue('C'.(++$value_row), $team->getAddress())
            ->setCellValue('C'.(++$value_row), $team->getProblem())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), $team->getDivision())
            ->getStyle('C'.$value_row)->applyFromArray($this->getAlignLeft());
        $sheet
            ->setCellValue('C'.(++$value_row), $team->getPaymentCurrency())
            ->setCellValue('C'.(++$value_row), $team->getConcerns())
        ;

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    private function addCoaches(PHPExcel_Worksheet $sheet, $coaches, $label_row)
    {
        $this->sheet = $this->setHeader($this->sheet, ++$label_row, $this->translator->trans('coaches', [], 'OmerTeamBundle'));

        $number = 0;

        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.first_name', [], 'OmerUserBundle'))
            ->setCellValue('C'.($label_row), $this->translator->trans('label.personal_data.surname', [], 'OmerUserBundle'))
            ->setCellValue('D'.($label_row), $this->translator->trans('label.personal_data.t_shirt_size', [], 'OmerUserBundle'))
            ->setCellValue('E'.($label_row), $this->translator->trans('label.coach_user.email', [], 'OmerUserBundle'))
            ->setCellValue('F'.($label_row), $this->translator->trans('label.personal_data.date_of_birth', [], 'OmerUserBundle'))
            ->setCellValue('G'.($label_row), $this->translator->trans('label.personal_data.passport_number', [], 'OmerUserBundle'))
            ->setCellValue('H'.($label_row), $this->translator->trans('label.personal_data.date_of_issue', [], 'OmerUserBundle'))
            ->setCellValue('I'.($label_row), $this->translator->trans('label.personal_data.date_of_expiry', [], 'OmerUserBundle'))
            ->setCellValue('J'.($label_row), $this->translator->trans('label.coach_user.address', [], 'OmerUserBundle'))
            ->setCellValue('K'.($label_row), $this->translator->trans('label.dietary_concerns', [], 'OmerUserBundle'))
            ->setCellValue('L'.($label_row), $this->translator->trans('label.medical_concerns', [], 'OmerUserBundle'))
        ;

        /**
         * @var CoachUser $coach
         */
        $value_row = $label_row;
        foreach ($coaches as $coach) {
            $number++;
            $sheet
                ->setCellValue('A'.(++$value_row), $number)
                ->setCellValue('B'.($value_row), $coach->getFirstName())
                ->setCellValue('C'.($value_row), $coach->getSurname())
                ->setCellValue('D'.($value_row), $coach->getTShirtSize())
                ->setCellValue('E'.($value_row), $coach->getEmail())
                ->setCellValue('F'.($value_row), date_format($coach->getDateOfBirth(), 'd-m-Y'))
                ->setCellValue('G'.($value_row), $coach->getPassportNumber())
                ->getStyle('G'.$value_row)->applyFromArray($this->getAlignLeft());
            $sheet
                ->setCellValue('H'.($value_row), date_format($coach->getDateOfIssue(),'d-m-Y'))
                ->setCellValue('I'.($value_row), date_format($coach->getDateOfExpiry(),'d-m-Y'))
                ->setCellValue('J'.($value_row), $coach->getAddress())
                ->setCellValue('K'.($value_row), $coach->getDietaryConcerns())
                ->setCellValue('L'.($value_row), $coach->getMedicalConcerns())
            ;
        }

        $this->label_row = ++$value_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    private function addTeamMembers(PHPExcel_Worksheet $sheet, $coaches, $label_row)
    {
        $this->sheet = $this->setHeader($this->sheet, ++$label_row, $this->translator->trans('label.team.members', [], 'OmerTeamBundle'));

        $number = 0;

        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.first_name', [], 'OmerUserBundle'))
            ->setCellValue('C'.($label_row), $this->translator->trans('label.personal_data.surname', [], 'OmerUserBundle'))
            ->setCellValue('D'.($label_row), $this->translator->trans('label.personal_data.t_shirt_size', [], 'OmerUserBundle'))
            ->setCellValue('E'.($label_row), $this->translator->trans('label.personal_data.date_of_birth', [], 'OmerUserBundle'))
            ->setCellValue('F'.($label_row), $this->translator->trans('label.personal_data.passport_number', [], 'OmerUserBundle'))
            ->setCellValue('G'.($label_row), $this->translator->trans('label.personal_data.date_of_issue', [], 'OmerUserBundle'))
            ->setCellValue('H'.($label_row), $this->translator->trans('label.personal_data.date_of_expiry', [], 'OmerUserBundle'))
            ->setCellValue('I'.($label_row), $this->translator->trans('label.coach_user.address', [], 'OmerUserBundle'))
            ->setCellValue('J'.($label_row), $this->translator->trans('label.dietary_concerns', [], 'OmerUserBundle'))
            ->setCellValue('K'.($label_row), $this->translator->trans('label.medical_concerns', [], 'OmerUserBundle'))
        ;

        /**
         * @var TeamMember $coach
         */
        $value_row = $label_row;
        foreach ($coaches as $coach) {
            $number++;
            $sheet
                ->setCellValue('A'.(++$value_row), $number)
                ->setCellValue('B'.($value_row), $coach->getFirstName())
                ->setCellValue('C'.($value_row), $coach->getSurname())
                ->setCellValue('D'.($value_row), $coach->getTShirtSize())
                ->setCellValue('E'.($value_row), date_format($coach->getDateOfBirth(), 'd-m-Y'))
                ->setCellValue('F'.($value_row), $coach->getPassportNumber())
                ->getStyle('F'.$value_row)->applyFromArray($this->getAlignLeft());
            $sheet
                ->setCellValue('G'.($value_row), date_format($coach->getDateOfIssue(), 'd-m-Y'))
                ->setCellValue('H'.($value_row), date_format($coach->getDateOfExpiry(), 'd-m-Y'))
                ->setCellValue('I'.($value_row), $coach->getAddress())
                ->setCellValue('G'.($value_row), $coach->getDietaryConcerns())
                ->setCellValue('K'.($value_row), $coach->getMedicalConcerns())
            ;
        }

        $this->label_row = ++$value_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    private function addOtherPeople(PHPExcel_Worksheet $sheet, $coaches, $label_row)
    {
        $this->sheet = $this->setHeader($this->sheet, ++$label_row, $this->translator->trans('label.team.other_people', [], 'OmerTeamBundle'));

        $number = 0;

        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.personal_data.first_name', [], 'OmerUserBundle'))
            ->setCellValue('C'.($label_row), $this->translator->trans('label.personal_data.surname', [], 'OmerUserBundle'))
            ->setCellValue('D'.($label_row), $this->translator->trans('label.personal_data.t_shirt_size', [], 'OmerUserBundle'))
            ->setCellValue('E'.($label_row), $this->translator->trans('label.other_people.team_role', [], 'OmerTeamBundle'))
            ->setCellValue('F'.($label_row), $this->translator->trans('label.other_people.email', [], 'OmerTeamBundle'))
            ->setCellValue('G'.($label_row), $this->translator->trans('label.personal_data.date_of_birth', [], 'OmerUserBundle'))
            ->setCellValue('H'.($label_row), $this->translator->trans('label.personal_data.passport_number', [], 'OmerUserBundle'))
            ->setCellValue('I'.($label_row), $this->translator->trans('label.personal_data.date_of_issue', [], 'OmerUserBundle'))
            ->setCellValue('J'.($label_row), $this->translator->trans('label.personal_data.date_of_expiry', [], 'OmerUserBundle'))
            ->setCellValue('K'.($label_row), $this->translator->trans('label.other_people.address', [], 'OmerTeamBundle'))
            ->setCellValue('L'.($label_row), $this->translator->trans('label.dietary_concerns', [], 'OmerTeamBundle'))
            ->setCellValue('M'.($label_row), $this->translator->trans('label.medical_concerns', [], 'OmerTeamBundle'))
        ;

        /**
         * @var OtherPeople $coach
         */
        $value_row = $label_row;
        foreach ($coaches as $coach) {
            $number++;
            $sheet
                ->setCellValue('A'.(++$value_row), $number)
                ->setCellValue('B'.($value_row), $coach->getFirstName())
                ->setCellValue('C'.($value_row), $coach->getSurname())
                ->setCellValue('D'.($value_row), $coach->getTShirtSize())
                ->setCellValue('E'.($value_row), $coach->getTeamRole())
                ->setCellValue('F'.($value_row), $coach->getEmail())
                ->setCellValue('G'.($value_row), date_format($coach->getDateOfBirth(), 'd-m-Y'))
                ->setCellValue('H'.($value_row), $coach->getPassportNumber())
                ->getStyle('H'.$value_row)->applyFromArray($this->getAlignLeft());
            $sheet
                ->setCellValue('I'.($value_row), date_format($coach->getDateOfIssue(), 'd-m-Y'))
                ->setCellValue('J'.($value_row), date_format($coach->getDateOfExpiry(), 'd-m-Y'))
                ->setCellValue('K'.($value_row), $coach->getAddress())
                ->setCellValue('L'.($value_row), $coach->getDietaryConcerns())
                ->setCellValue('M'.($value_row), $coach->getMedicalConcerns())
            ;
        }

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