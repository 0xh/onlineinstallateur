<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace WishList;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class WishList extends BaseModule
{
    /**
     * YOU HAVE TO IMPLEMENT HERE ABSTRACT METHODD FROM BaseModule Class
     * Like install and destroy
     */

    public function postActivation(ConnectionInterface $con = null)
    {
    	$database = new Database($con);
		$database->insertSql(null, [__DIR__ . "/Config/insert_hooks.sql"]);
    		
		if (!self::getConfigValue('is_initialized', false)) {
			$database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);
			self::setConfigValue('is_initialized', true);
		}
    }

}
