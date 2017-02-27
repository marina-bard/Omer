<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 08.02.17
 * Time: 2:36
 */

namespace Omer\TeamBundle\Builder;

use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\TeamBundle\Entity\Team;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\UserBundle\Entity\CoachUser;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TeamExcelBuilder
{
    const TEAM_INFO_FILEPATH = '/../web/temp/team_excel.xls';

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

    public function getTeamExcelFile()
    {
        return $this->container->get('kernel')->getRootDir().'/'.self::TEAM_INFO_FILEPATH;
    }

    public function buildTeamExcel(ForeignTeam $team)
    {
        $coaches = $team->getCoaches();
        $members = $team->getMembers();
        $other = $team->getOtherPeople();

        $this->excel = new PHPExcel();
        $this->sheet = $this->excel->setActiveSheetIndex(0);

        $this->sheet->setTitle($this->translator->trans('Team', [], 'OmerTeamBundle'));
        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('Team', [], 'OmerTeamBundle'));
        $this->sheet->getDefaultRowDimension()->setRowHeight(15);

        $this->sheet = $this->addTeam($this->sheet, $team, $this->label_row);

        $this->sheet = $this->addCoaches($this->sheet, $coaches, ++$this->label_row);

        $this->sheet = $this->addTeamMembers($this->sheet, $members, ++$this->label_row, $this->translator->trans('Team members', [], 'OmerTeamBundle'));

        foreach(range('A','E') as $columnID) {
            $this->sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $writer->save($this->getTeamExcelFile());

        return $this->getTeamExcelFile();
    }

    public function addTeam(PHPExcel_Worksheet $sheet, Team $team, $label_row)
    {
        $align_left = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $value_row = $label_row;
        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.native_team_name', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.english_team_name', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.member_number', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.guo', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.guo_address', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.principal_name', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.edu_dep', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.edu_dep_address', [], 'OmerTeamBundle'))
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team.head_edu_name', [], 'OmerTeamBundle'))
        ;

       $sheet
            ->setCellValue('C'.(++$value_row), $team->getNativeTeamName())
            ->setCellValue('C'.(++$value_row), $team->getEnglishTeamName())
            ->setCellValue('C'.(++$value_row), ($team->getMemberNumber()))
            ->getStyle('C'.$value_row)->applyFromArray($align_left);
       $sheet
            ->setCellValue('C'.(++$value_row), $team->getGuo())
            ->setCellValue('C'.(++$value_row), $team->getGuoAddress())
            ->setCellValue('C'.(++$value_row), $team->getPrincipalFullName())
            ->setCellValue('C'.(++$value_row), $team->getEducationDepartment())
            ->setCellValue('C'.(++$value_row), $team->getEducationDepartmentAddress())
            ->setCellValue('C'.(++$value_row), $team->getHeadOfEduFullName())
        ;

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    public function addCoaches(PHPExcel_Worksheet $sheet, $coaches, $label_row)
    {
        $this->sheet = $this->setHeader($this->sheet, ++$label_row, $this->translator->trans('coaches', [], 'OmerTeamBundle'));

        $value_row = $label_row;
        /**
         * @var CoachUser $coach
         */
        foreach ($coaches as $coach) {
            $sheet
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.surname', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.name', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.patronymic', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.latin_surname', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.latin_name', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.latin_patronymic', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.phone', [], 'OmerUserBundle'))
                ->setCellValue('B'.(++$label_row), $this->translator->trans('label.email', [], 'OmerUserBundle'))
            ;
            $label_row++;

            $sheet
                ->setCellValue('C'.(++$value_row), $coach->getSurname())
                ->setCellValue('C'.(++$value_row), $coach->getName())
                ->setCellValue('C'.(++$value_row), $coach->getPatronymic())
                ->setCellValue('C'.(++$value_row), $coach->getLatinSurname())
                ->setCellValue('C'.(++$value_row), $coach->getLatinName())
                ->setCellValue('C'.(++$value_row), $coach->getLatinPatronymic())
                ->setCellValue('C'.(++$value_row), $coach->getPhone())
                ->setCellValue('C'.(++$value_row), $coach->getEmail())
            ;
            $value_row++;
        }

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    public function addTeamMembers(PHPExcel_Worksheet $sheet, $members, $label_row, $title)
    {
        $sheet->setCellValue('B'.$label_row, $title);
        $sheet->getCell('B'.$label_row)->getStyle()->getFont()->setBold(true);
        $sheet->mergeCells('B'.$label_row.':I'.$label_row);
        $style = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $sheet->getStyle('A'.$label_row.':E'.$label_row)->applyFromArray($style);

        $sheet
            ->setCellValue('B'.(++$label_row), $this->translator->trans('label.team_member.full_name', [], 'OmerTeamBundle'))
            ->setCellValue('C'.($label_row), $this->translator->trans('label.team_member.latin_full_name', [], 'OmerTeamBundle'))
            ->setCellValue('D'.($label_row), $this->translator->trans('label.team_member.age', [], 'OmerTeamBundle'))
            ->setCellValue('E'.($label_row), $this->translator->trans('label.team_member.allergy', [], 'OmerTeamBundle'))
        ;
        $sheet->getStyle('A'.$label_row.':E'.$label_row)->applyFromArray($style);
        $sheet->getStyle('A'.$label_row.':E'.$label_row)->getFont()->setBold(true);

        $i = 0;
        $value_row = $label_row;
        $align_left = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ]
        ];

        foreach ($members as $member) {
            $sheet
                ->setCellValue('A'.(++$value_row), ++$i)
                ->setCellValue('B'.($value_row), $member)
                ->setCellValue('C'.($value_row), $member->getLatinFullName())
                ->setCellValue('D'.($value_row), $member->getAge())
                ->getStyle('D'.$value_row)->applyFromArray($align_left);
            $sheet
                ->setCellValue('E'.($value_row), $member->getAllergy())
            ;
            $sheet->getStyle('A'.$value_row.':E'.$value_row)->applyFromArray($align_left);
        }

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    public function setHeader(PHPExcel_Worksheet $sheet, $row, $title)
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

}