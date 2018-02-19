<?php

echo dirname(__FILE__).DIRECTORY_SEPARATOR."local".DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."HookScraper".DIRECTORY_SEPARATOR."Controller\\errors\\1scraper_error_first.txt";

unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."local".DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."HookScraper".DIRECTORY_SEPARATOR."Controller\\errors\\5scraper_error_search_products.txt");


unlink(dirname(__FILE__).DIRECTORY_SEPARATOR."local".DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."HookScraper".DIRECTORY_SEPARATOR."Controller\\responses\\5scraper_search_products.txt");

echo "<br>error ".error_get_last();