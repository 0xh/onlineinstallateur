<?php

namespace ElasticSearch\Commands;

use ElasticSearch\Commands\IndexProducts;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Propel\Runtime\ActiveQuery\ModelCriteria;

class IndexElasticSearch extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
         ->setName("elasticsearch")
         ->setDescription("Process to delete/index/reindex elasticsearch index");
        $this->addArgument(
         "action", InputArgument::REQUIRED
        );
        $this->addArgument(
         "lang", InputArgument::REQUIRED
        );
        $this->addArgument(
         "reindex", InputArgument::OPTIONAL
        );
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $qObject = new IndexProducts();
        switch ($input->getArgument("action")) {
            case 'generate':
                switch ($input->getArgument("lang")) {
                    case 'de':
                        $locale = "de_De";
                        $qObject->indexAllProducts($input->getArgument("lang"), $locale);
                        break;

                    default:
                        echo "Uknow language \n ex: php Thelia elasticsearch generate de \n -where: \n - 'generate': is the action \n - 'de' is the language)!!!! \n";
                        break;
                }     //index action
                break;
            case 'reindex':
                switch ($input->getArgument("lang")) {
                    case 'de':
                        $locale = "de_De";
                        $qObject->deleteAllDocumentsFromIndex($input->getArgument("lang"), $locale);
                        $qObject->indexAllProducts($input->getArgument("lang"), $locale);
                        break;

                    default:
                        echo "Uknow language \n ex: php Thelia elasticsearch generate de \n -where: \n - 'generate': is the action \n - 'de' is the language)!!!! \n";
                        break;
                }     //index action
                break;
            case 'delete':
                switch ($input->getArgument("lang")) {
                    case 'de':
                        $locale = "de_De";
                        $qObject->deleteAllDocumentsFromIndex($input->getArgument("lang"), $locale);
                        break;

                    default:
                        echo "Uknow language!!! \n ex: php Thelia elasticsearch generate de \n -where: \n - 'generate': is the action \n - 'de' is the language)!!!! \n";
                        break;
                }
                break; //delete aciton
            default:
                echo "\n Malformated command : \n !!!!!ex: php Thelia elasticsearch generate de
                \n -where: \n - 'index': is the action \n - 'de' is the language)!!!! \n";
                break;
        }
    }

}
