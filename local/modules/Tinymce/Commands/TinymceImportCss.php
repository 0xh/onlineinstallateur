<?php 
namespace Tinymce\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Exception\TheliaProcessException;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use Tinymce\Form\ConfigurationForm;
use Tinymce\Tinymce;


class TinymceImportCss  extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
		->setName("tinymce:export")
		->setDescription("Export CSS config from Database to custom-tine css file");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln("start to export css to custom-tinymce.css file !!!!");
		$css_content = Tinymce::getConfigValue('custom_css','/* Enter here CSS or LESS code */');

		$customCss = THELIA_TEMPLATE_DIR.'frontOffice'.DS.'default'.DS.'assets'.DS.'dist'.DS.'css'.DS.'custom-tinymce.css';

		try {
			file_put_contents($customCss,$css_content);
			$output->writeln("\n Css import status: success !!!! \n");
		} catch (Exception $e) {
			$output->writeln("\n Css import status: Faild !!!! \n");
			throw new Exception("Failed to update custom CSS file . Please check this file or parent folder write permissions.");
		}

	}
}

