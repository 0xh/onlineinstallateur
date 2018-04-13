/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Catana Florin
 * Created: Mar 30, 2018
 */

INSERT INTO `hook` 
( `code`, `type`, `by_module`, `activate`, `created_at`, `updated_at`) 
VALUES ( "order.revenue.hook", 2, 0, 1, now(), now())
ON DUPLICATE KEY UPDATE id = id;