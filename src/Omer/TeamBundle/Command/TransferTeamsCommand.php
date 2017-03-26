<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 24.03.17
 * Time: 0:43
 */

namespace Omer\TeamBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TransferTeamsCommand extends Command
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
        //get file
        //create command
        //parse file
        //insert team fields, travel, coaches, team members, other people
    }

}