<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 24.03.17
 * Time: 0:43
 */

namespace Omer\TeamBundle\Command;


use Omer\TeamBundle\Builder\TeamExcelBuilder;
use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\TravelBundle\Entity\TravelInfo;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TransferTeamsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('omer:transfer-teams')
            ->setDescription('Creates commands.')
            ->setHelp('Transfers commands from excel to db')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $files = glob($this->getContainer()->get('kernel')->getRootDir() . '/' . TeamExcelBuilder::TEAM_INFO_FILEPATH . '*.xls');

        foreach ($files as $file) {
            $object = \PHPExcel_IOFactory::load($file);
            $sheet = $object->getActiveSheet();

            $membershipNumber = $sheet->getCell('C3')->getValue();
            $team = $em->getRepository('OmerTeamBundle:ForeignTeam')->findOneBy(['memberNumber' => $membershipNumber]);
            if ($team) {
                continue;
            }

            $team = new ForeignTeam();
            $team->setMemberNumber($membershipNumber);
            $team->setEnglishTeamName($sheet->getCell('C2')->getValue());
            $team->setSchool($sheet->getCell('C4')->getValue());
            $team->setCountry($sheet->getCell('C5')->getValue());
            $team->setDictrict($sheet->getCell('C6')->getValue());
            $team->setCity($sheet->getCell('C7')->getValue());
            $team->setAddress($sheet->getCell('C8')->getValue());
            $team->setProblem($sheet->getCell('C9')->getValue());
            $team->setDivision($sheet->getCell('C10')->getValue());
            $currency = $sheet->getCell('C11')->getValue();
            $team->setPaymentCurrency(array_search($currency,ForeignTeam::PAYMENT_CURRENCY));
            $team->setConcerns($sheet->getCell('C12')->getValue());

            $row = 13;
            /**
             * @var TravelInfo $travelAttribute
             */
            foreach ($team->getTravelAttributes() as $travelAttribute) {
                $date = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setDate($date);
                $travelAttribute->setGoBy($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setTransportNumber($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setStationFrom($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setStationTo($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setTime($sheet->getCell('C'.(++$row))->getValue());
            }

            $em->persist($team);
            break;
        }
        $em->flush();
        //get file
        //create command
        //parse file
        //insert team fields, travel, coaches, team members, other people
    }

}