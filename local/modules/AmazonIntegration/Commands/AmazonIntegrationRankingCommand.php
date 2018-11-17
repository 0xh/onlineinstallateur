<?php
namespace AmazonIntegration\Commands;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use AmazonIntegration\Controller\Admin\AmazonIntegrationContoller;
class AmazonIntegrationRankingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
         ->setName("amazonRanking")
         ->setDescription("AmazonIntegration Ranking and Price")
        ->addArgument(
            'online', InputArgument::REQUIRED, 'Specify if only online products are to be scraped')
        ->addArgument(
            'startid', InputArgument::REQUIRED, 'Specify product start id')
        ->addArgument(
            'stopid', InputArgument::REQUIRED, 'Specify product stop id')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $online = $input->getArgument('online');
        $startid = $input->getArgument('startid');
        $stopid = $input->getArgument('stopid');
        
        /** @var AmazonIntegrationContoller */
        $amazonIntegration = new AmazonIntegrationContoller();
        $amazonIntegration->getAmazonRankingForProducts($online, $startid, $stopid);
        

        echo "End AmazonIntegration ";
    }
}