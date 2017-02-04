<?php

namespace Omer\TeamBundle\Controller;

use Doctrine\ORM\PersistentCollection;
use Omer\TeamBundle\Entity\Team;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\UserBundle\Entity\CoachUser;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;

/**
 * Team controller.
 *
 * @Route("team")
 */
class TeamController extends Controller
{
    use CurrentUserTrait;
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    const TRANS_DOMAIN = [
        'team' => 'OmerTeamBundle',
        'user' => 'OmerUserBundle'
    ];

    /**
     * Lists all team entities.
     *
     * @Route("/", name="team_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('OmerTeamBundle:Team')->findAll();

        return $this->render('OmerTeamBundle:team:index.html.twig', [
            'teams' => $teams,
        ]);
    }

    /**
     * Creates a new team entity.
     *
     * @Route("/new", name="team_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $coach = new CoachUser();
        $team->setCoach($coach);
        $coach->setPlainPassword('1111');

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('Omer\TeamBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_excel', [ 'id' => $team->getId() ]);

        }

        return $this->render('OmerTeamBundle:team:new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    public function randomPassword()
    {
        $pass = [];
        $alphaLength = strlen(self::ALPHABET) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = self::ALPHABET[$n];
        }
        return implode($pass);
    }

    /**
     * Finds and displays a team entity.
     *
     * @Route("/{id}", name="team_show")
     * @Method("GET")
     */
    public function showAction(Team $team)
    {
        return $this->render('OmerTeamBundle:team:show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * Finds and displays a team entity.
     *
     * @Route("/excel/{id}", name="team_excel")
     * @Method("GET")
     */
    public function renderExcelTeamInfoAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $team = $em->getRepository('OmerTeamBundle:Team')->find($id);
        $coach = $team->getCoach();
        $members = $team->getMembers();

        $objectExcel = new PHPExcel();

        $objectExcel = $this->createTeamSheet($team, $objectExcel);
        $objectExcel = $this->createCoachSheet($coach, $objectExcel);
        $objectExcel = $this->createTeamMembersSheet($members, $objectExcel);

        $objectExcel->setActiveSheetIndex(0);

        $writer = PHPExcel_IOFactory::createWriter($objectExcel, 'Excel5');

        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="01simple.xls');
        $response->headers->set('Last-Modified: ', gmdate('D, d M Y H:i:s'));

        return $response;
    }

    public function createTeamSheet(Team $team,PHPExcel $excel)
    {
        $translator = $this->get('translator');

        /**
         * @var PHPExcel_Worksheet $sheet
         */
        $sheet = $excel->setActiveSheetIndex(0)->setTitle($translator->trans('Team', [], self::TRANS_DOMAIN['team']));
        $sheet = $this->setSheetHeader($sheet, $translator->trans('Team', [], self::TRANS_DOMAIN['team']));
        $sheet->getDefaultRowDimension()->setRowHeight(15);

        $label = 2;
        $sheet
            ->setCellValue('A'.(++$label), $translator->trans('label.team.native_team_name', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.english_team_name', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.member_number', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.guo', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.guo_address', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.principal_name', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.edu_dep', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.edu_dep_address', [], self::TRANS_DOMAIN['team']))
            ->setCellValue('A'.(++$label), $translator->trans('label.team.head_edu_name', [], self::TRANS_DOMAIN['team']))
        ;

        $value = 2;
        $sheet
            ->setCellValue('B'.(++$value), $team->getNativeTeamName())
            ->setCellValue('B'.(++$value), $team->getEnglishTeamName())
            ->setCellValue('B'.(++$value), ($team->getMemberNumber()))
            ->setCellValue('B'.(++$value), $team->getGuo())
            ->setCellValue('B'.(++$value), $team->getGuoAddress())
            ->setCellValue('B'.(++$value), $team->getPrincipalFullName())
            ->setCellValue('B'.(++$value), $team->getEducationDepartment())
            ->setCellValue('B'.(++$value), $team->getEducationDepartmentAddress())
            ->setCellValue('B'.(++$value), $team->getHeadOfEduFullName())
        ;


        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        return $excel;
    }

    public function createCoachSheet(CoachUser $coach, PHPExcel $excel)
    {
        $translator = $this->get('translator');

        /**
         * @var PHPExcel_Worksheet $sheet
         */
        $sheet = $excel->createSheet(1)->setTitle($translator->trans('Coach', [], self::TRANS_DOMAIN['team']));
        $sheet = $this->setSheetHeader($sheet, $translator->trans('Coach', [], self::TRANS_DOMAIN['team']));
        $sheet->getDefaultRowDimension()->setRowHeight(15);

        $label = 2;
        $sheet
            ->setCellValue('A'.(++$label), $translator->trans('label.surname', [], self::TRANS_DOMAIN['user']))
            ->setCellValue('A'.(++$label), $translator->trans('label.name', [], self::TRANS_DOMAIN['user']))
            ->setCellValue('A'.(++$label), $translator->trans('label.patronymic', [], self::TRANS_DOMAIN['user']))
            ->setCellValue('A'.(++$label), $translator->trans('label.phone', [], self::TRANS_DOMAIN['user']))
            ->setCellValue('A'.(++$label), $translator->trans('label.email', [], self::TRANS_DOMAIN['user']))
            ->setCellValue('A'.(++$label), $translator->trans('label.form.password', [], self::TRANS_DOMAIN['team']))
        ;

        $value = 2;
        $sheet
            ->setCellValue('B'.(++$value), $coach->getSurname())
            ->setCellValue('B'.(++$value), $coach->getName())
            ->setCellValue('B'.(++$value), $coach->getPatronymic())
            ->setCellValue('B'.(++$value), $coach->getPhone())
            ->setCellValue('B'.(++$value), $coach->getEmail())
            ->setCellValue('B'.(++$value), $this->setCoachPassword($coach));
        ;

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        return $excel;
    }

    public function createTeamMembersSheet($members, PHPExcel $excel)
    {
        $translator = $this->get('translator');

        /**
         * @var PHPExcel_Worksheet $sheet
         */
        $sheet = $excel->createSheet(2)->setTitle($translator->trans('Team members', [], self::TRANS_DOMAIN['team']));
        $sheet = $this->setSheetHeader($sheet, $translator->trans('Team members', [], self::TRANS_DOMAIN['team']));
        $sheet->getDefaultRowDimension()->setRowHeight(15);

        $label = 2;
        $value = 2;
        /**
         * @var TeamMember $member
         */
        foreach ($members as $member) {

            $sheet
                ->setCellValue('A'.(++$label), $translator->trans('label.team_member.full_name', [], self::TRANS_DOMAIN['team']))
                ->setCellValue('A'.(++$label), $translator->trans('label.team_member.age', [], self::TRANS_DOMAIN['team']))
                ->setCellValue('A'.(++$label), $translator->trans('label.team_member.allergy', [], self::TRANS_DOMAIN['team']))
            ;
            $label++;

            $sheet
                ->setCellValue('B'.(++$value), $member)
                ->setCellValue('B'.(++$value), $member->getAge())
                ->setCellValue('B'.(++$value), $member->getAllergy())
            ;
            $value++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        return $excel;
    }

    public function setSheetHeader(PHPExcel_Worksheet $sheet, $title)
    {
        /**
         * @var PHPExcel_Worksheet $sheet
         */
        $sheet->setCellValue('A1', $title);
        $sheet->getCell('A1')->getStyle()->getFont()->setBold(true);
        $sheet->mergeCells('A1:B1');
        $style = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $sheet->getStyle("A1:B1")->applyFromArray($style);
        return $sheet;
    }

    public function setCoachPassword(CoachUser $coach)
    {
        $password = $this->randomPassword();
        $coach->setPlainPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($coach);
        $em->flush();

        return $password;
    }
}
