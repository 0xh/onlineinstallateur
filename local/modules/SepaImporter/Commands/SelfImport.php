<?php

namespace SepaImporter\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;

class SelfImport extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("selfimport:start")
         ->setDescription("Script will start importing.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello world !");
    }

}
