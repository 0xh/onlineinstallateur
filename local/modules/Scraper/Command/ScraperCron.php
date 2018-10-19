<?php

namespace Scraper\Command;

use Scraper\Controller\Scrapers\Megabad;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;

class ScraperCron extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("scraper:import")
         ->setDescription("this is firt command");
        $this->addArgument(
         "platform", InputArgument::REQUIRED
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Import start");
        $platform = $input->getArgument("platform");
        $scraper  = new Megabad();
        $scraper->getData($platform);
    }

}
