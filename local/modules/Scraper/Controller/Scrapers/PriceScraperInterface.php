<?php

namespace Scraper\Controller\Scrapers;

interface PriceScraperInterface
{

    public function getData($platform, $online, $startid, $stopid, $outputConsole);
}
