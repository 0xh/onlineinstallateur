<?php
namespace Sofort\Core;

/**
 * @copyright 2010-2015 SOFORT GmbH
 *
 * @license Released under the GNU LESSER GENERAL PUBLIC LICENSE (Version 3)
 * @license http://www.gnu.org/licenses/lgpl.html
 *
 * Sofort Library Factory
 */
class SofortLibFactory {
	
	/**
	 * Defines and includes the DataHandler
	 *
	 * @param string $configKey
	 * @return XmlDataHandler
	 */
	static public function getDataHandler($configKey) {
		return new XmlDataHandler($configKey);
	}
	
	
	/**
	 * Defines the Http Connection to be used
	 *
	 * @param string $data
	 * @param string|bool $url
	 * @param array|bool $headers
	 * @return SofortLibHttpCurl|SofortLibHttpSocket
	 */
	static public function getHttpConnection($data, $url = false, $headers = false) {
		if (function_exists('curl_init')) {
			
			return new SofortLibHttpCurl($data, $url, $headers);
		} else {
			
			return new SofortLibHttpSocket($data, $url, $headers);
		}
	}
	
	
	/**
	 * Defines and includes the logger
	 * 
	 * @return FileLogger
	 */
	static public function getLogger() {
		
		return new FileLogger();
	}
}