<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 24.03.17
 * Time: 0:43
 */

namespace Omer\TeamBundle\Command;


use Omer\TeamBundle\Builder\TeamExcelBuilder;
use Omer\TeamBundle\Entity\Coach;
use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\TeamBundle\Entity\TeamMember;
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
            if (!$team) {
                $team = new ForeignTeam();
            }

            $team->setMemberNumber($membershipNumber);
            $team->setEnglishTeamName($sheet->getCell('C2')->getValue());
            $team->setSchool($sheet->getCell('C4')->getValue());
            $team->setCountry($sheet->getCell('C5')->getValue());
            $team->setDistrict($sheet->getCell('C6')->getValue());
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
                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('C'.(++$row))->getValue());
                if ($value) {
                    $travelAttribute->setDate($value);
                }
                $goBy = $sheet->getCell('C'.(++$row))->getValue();
                $travelAttribute->setGoBy(array_search($goBy, $this->transArray(TravelInfo::TRANSPORT)));
                $travelAttribute->setTransportNumber($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setStationFrom($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setStationTo($sheet->getCell('C'.(++$row))->getValue());
                $travelAttribute->setTime($sheet->getCell('C'.(++$row))->getValue());
            }

            //B29
            $row = 29;
            while ($sheet->getCell('B'.$row)->getValue()) {
                $passportNumber = $sheet->getCell('G'.$row)->getValue();
                $coach = $em->getRepository('OmerTeamBundle:Coach')->findOneBy(['passportNumber' => $passportNumber]);
                if(!$coach) {
                    $coach = new Coach();
                    $team->addCoach($coach);
                    $coach->setPassportNumber($passportNumber);
                }
                $coach->setFirstName($sheet->getCell('B'.$row)->getValue());
                $coach->setSurname($sheet->getCell('C'.$row)->getValue());
                $coach->setTShirtSize($sheet->getCell('D'.$row)->getValue());
                $coach->setEmail($sheet->getCell('E'.$row)->getValue());

                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('F'.$row)->getValue());
                if ($value) {
                    $coach->setDateOfBirth($value);
                }

                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('H'.$row)->getValue());
                if ($value) {
                    $coach->setDateOfIssue($value);
                }

                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('I'.$row)->getValue());
                if ($value) {
                    $coach->setDateOfExpiry($value);
                }

                $coach->setAddress($sheet->getCell('J'.$row)->getValue());
                $coach->setDietaryConcerns($sheet->getCell('K'.$row)->getValue());
                $coach->setMedicalConcerns($sheet->getCell('L'.$row)->getValue());
                $row++;
            }

            $row += 3;
            while ($sheet->getCell('B'.$row)->getValue()) {
                $passportNumber = $sheet->getCell('F'.$row)->getValue();
                $teamMember = $em->getRepository('OmerTeamBundle:TeamMember')->findOneBy(['passportNumber' => $passportNumber]);
                if(!$teamMember) {
                    $teamMember = new TeamMember();
                    $team->addMember($teamMember);
                    $teamMember->setPassportNumber($passportNumber);
                }
                $teamMember->setFirstName($sheet->getCell('B'.$row)->getValue());
                $teamMember->setSurname($sheet->getCell('C'.$row)->getValue());
                $teamMember->setTShirtSize($sheet->getCell('D'.$row)->getValue());

                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('E'.$row)->getValue());
                if ($value) {
                    $teamMember->setDateOfBirth($value);
                }

                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('G'.$row)->getValue());
                if ($value) {
                    $teamMember->setDateOfIssue($value);
                }

                $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('H'.$row)->getValue());
                if ($value) {
                    $teamMember->setDateOfExpiry($value);
                }

                $teamMember->setAddress($sheet->getCell('I'.$row)->getValue());
                $teamMember->setDietaryConcerns($sheet->getCell('J'.$row)->getValue());
                $teamMember->setMedicalConcerns($sheet->getCell('K'.$row)->getValue());
                $row++;
            }

            $em->persist($team);
        }

        $em->flush();
        //get file
        //create command
        //parse file
        //insert team fields, travel, coaches, team members, other people
    }

    private function transArray($array)
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = $this->getContainer()->get('translator')->trans($item, [], 'OmerTravelBundle');
        }

        return $result;
    }

}