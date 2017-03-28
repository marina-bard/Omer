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
use Omer\TeamBundle\Entity\OtherPeople;
use Omer\TeamBundle\Entity\TeamMember;
use Omer\TravelBundle\Entity\TravelInfo;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TransferTeamsCommand extends ContainerAwareCommand
{
    private $em;

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
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $files = glob($this->getContainer()->get('kernel')->getRootDir() . '/' . TeamExcelBuilder::TEAM_INFO_FILEPATH . '*.xls');

        foreach ($files as $file) {
            $object = \PHPExcel_IOFactory::load($file);
            $sheet = $object->getActiveSheet();

            $membershipNumber = $sheet->getCell('C3')->getValue();
            $teams = $this->em->getRepository('OmerTeamBundle:ForeignTeam')->findBy(['memberNumber' => $membershipNumber]);

            if (!$teams) {
                $team = new ForeignTeam();
                $team->setMemberNumber($membershipNumber);
            }
            else {
                foreach ($teams as $item) {
                    if (!strcmp($this->transformString($item->getEnglishTeamName()), $this->transformString($sheet->getCell('C2')->getValue()))) {
                        $team = $item;
                    }
                }
            }

            if ($sheet->getCell('B13')->getValue() === 'Travel Information') {
                $team = $this->updateTeamWithTravelInfo($team, $sheet);
            }
            else {
                $team = $this->updateTeamWithoutTravelInfo($team, $sheet);
            }

            $this->em->persist($team);
            $output->writeln('Updated ' . $team->getEnglishTeamName());
        }

        $this->em->flush();
    }

    private function updateTeamWithTravelInfo($team, $sheet)
    {
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
            $coach = $this->em->getRepository('OmerTeamBundle:Coach')->findOneBy(['passportNumber' => $passportNumber]);
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
            $teamMember = $this->em->getRepository('OmerTeamBundle:TeamMember')->findOneBy(['passportNumber' => $passportNumber]);
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

        $row += 3;
        while ($sheet->getCell('B'.$row)->getValue()) {
            $passportNumber = $sheet->getCell('H'.$row)->getValue();
            $otherMember = $this->em->getRepository('OmerTeamBundle:OtherPeople')->findOneBy(['passportNumber' => $passportNumber]);
            if(!$otherMember) {
                $otherMember = new OtherPeople();
                $team->addOtherPerson($otherMember);
                $otherMember->setPassportNumber($passportNumber);
            }
            $otherMember->setFirstName($sheet->getCell('B'.$row)->getValue());
            $otherMember->setSurname($sheet->getCell('C'.$row)->getValue());
            $otherMember->setTShirtSize($sheet->getCell('D'.$row)->getValue());
            $otherMember->setTeamRole($sheet->getCell('E'.$row)->getValue());
            $otherMember->setEmail($sheet->getCell('F'.$row)->getValue());

            $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('G'.$row)->getValue());
            if ($value) {
                $otherMember->setDateOfBirth($value);
            }

            $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('I'.$row)->getValue());
            if ($value) {
                $otherMember->setDateOfIssue($value);
            }

            $value = \DateTime::createFromFormat('d-m-Y', $sheet->getCell('J'.$row)->getValue());
            if ($value) {
                $otherMember->setDateOfExpiry($value);
            }

            $otherMember->setAddress($sheet->getCell('K'.$row)->getValue());
            $otherMember->setDietaryConcerns($sheet->getCell('L'.$row)->getValue());
            $otherMember->setMedicalConcerns($sheet->getCell('M'.$row)->getValue());
            $row++;
        }

        return $team;
    }

    private function updateTeamWithoutTravelInfo(ForeignTeam $team, $sheet)
    {
        $team->setEnglishTeamName($sheet->getCell('C2')->getValue());
        $team->setSchool($sheet->getCell('C4')->getValue());
        $team->setCountry($sheet->getCell('C5')->getValue());
        $team->setDistrict($sheet->getCell('C6')->getValue());
        $team->setCity($sheet->getCell('C7')->getValue());
        $team->setAddress($sheet->getCell('C8')->getValue());
        $team->setProblem($sheet->getCell('C9')->getValue());
        $team->setDivision($sheet->getCell('C10')->getValue());
        $team->setConcerns($sheet->getCell('C13')->getValue());

        $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('C11')->getValue(), 0, 10));
        if ($value) {
            $team->getTravelAttributes()[0]->setDate($value);
        }

        $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('C12')->getValue(), 0, 10));
        if ($value) {
            $team->getTravelAttributes()[1]->setDate($value);
        }

        //B29
        $row = 17;
        while ($sheet->getCell('B'.$row)->getValue()) {
            $passportNumber = $sheet->getCell('G'.$row)->getValue();
            $coach = $this->em->getRepository('OmerTeamBundle:Coach')->findOneBy(['passportNumber' => $passportNumber]);
            if(!$coach) {
                $coach = new Coach();
                $team->addCoach($coach);
                $coach->setPassportNumber($passportNumber);
            }
            $coach->setFirstName($sheet->getCell('B'.$row)->getValue());
            $coach->setSurname($sheet->getCell('C'.$row)->getValue());
            $coach->setTShirtSize($sheet->getCell('D'.$row)->getValue());
            $coach->setEmail($sheet->getCell('E'.$row)->getValue());

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('F'.$row)->getValue(), 0, 10));
            if ($value) {
                $coach->setDateOfBirth($value);
            }

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('H'.$row)->getValue(), 0, 10));
            if ($value) {
                $coach->setDateOfIssue($value);
            }

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('I'.$row)->getValue(), 0, 10));
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
            $teamMember = $this->em->getRepository('OmerTeamBundle:TeamMember')->findOneBy(['passportNumber' => $passportNumber]);
            if(!$teamMember) {
                $teamMember = new TeamMember();
                $team->addMember($teamMember);
                $teamMember->setPassportNumber($passportNumber);
            }
            $teamMember->setFirstName($sheet->getCell('B'.$row)->getValue());
            $teamMember->setSurname($sheet->getCell('C'.$row)->getValue());
            $teamMember->setTShirtSize($sheet->getCell('D'.$row)->getValue());

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('E'.$row)->getValue(), 0, 10));
            if ($value) {
                $teamMember->setDateOfBirth($value);
            }

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('G'.$row)->getValue(), 0, 10));
            if ($value) {
                $teamMember->setDateOfIssue($value);
            }

            $value = \DateTime::createFromFormat('Y-m-d',substr($sheet->getCell('H'.$row)->getValue(), 0, 10));
            if ($value) {
                $teamMember->setDateOfExpiry($value);
            }

            $teamMember->setAddress($sheet->getCell('I'.$row)->getValue());
            $teamMember->setDietaryConcerns($sheet->getCell('J'.$row)->getValue());
            $teamMember->setMedicalConcerns($sheet->getCell('K'.$row)->getValue());
            $row++;
        }

        $row += 3;
        while ($sheet->getCell('B'.$row)->getValue()) {
            $passportNumber = $sheet->getCell('H'.$row)->getValue();
            $otherMember = $this->em->getRepository('OmerTeamBundle:OtherPeople')->findOneBy(['passportNumber' => $passportNumber]);
            if(!$otherMember) {
                $otherMember = new OtherPeople();
                $team->addOtherPerson($otherMember);
                $otherMember->setPassportNumber($passportNumber);
            }
            $otherMember->setFirstName($sheet->getCell('B'.$row)->getValue());
            $otherMember->setSurname($sheet->getCell('C'.$row)->getValue());
            $otherMember->setTShirtSize($sheet->getCell('D'.$row)->getValue());
            $otherMember->setTeamRole($sheet->getCell('E'.$row)->getValue());
            $otherMember->setEmail($sheet->getCell('F'.$row)->getValue());

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('G'.$row)->getValue(), 0, 10));
            if ($value) {
                $otherMember->setDateOfBirth($value);
            }

            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('I'.$row)->getValue(), 0, 10));
            if ($value) {
                $otherMember->setDateOfIssue($value);
            }
            
            $value = \DateTime::createFromFormat('Y-m-d', substr($sheet->getCell('J'.$row)->getValue(), 0, 10));
            if ($value) {
                $otherMember->setDateOfExpiry($value);
            }

            $otherMember->setAddress($sheet->getCell('K'.$row)->getValue());
            $otherMember->setDietaryConcerns($sheet->getCell('L'.$row)->getValue());
            $otherMember->setMedicalConcerns($sheet->getCell('M'.$row)->getValue());
            $row++;
        }

        return $team;
    }

    private function transformString($string)
    {
        return strtolower(preg_replace('/\s+/', '', $string));
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