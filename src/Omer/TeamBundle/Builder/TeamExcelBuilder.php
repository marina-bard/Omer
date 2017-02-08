<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 08.02.17
 * Time: 2:36
 */

namespace Omer\TeamBundle\Builder;

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

    public function buildTeamExcel(Team $team)
    {
        $coach = $team->getMainCoach();
        $members = $team->getMembers();

        $this->excel = new PHPExcel();
        $this->sheet = $this->excel->setActiveSheetIndex(0);

        $this->sheet->setTitle($this->translator->trans('Team', [], 'OmerTeamBundle'));
        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('Team', [], 'OmerTeamBundle'));
        $this->sheet->getDefaultRowDimension()->setRowHeight(15);

        $this->sheet = $this->addTeam($this->sheet, $team, $this->label_row, $this->label_row);

        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('Coach', [], 'OmerTeamBundle'));
        $this->sheet = $this->addCoach($this->sheet, $coach, $this->label_row, $this->label_row);

        $this->sheet = $this->setHeader($this->sheet, ++$this->label_row, $this->translator->trans('Team members', [], 'OmerTeamBundle'));
        $this->sheet = $this->addTeamMembers($this->sheet, $members, $this->label_row, $this->label_row);

        $this->sheet->getColumnDimension('A')->setAutoSize(true);
        $this->sheet->getColumnDimension('B')->setAutoSize(true);

        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $writer->save($this->getTeamExcelFile());

        return $this->getTeamExcelFile();
    }

    public function addTeam(PHPExcel_Worksheet $sheet, Team $team, $label_row, $value_row)
    {
        $sheet
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.native_team_name', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.english_team_name', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.member_number', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.guo', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.guo_address', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.principal_name', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.edu_dep', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.edu_dep_address', [], 'OmerTeamBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team.head_edu_name', [], 'OmerTeamBundle'))
        ;

       $sheet
            ->setCellValue('B'.(++$value_row), $team->getNativeTeamName())
            ->setCellValue('B'.(++$value_row), $team->getEnglishTeamName())
            ->setCellValue('B'.(++$value_row), ($team->getMemberNumber()))
            ->setCellValue('B'.(++$value_row), $team->getGuo())
            ->setCellValue('B'.(++$value_row), $team->getGuoAddress())
            ->setCellValue('B'.(++$value_row), $team->getPrincipalFullName())
            ->setCellValue('B'.(++$value_row), $team->getEducationDepartment())
            ->setCellValue('B'.(++$value_row), $team->getEducationDepartmentAddress())
            ->setCellValue('B'.(++$value_row), $team->getHeadOfEduFullName())
        ;

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    public function addCoach(PHPExcel_Worksheet $sheet, CoachUser $coach, $label_row, $value_row)
    {
        $sheet
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.surname', [], 'OmerUserBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.name', [], 'OmerUserBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.patronymic', [], 'OmerUserBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.phone', [], 'OmerUserBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.email', [], 'OmerUserBundle'))
            ->setCellValue('A'.(++$label_row), $this->translator->trans('label.form.password', [], 'OmerTeamBundle'))
        ;

        $sheet
            ->setCellValue('B'.(++$value_row), $coach->getSurname())
            ->setCellValue('B'.(++$value_row), $coach->getName())
            ->setCellValue('B'.(++$value_row), $coach->getPatronymic())
            ->setCellValue('B'.(++$value_row), $coach->getPhone())
            ->setCellValue('B'.(++$value_row), $coach->getEmail())
        ;

        $this->label_row = $label_row;
        $this->value_row = $value_row;

        return $sheet;
    }

    public function addTeamMembers(PHPExcel_Worksheet $sheet, $members, $label_row, $value_row)
    {
        /**
         * @var TeamMember $member
         */
        foreach ($members as $member) {

            $sheet
                ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team_member.full_name', [], 'OmerTeamBundle'))
                ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team_member.age', [], 'OmerTeamBundle'))
                ->setCellValue('A'.(++$label_row), $this->translator->trans('label.team_member.allergy', [], 'OmerTeamBundle'))
            ;
            $label_row++;

            $sheet
                ->setCellValue('B'.(++$value_row), $member)
                ->setCellValue('B'.(++$value_row), $member->getAge())
                ->setCellValue('B'.(++$value_row), $member->getAllergy())
            ;
            $value_row++;
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
        $sheet->setCellValue('A'.$row, $title);
        $sheet->getCell('A'.$row)->getStyle()->getFont()->setBold(true);
        $sheet->mergeCells('A'.$row.':B'.$row);
        $style = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $sheet->getStyle('A'.$row.':B'.$row)->applyFromArray($style);

        return $sheet;
    }

}