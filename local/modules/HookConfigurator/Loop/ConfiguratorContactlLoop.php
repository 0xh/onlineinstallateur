<?php

namespace HookConfigurator\Loop;

use HookConfigurator\Model\ConfiguratorEmailQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfiguratorContactlLoop
 *
 * @author Catana Florin
 */
class ConfiguratorContactlLoop extends BaseI18nLoop implements PropelSearchLoopInterface {

    public $countable = true;
    public $timestampable = false;
    public $versionable = false;

    /*     * *
     * @return ArgumentCollection
     */

    protected function getArgDefinitions() {
        return new ArgumentCollection();
    }

    /**
     * @return ModelCriteria|PageBuilderQuery
     * @throws PropelException
     */
    public function buildModelCriteria() {

        $configuratorList = ConfiguratorEmailQuery::create()
                ->orderById();

        return $configuratorList;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult) {
        foreach ($loopResult->getResultDataCollection() as $configuratorEmail) {

            /** @var PageBuilder $pageBuilder */
            $loopResultRow = new LoopResultRow($configuratorEmail);
            $loopResultRow
                    ->set("id", $configuratorEmail->getId())
                    ->set("visible_form_contact", $configuratorEmail->getVisibleFormContact())
                    ->set("id_category_search", $configuratorEmail->getIdCategorySearch())
                    ->set("with_search_result", $configuratorEmail->getWithSearchResult())
                    ->set("required_vorname", $configuratorEmail->getRequiredVorname())
                    ->set("visible_vorname", $configuratorEmail->getVisibleVorname())
                    ->set("required_nachname", $configuratorEmail->getRequiredNachname())
                    ->set("visible_nachname", $configuratorEmail->getVisibleNachname())
                    ->set("required_str", $configuratorEmail->getRequiredStr())
                    ->set("visible_str", $configuratorEmail->getVisibleStr())
                    ->set("required_plz", $configuratorEmail->getRequiredPlz())
                    ->set("visible_plz", $configuratorEmail->getVisiblePlz())
                    ->set("required_ort", $configuratorEmail->getRequiredOrt())
                    ->set("visible_ort", $configuratorEmail->getVisibleOrt())
                    ->set("required_telefon", $configuratorEmail->getRequiredTelefon())
                    ->set("visible_telefon", $configuratorEmail->getVisibleTelefon())
                    ->set("required_email", $configuratorEmail->getRequiredEmail())
                    ->set("visible_email", $configuratorEmail->getVisibleEmail())
                    ->set("required_terms", $configuratorEmail->getRequiredTerms())
                    ->set("visible_terms", $configuratorEmail->getVisibleTerms())
                    ->set("template_email_name_customer", $configuratorEmail->getTemplateEmailNameCustomer())
                    ->set("template_email_name_admin", $configuratorEmail->getTemplateEmailNameAdmin())
                    ->set("template_redirect_search", $configuratorEmail->getTemplateRedirectSearch())
                    ->set("send_email", $configuratorEmail->getSendEmail());

            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }

}
