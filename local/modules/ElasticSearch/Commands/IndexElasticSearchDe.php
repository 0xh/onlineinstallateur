<?php

namespace ElasticSearch\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ElasticSearch\Commands\IndexProducts;
use Thelia\Command\ContainerAwareCommand;

class IndexElasticSearchDe extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("IndexElasticSearchDe")
            ->setDescription("Process to reindex elasticsearch index");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Process Start");
        $qObject = new IndexProducts();
        $qObject->getAllProducts("de_DE");
    }
}