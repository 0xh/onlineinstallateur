<?php

namespace HookCalendar\Model\Base;

use \Exception;
use \PDO;
use HookCalendar\Model\PluginInvoice as ChildPluginInvoice;
use HookCalendar\Model\PluginInvoiceQuery as ChildPluginInvoiceQuery;
use HookCalendar\Model\Map\PluginInvoiceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'plugin_invoice' table.
 *
 *
 *
 * @method     ChildPluginInvoiceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginInvoiceQuery orderByUuid($order = Criteria::ASC) Order by the uuid column
 * @method     ChildPluginInvoiceQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildPluginInvoiceQuery orderByForeignId($order = Criteria::ASC) Order by the foreign_id column
 * @method     ChildPluginInvoiceQuery orderByIssueDate($order = Criteria::ASC) Order by the issue_date column
 * @method     ChildPluginInvoiceQuery orderByDueDate($order = Criteria::ASC) Order by the due_date column
 * @method     ChildPluginInvoiceQuery orderByCreated($order = Criteria::ASC) Order by the created column
 * @method     ChildPluginInvoiceQuery orderByModified($order = Criteria::ASC) Order by the modified column
 * @method     ChildPluginInvoiceQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPluginInvoiceQuery orderByPaymentMethod($order = Criteria::ASC) Order by the payment_method column
 * @method     ChildPluginInvoiceQuery orderByCcType($order = Criteria::ASC) Order by the cc_type column
 * @method     ChildPluginInvoiceQuery orderByCcNum($order = Criteria::ASC) Order by the cc_num column
 * @method     ChildPluginInvoiceQuery orderByCcExpMonth($order = Criteria::ASC) Order by the cc_exp_month column
 * @method     ChildPluginInvoiceQuery orderByCcExpYear($order = Criteria::ASC) Order by the cc_exp_year column
 * @method     ChildPluginInvoiceQuery orderByCcCode($order = Criteria::ASC) Order by the cc_code column
 * @method     ChildPluginInvoiceQuery orderByTxnId($order = Criteria::ASC) Order by the txn_id column
 * @method     ChildPluginInvoiceQuery orderByProcessedOn($order = Criteria::ASC) Order by the processed_on column
 * @method     ChildPluginInvoiceQuery orderBySubtotal($order = Criteria::ASC) Order by the subtotal column
 * @method     ChildPluginInvoiceQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 * @method     ChildPluginInvoiceQuery orderByTax($order = Criteria::ASC) Order by the tax column
 * @method     ChildPluginInvoiceQuery orderByShipping($order = Criteria::ASC) Order by the shipping column
 * @method     ChildPluginInvoiceQuery orderByTotal($order = Criteria::ASC) Order by the total column
 * @method     ChildPluginInvoiceQuery orderByPaidDeposit($order = Criteria::ASC) Order by the paid_deposit column
 * @method     ChildPluginInvoiceQuery orderByAmountDue($order = Criteria::ASC) Order by the amount_due column
 * @method     ChildPluginInvoiceQuery orderByCurrency($order = Criteria::ASC) Order by the currency column
 * @method     ChildPluginInvoiceQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method     ChildPluginInvoiceQuery orderByYLogo($order = Criteria::ASC) Order by the y_logo column
 * @method     ChildPluginInvoiceQuery orderByYCompany($order = Criteria::ASC) Order by the y_company column
 * @method     ChildPluginInvoiceQuery orderByYName($order = Criteria::ASC) Order by the y_name column
 * @method     ChildPluginInvoiceQuery orderByYStreetAddress($order = Criteria::ASC) Order by the y_street_address column
 * @method     ChildPluginInvoiceQuery orderByYCountry($order = Criteria::ASC) Order by the y_country column
 * @method     ChildPluginInvoiceQuery orderByYCity($order = Criteria::ASC) Order by the y_city column
 * @method     ChildPluginInvoiceQuery orderByYState($order = Criteria::ASC) Order by the y_state column
 * @method     ChildPluginInvoiceQuery orderByYZip($order = Criteria::ASC) Order by the y_zip column
 * @method     ChildPluginInvoiceQuery orderByYPhone($order = Criteria::ASC) Order by the y_phone column
 * @method     ChildPluginInvoiceQuery orderByYFax($order = Criteria::ASC) Order by the y_fax column
 * @method     ChildPluginInvoiceQuery orderByYEmail($order = Criteria::ASC) Order by the y_email column
 * @method     ChildPluginInvoiceQuery orderByYUrl($order = Criteria::ASC) Order by the y_url column
 * @method     ChildPluginInvoiceQuery orderByBBillingAddress($order = Criteria::ASC) Order by the b_billing_address column
 * @method     ChildPluginInvoiceQuery orderByBCompany($order = Criteria::ASC) Order by the b_company column
 * @method     ChildPluginInvoiceQuery orderByBName($order = Criteria::ASC) Order by the b_name column
 * @method     ChildPluginInvoiceQuery orderByBAddress($order = Criteria::ASC) Order by the b_address column
 * @method     ChildPluginInvoiceQuery orderByBStreetAddress($order = Criteria::ASC) Order by the b_street_address column
 * @method     ChildPluginInvoiceQuery orderByBCountry($order = Criteria::ASC) Order by the b_country column
 * @method     ChildPluginInvoiceQuery orderByBCity($order = Criteria::ASC) Order by the b_city column
 * @method     ChildPluginInvoiceQuery orderByBState($order = Criteria::ASC) Order by the b_state column
 * @method     ChildPluginInvoiceQuery orderByBZip($order = Criteria::ASC) Order by the b_zip column
 * @method     ChildPluginInvoiceQuery orderByBPhone($order = Criteria::ASC) Order by the b_phone column
 * @method     ChildPluginInvoiceQuery orderByBFax($order = Criteria::ASC) Order by the b_fax column
 * @method     ChildPluginInvoiceQuery orderByBEmail($order = Criteria::ASC) Order by the b_email column
 * @method     ChildPluginInvoiceQuery orderByBUrl($order = Criteria::ASC) Order by the b_url column
 * @method     ChildPluginInvoiceQuery orderBySShippingAddress($order = Criteria::ASC) Order by the s_shipping_address column
 * @method     ChildPluginInvoiceQuery orderBySCompany($order = Criteria::ASC) Order by the s_company column
 * @method     ChildPluginInvoiceQuery orderBySName($order = Criteria::ASC) Order by the s_name column
 * @method     ChildPluginInvoiceQuery orderBySAddress($order = Criteria::ASC) Order by the s_address column
 * @method     ChildPluginInvoiceQuery orderBySStreetAddress($order = Criteria::ASC) Order by the s_street_address column
 * @method     ChildPluginInvoiceQuery orderBySCountry($order = Criteria::ASC) Order by the s_country column
 * @method     ChildPluginInvoiceQuery orderBySCity($order = Criteria::ASC) Order by the s_city column
 * @method     ChildPluginInvoiceQuery orderBySState($order = Criteria::ASC) Order by the s_state column
 * @method     ChildPluginInvoiceQuery orderBySZip($order = Criteria::ASC) Order by the s_zip column
 * @method     ChildPluginInvoiceQuery orderBySPhone($order = Criteria::ASC) Order by the s_phone column
 * @method     ChildPluginInvoiceQuery orderBySFax($order = Criteria::ASC) Order by the s_fax column
 * @method     ChildPluginInvoiceQuery orderBySEmail($order = Criteria::ASC) Order by the s_email column
 * @method     ChildPluginInvoiceQuery orderBySUrl($order = Criteria::ASC) Order by the s_url column
 * @method     ChildPluginInvoiceQuery orderBySDate($order = Criteria::ASC) Order by the s_date column
 * @method     ChildPluginInvoiceQuery orderBySTerms($order = Criteria::ASC) Order by the s_terms column
 * @method     ChildPluginInvoiceQuery orderBySIsShipped($order = Criteria::ASC) Order by the s_is_shipped column
 *
 * @method     ChildPluginInvoiceQuery groupById() Group by the id column
 * @method     ChildPluginInvoiceQuery groupByUuid() Group by the uuid column
 * @method     ChildPluginInvoiceQuery groupByOrderId() Group by the order_id column
 * @method     ChildPluginInvoiceQuery groupByForeignId() Group by the foreign_id column
 * @method     ChildPluginInvoiceQuery groupByIssueDate() Group by the issue_date column
 * @method     ChildPluginInvoiceQuery groupByDueDate() Group by the due_date column
 * @method     ChildPluginInvoiceQuery groupByCreated() Group by the created column
 * @method     ChildPluginInvoiceQuery groupByModified() Group by the modified column
 * @method     ChildPluginInvoiceQuery groupByStatus() Group by the status column
 * @method     ChildPluginInvoiceQuery groupByPaymentMethod() Group by the payment_method column
 * @method     ChildPluginInvoiceQuery groupByCcType() Group by the cc_type column
 * @method     ChildPluginInvoiceQuery groupByCcNum() Group by the cc_num column
 * @method     ChildPluginInvoiceQuery groupByCcExpMonth() Group by the cc_exp_month column
 * @method     ChildPluginInvoiceQuery groupByCcExpYear() Group by the cc_exp_year column
 * @method     ChildPluginInvoiceQuery groupByCcCode() Group by the cc_code column
 * @method     ChildPluginInvoiceQuery groupByTxnId() Group by the txn_id column
 * @method     ChildPluginInvoiceQuery groupByProcessedOn() Group by the processed_on column
 * @method     ChildPluginInvoiceQuery groupBySubtotal() Group by the subtotal column
 * @method     ChildPluginInvoiceQuery groupByDiscount() Group by the discount column
 * @method     ChildPluginInvoiceQuery groupByTax() Group by the tax column
 * @method     ChildPluginInvoiceQuery groupByShipping() Group by the shipping column
 * @method     ChildPluginInvoiceQuery groupByTotal() Group by the total column
 * @method     ChildPluginInvoiceQuery groupByPaidDeposit() Group by the paid_deposit column
 * @method     ChildPluginInvoiceQuery groupByAmountDue() Group by the amount_due column
 * @method     ChildPluginInvoiceQuery groupByCurrency() Group by the currency column
 * @method     ChildPluginInvoiceQuery groupByNotes() Group by the notes column
 * @method     ChildPluginInvoiceQuery groupByYLogo() Group by the y_logo column
 * @method     ChildPluginInvoiceQuery groupByYCompany() Group by the y_company column
 * @method     ChildPluginInvoiceQuery groupByYName() Group by the y_name column
 * @method     ChildPluginInvoiceQuery groupByYStreetAddress() Group by the y_street_address column
 * @method     ChildPluginInvoiceQuery groupByYCountry() Group by the y_country column
 * @method     ChildPluginInvoiceQuery groupByYCity() Group by the y_city column
 * @method     ChildPluginInvoiceQuery groupByYState() Group by the y_state column
 * @method     ChildPluginInvoiceQuery groupByYZip() Group by the y_zip column
 * @method     ChildPluginInvoiceQuery groupByYPhone() Group by the y_phone column
 * @method     ChildPluginInvoiceQuery groupByYFax() Group by the y_fax column
 * @method     ChildPluginInvoiceQuery groupByYEmail() Group by the y_email column
 * @method     ChildPluginInvoiceQuery groupByYUrl() Group by the y_url column
 * @method     ChildPluginInvoiceQuery groupByBBillingAddress() Group by the b_billing_address column
 * @method     ChildPluginInvoiceQuery groupByBCompany() Group by the b_company column
 * @method     ChildPluginInvoiceQuery groupByBName() Group by the b_name column
 * @method     ChildPluginInvoiceQuery groupByBAddress() Group by the b_address column
 * @method     ChildPluginInvoiceQuery groupByBStreetAddress() Group by the b_street_address column
 * @method     ChildPluginInvoiceQuery groupByBCountry() Group by the b_country column
 * @method     ChildPluginInvoiceQuery groupByBCity() Group by the b_city column
 * @method     ChildPluginInvoiceQuery groupByBState() Group by the b_state column
 * @method     ChildPluginInvoiceQuery groupByBZip() Group by the b_zip column
 * @method     ChildPluginInvoiceQuery groupByBPhone() Group by the b_phone column
 * @method     ChildPluginInvoiceQuery groupByBFax() Group by the b_fax column
 * @method     ChildPluginInvoiceQuery groupByBEmail() Group by the b_email column
 * @method     ChildPluginInvoiceQuery groupByBUrl() Group by the b_url column
 * @method     ChildPluginInvoiceQuery groupBySShippingAddress() Group by the s_shipping_address column
 * @method     ChildPluginInvoiceQuery groupBySCompany() Group by the s_company column
 * @method     ChildPluginInvoiceQuery groupBySName() Group by the s_name column
 * @method     ChildPluginInvoiceQuery groupBySAddress() Group by the s_address column
 * @method     ChildPluginInvoiceQuery groupBySStreetAddress() Group by the s_street_address column
 * @method     ChildPluginInvoiceQuery groupBySCountry() Group by the s_country column
 * @method     ChildPluginInvoiceQuery groupBySCity() Group by the s_city column
 * @method     ChildPluginInvoiceQuery groupBySState() Group by the s_state column
 * @method     ChildPluginInvoiceQuery groupBySZip() Group by the s_zip column
 * @method     ChildPluginInvoiceQuery groupBySPhone() Group by the s_phone column
 * @method     ChildPluginInvoiceQuery groupBySFax() Group by the s_fax column
 * @method     ChildPluginInvoiceQuery groupBySEmail() Group by the s_email column
 * @method     ChildPluginInvoiceQuery groupBySUrl() Group by the s_url column
 * @method     ChildPluginInvoiceQuery groupBySDate() Group by the s_date column
 * @method     ChildPluginInvoiceQuery groupBySTerms() Group by the s_terms column
 * @method     ChildPluginInvoiceQuery groupBySIsShipped() Group by the s_is_shipped column
 *
 * @method     ChildPluginInvoiceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginInvoiceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginInvoiceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginInvoice findOne(ConnectionInterface $con = null) Return the first ChildPluginInvoice matching the query
 * @method     ChildPluginInvoice findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPluginInvoice matching the query, or a new ChildPluginInvoice object populated from the query conditions when no match is found
 *
 * @method     ChildPluginInvoice findOneById(int $id) Return the first ChildPluginInvoice filtered by the id column
 * @method     ChildPluginInvoice findOneByUuid(string $uuid) Return the first ChildPluginInvoice filtered by the uuid column
 * @method     ChildPluginInvoice findOneByOrderId(string $order_id) Return the first ChildPluginInvoice filtered by the order_id column
 * @method     ChildPluginInvoice findOneByForeignId(int $foreign_id) Return the first ChildPluginInvoice filtered by the foreign_id column
 * @method     ChildPluginInvoice findOneByIssueDate(string $issue_date) Return the first ChildPluginInvoice filtered by the issue_date column
 * @method     ChildPluginInvoice findOneByDueDate(string $due_date) Return the first ChildPluginInvoice filtered by the due_date column
 * @method     ChildPluginInvoice findOneByCreated(string $created) Return the first ChildPluginInvoice filtered by the created column
 * @method     ChildPluginInvoice findOneByModified(string $modified) Return the first ChildPluginInvoice filtered by the modified column
 * @method     ChildPluginInvoice findOneByStatus(string $status) Return the first ChildPluginInvoice filtered by the status column
 * @method     ChildPluginInvoice findOneByPaymentMethod(string $payment_method) Return the first ChildPluginInvoice filtered by the payment_method column
 * @method     ChildPluginInvoice findOneByCcType(resource $cc_type) Return the first ChildPluginInvoice filtered by the cc_type column
 * @method     ChildPluginInvoice findOneByCcNum(resource $cc_num) Return the first ChildPluginInvoice filtered by the cc_num column
 * @method     ChildPluginInvoice findOneByCcExpMonth(resource $cc_exp_month) Return the first ChildPluginInvoice filtered by the cc_exp_month column
 * @method     ChildPluginInvoice findOneByCcExpYear(resource $cc_exp_year) Return the first ChildPluginInvoice filtered by the cc_exp_year column
 * @method     ChildPluginInvoice findOneByCcCode(resource $cc_code) Return the first ChildPluginInvoice filtered by the cc_code column
 * @method     ChildPluginInvoice findOneByTxnId(string $txn_id) Return the first ChildPluginInvoice filtered by the txn_id column
 * @method     ChildPluginInvoice findOneByProcessedOn(string $processed_on) Return the first ChildPluginInvoice filtered by the processed_on column
 * @method     ChildPluginInvoice findOneBySubtotal(string $subtotal) Return the first ChildPluginInvoice filtered by the subtotal column
 * @method     ChildPluginInvoice findOneByDiscount(string $discount) Return the first ChildPluginInvoice filtered by the discount column
 * @method     ChildPluginInvoice findOneByTax(string $tax) Return the first ChildPluginInvoice filtered by the tax column
 * @method     ChildPluginInvoice findOneByShipping(string $shipping) Return the first ChildPluginInvoice filtered by the shipping column
 * @method     ChildPluginInvoice findOneByTotal(string $total) Return the first ChildPluginInvoice filtered by the total column
 * @method     ChildPluginInvoice findOneByPaidDeposit(string $paid_deposit) Return the first ChildPluginInvoice filtered by the paid_deposit column
 * @method     ChildPluginInvoice findOneByAmountDue(string $amount_due) Return the first ChildPluginInvoice filtered by the amount_due column
 * @method     ChildPluginInvoice findOneByCurrency(string $currency) Return the first ChildPluginInvoice filtered by the currency column
 * @method     ChildPluginInvoice findOneByNotes(string $notes) Return the first ChildPluginInvoice filtered by the notes column
 * @method     ChildPluginInvoice findOneByYLogo(string $y_logo) Return the first ChildPluginInvoice filtered by the y_logo column
 * @method     ChildPluginInvoice findOneByYCompany(string $y_company) Return the first ChildPluginInvoice filtered by the y_company column
 * @method     ChildPluginInvoice findOneByYName(string $y_name) Return the first ChildPluginInvoice filtered by the y_name column
 * @method     ChildPluginInvoice findOneByYStreetAddress(string $y_street_address) Return the first ChildPluginInvoice filtered by the y_street_address column
 * @method     ChildPluginInvoice findOneByYCountry(int $y_country) Return the first ChildPluginInvoice filtered by the y_country column
 * @method     ChildPluginInvoice findOneByYCity(string $y_city) Return the first ChildPluginInvoice filtered by the y_city column
 * @method     ChildPluginInvoice findOneByYState(string $y_state) Return the first ChildPluginInvoice filtered by the y_state column
 * @method     ChildPluginInvoice findOneByYZip(string $y_zip) Return the first ChildPluginInvoice filtered by the y_zip column
 * @method     ChildPluginInvoice findOneByYPhone(string $y_phone) Return the first ChildPluginInvoice filtered by the y_phone column
 * @method     ChildPluginInvoice findOneByYFax(string $y_fax) Return the first ChildPluginInvoice filtered by the y_fax column
 * @method     ChildPluginInvoice findOneByYEmail(string $y_email) Return the first ChildPluginInvoice filtered by the y_email column
 * @method     ChildPluginInvoice findOneByYUrl(string $y_url) Return the first ChildPluginInvoice filtered by the y_url column
 * @method     ChildPluginInvoice findOneByBBillingAddress(string $b_billing_address) Return the first ChildPluginInvoice filtered by the b_billing_address column
 * @method     ChildPluginInvoice findOneByBCompany(string $b_company) Return the first ChildPluginInvoice filtered by the b_company column
 * @method     ChildPluginInvoice findOneByBName(string $b_name) Return the first ChildPluginInvoice filtered by the b_name column
 * @method     ChildPluginInvoice findOneByBAddress(string $b_address) Return the first ChildPluginInvoice filtered by the b_address column
 * @method     ChildPluginInvoice findOneByBStreetAddress(string $b_street_address) Return the first ChildPluginInvoice filtered by the b_street_address column
 * @method     ChildPluginInvoice findOneByBCountry(int $b_country) Return the first ChildPluginInvoice filtered by the b_country column
 * @method     ChildPluginInvoice findOneByBCity(string $b_city) Return the first ChildPluginInvoice filtered by the b_city column
 * @method     ChildPluginInvoice findOneByBState(string $b_state) Return the first ChildPluginInvoice filtered by the b_state column
 * @method     ChildPluginInvoice findOneByBZip(string $b_zip) Return the first ChildPluginInvoice filtered by the b_zip column
 * @method     ChildPluginInvoice findOneByBPhone(string $b_phone) Return the first ChildPluginInvoice filtered by the b_phone column
 * @method     ChildPluginInvoice findOneByBFax(string $b_fax) Return the first ChildPluginInvoice filtered by the b_fax column
 * @method     ChildPluginInvoice findOneByBEmail(string $b_email) Return the first ChildPluginInvoice filtered by the b_email column
 * @method     ChildPluginInvoice findOneByBUrl(string $b_url) Return the first ChildPluginInvoice filtered by the b_url column
 * @method     ChildPluginInvoice findOneBySShippingAddress(string $s_shipping_address) Return the first ChildPluginInvoice filtered by the s_shipping_address column
 * @method     ChildPluginInvoice findOneBySCompany(string $s_company) Return the first ChildPluginInvoice filtered by the s_company column
 * @method     ChildPluginInvoice findOneBySName(string $s_name) Return the first ChildPluginInvoice filtered by the s_name column
 * @method     ChildPluginInvoice findOneBySAddress(string $s_address) Return the first ChildPluginInvoice filtered by the s_address column
 * @method     ChildPluginInvoice findOneBySStreetAddress(string $s_street_address) Return the first ChildPluginInvoice filtered by the s_street_address column
 * @method     ChildPluginInvoice findOneBySCountry(int $s_country) Return the first ChildPluginInvoice filtered by the s_country column
 * @method     ChildPluginInvoice findOneBySCity(string $s_city) Return the first ChildPluginInvoice filtered by the s_city column
 * @method     ChildPluginInvoice findOneBySState(string $s_state) Return the first ChildPluginInvoice filtered by the s_state column
 * @method     ChildPluginInvoice findOneBySZip(string $s_zip) Return the first ChildPluginInvoice filtered by the s_zip column
 * @method     ChildPluginInvoice findOneBySPhone(string $s_phone) Return the first ChildPluginInvoice filtered by the s_phone column
 * @method     ChildPluginInvoice findOneBySFax(string $s_fax) Return the first ChildPluginInvoice filtered by the s_fax column
 * @method     ChildPluginInvoice findOneBySEmail(string $s_email) Return the first ChildPluginInvoice filtered by the s_email column
 * @method     ChildPluginInvoice findOneBySUrl(string $s_url) Return the first ChildPluginInvoice filtered by the s_url column
 * @method     ChildPluginInvoice findOneBySDate(string $s_date) Return the first ChildPluginInvoice filtered by the s_date column
 * @method     ChildPluginInvoice findOneBySTerms(string $s_terms) Return the first ChildPluginInvoice filtered by the s_terms column
 * @method     ChildPluginInvoice findOneBySIsShipped(boolean $s_is_shipped) Return the first ChildPluginInvoice filtered by the s_is_shipped column
 *
 * @method     array findById(int $id) Return ChildPluginInvoice objects filtered by the id column
 * @method     array findByUuid(string $uuid) Return ChildPluginInvoice objects filtered by the uuid column
 * @method     array findByOrderId(string $order_id) Return ChildPluginInvoice objects filtered by the order_id column
 * @method     array findByForeignId(int $foreign_id) Return ChildPluginInvoice objects filtered by the foreign_id column
 * @method     array findByIssueDate(string $issue_date) Return ChildPluginInvoice objects filtered by the issue_date column
 * @method     array findByDueDate(string $due_date) Return ChildPluginInvoice objects filtered by the due_date column
 * @method     array findByCreated(string $created) Return ChildPluginInvoice objects filtered by the created column
 * @method     array findByModified(string $modified) Return ChildPluginInvoice objects filtered by the modified column
 * @method     array findByStatus(string $status) Return ChildPluginInvoice objects filtered by the status column
 * @method     array findByPaymentMethod(string $payment_method) Return ChildPluginInvoice objects filtered by the payment_method column
 * @method     array findByCcType(resource $cc_type) Return ChildPluginInvoice objects filtered by the cc_type column
 * @method     array findByCcNum(resource $cc_num) Return ChildPluginInvoice objects filtered by the cc_num column
 * @method     array findByCcExpMonth(resource $cc_exp_month) Return ChildPluginInvoice objects filtered by the cc_exp_month column
 * @method     array findByCcExpYear(resource $cc_exp_year) Return ChildPluginInvoice objects filtered by the cc_exp_year column
 * @method     array findByCcCode(resource $cc_code) Return ChildPluginInvoice objects filtered by the cc_code column
 * @method     array findByTxnId(string $txn_id) Return ChildPluginInvoice objects filtered by the txn_id column
 * @method     array findByProcessedOn(string $processed_on) Return ChildPluginInvoice objects filtered by the processed_on column
 * @method     array findBySubtotal(string $subtotal) Return ChildPluginInvoice objects filtered by the subtotal column
 * @method     array findByDiscount(string $discount) Return ChildPluginInvoice objects filtered by the discount column
 * @method     array findByTax(string $tax) Return ChildPluginInvoice objects filtered by the tax column
 * @method     array findByShipping(string $shipping) Return ChildPluginInvoice objects filtered by the shipping column
 * @method     array findByTotal(string $total) Return ChildPluginInvoice objects filtered by the total column
 * @method     array findByPaidDeposit(string $paid_deposit) Return ChildPluginInvoice objects filtered by the paid_deposit column
 * @method     array findByAmountDue(string $amount_due) Return ChildPluginInvoice objects filtered by the amount_due column
 * @method     array findByCurrency(string $currency) Return ChildPluginInvoice objects filtered by the currency column
 * @method     array findByNotes(string $notes) Return ChildPluginInvoice objects filtered by the notes column
 * @method     array findByYLogo(string $y_logo) Return ChildPluginInvoice objects filtered by the y_logo column
 * @method     array findByYCompany(string $y_company) Return ChildPluginInvoice objects filtered by the y_company column
 * @method     array findByYName(string $y_name) Return ChildPluginInvoice objects filtered by the y_name column
 * @method     array findByYStreetAddress(string $y_street_address) Return ChildPluginInvoice objects filtered by the y_street_address column
 * @method     array findByYCountry(int $y_country) Return ChildPluginInvoice objects filtered by the y_country column
 * @method     array findByYCity(string $y_city) Return ChildPluginInvoice objects filtered by the y_city column
 * @method     array findByYState(string $y_state) Return ChildPluginInvoice objects filtered by the y_state column
 * @method     array findByYZip(string $y_zip) Return ChildPluginInvoice objects filtered by the y_zip column
 * @method     array findByYPhone(string $y_phone) Return ChildPluginInvoice objects filtered by the y_phone column
 * @method     array findByYFax(string $y_fax) Return ChildPluginInvoice objects filtered by the y_fax column
 * @method     array findByYEmail(string $y_email) Return ChildPluginInvoice objects filtered by the y_email column
 * @method     array findByYUrl(string $y_url) Return ChildPluginInvoice objects filtered by the y_url column
 * @method     array findByBBillingAddress(string $b_billing_address) Return ChildPluginInvoice objects filtered by the b_billing_address column
 * @method     array findByBCompany(string $b_company) Return ChildPluginInvoice objects filtered by the b_company column
 * @method     array findByBName(string $b_name) Return ChildPluginInvoice objects filtered by the b_name column
 * @method     array findByBAddress(string $b_address) Return ChildPluginInvoice objects filtered by the b_address column
 * @method     array findByBStreetAddress(string $b_street_address) Return ChildPluginInvoice objects filtered by the b_street_address column
 * @method     array findByBCountry(int $b_country) Return ChildPluginInvoice objects filtered by the b_country column
 * @method     array findByBCity(string $b_city) Return ChildPluginInvoice objects filtered by the b_city column
 * @method     array findByBState(string $b_state) Return ChildPluginInvoice objects filtered by the b_state column
 * @method     array findByBZip(string $b_zip) Return ChildPluginInvoice objects filtered by the b_zip column
 * @method     array findByBPhone(string $b_phone) Return ChildPluginInvoice objects filtered by the b_phone column
 * @method     array findByBFax(string $b_fax) Return ChildPluginInvoice objects filtered by the b_fax column
 * @method     array findByBEmail(string $b_email) Return ChildPluginInvoice objects filtered by the b_email column
 * @method     array findByBUrl(string $b_url) Return ChildPluginInvoice objects filtered by the b_url column
 * @method     array findBySShippingAddress(string $s_shipping_address) Return ChildPluginInvoice objects filtered by the s_shipping_address column
 * @method     array findBySCompany(string $s_company) Return ChildPluginInvoice objects filtered by the s_company column
 * @method     array findBySName(string $s_name) Return ChildPluginInvoice objects filtered by the s_name column
 * @method     array findBySAddress(string $s_address) Return ChildPluginInvoice objects filtered by the s_address column
 * @method     array findBySStreetAddress(string $s_street_address) Return ChildPluginInvoice objects filtered by the s_street_address column
 * @method     array findBySCountry(int $s_country) Return ChildPluginInvoice objects filtered by the s_country column
 * @method     array findBySCity(string $s_city) Return ChildPluginInvoice objects filtered by the s_city column
 * @method     array findBySState(string $s_state) Return ChildPluginInvoice objects filtered by the s_state column
 * @method     array findBySZip(string $s_zip) Return ChildPluginInvoice objects filtered by the s_zip column
 * @method     array findBySPhone(string $s_phone) Return ChildPluginInvoice objects filtered by the s_phone column
 * @method     array findBySFax(string $s_fax) Return ChildPluginInvoice objects filtered by the s_fax column
 * @method     array findBySEmail(string $s_email) Return ChildPluginInvoice objects filtered by the s_email column
 * @method     array findBySUrl(string $s_url) Return ChildPluginInvoice objects filtered by the s_url column
 * @method     array findBySDate(string $s_date) Return ChildPluginInvoice objects filtered by the s_date column
 * @method     array findBySTerms(string $s_terms) Return ChildPluginInvoice objects filtered by the s_terms column
 * @method     array findBySIsShipped(boolean $s_is_shipped) Return ChildPluginInvoice objects filtered by the s_is_shipped column
 *
 */
abstract class PluginInvoiceQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \HookCalendar\Model\Base\PluginInvoiceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\HookCalendar\\Model\\PluginInvoice', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginInvoiceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginInvoiceQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \HookCalendar\Model\PluginInvoiceQuery) {
            return $criteria;
        }
        $query = new \HookCalendar\Model\PluginInvoiceQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPluginInvoice|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PluginInvoiceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildPluginInvoice A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, UUID, ORDER_ID, FOREIGN_ID, ISSUE_DATE, DUE_DATE, CREATED, MODIFIED, STATUS, PAYMENT_METHOD, CC_TYPE, CC_NUM, CC_EXP_MONTH, CC_EXP_YEAR, CC_CODE, TXN_ID, PROCESSED_ON, SUBTOTAL, DISCOUNT, TAX, SHIPPING, TOTAL, PAID_DEPOSIT, AMOUNT_DUE, CURRENCY, NOTES, Y_LOGO, Y_COMPANY, Y_NAME, Y_STREET_ADDRESS, Y_COUNTRY, Y_CITY, Y_STATE, Y_ZIP, Y_PHONE, Y_FAX, Y_EMAIL, Y_URL, B_BILLING_ADDRESS, B_COMPANY, B_NAME, B_ADDRESS, B_STREET_ADDRESS, B_COUNTRY, B_CITY, B_STATE, B_ZIP, B_PHONE, B_FAX, B_EMAIL, B_URL, S_SHIPPING_ADDRESS, S_COMPANY, S_NAME, S_ADDRESS, S_STREET_ADDRESS, S_COUNTRY, S_CITY, S_STATE, S_ZIP, S_PHONE, S_FAX, S_EMAIL, S_URL, S_DATE, S_TERMS, S_IS_SHIPPED FROM plugin_invoice WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildPluginInvoice();
            $obj->hydrate($row);
            PluginInvoiceTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPluginInvoice|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the uuid column
     *
     * Example usage:
     * <code>
     * $query->filterByUuid('fooValue');   // WHERE uuid = 'fooValue'
     * $query->filterByUuid('%fooValue%'); // WHERE uuid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uuid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByUuid($uuid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uuid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uuid)) {
                $uuid = str_replace('*', '%', $uuid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::UUID, $uuid, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId('fooValue');   // WHERE order_id = 'fooValue'
     * $query->filterByOrderId('%fooValue%'); // WHERE order_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderId)) {
                $orderId = str_replace('*', '%', $orderId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the foreign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByForeignId(1234); // WHERE foreign_id = 1234
     * $query->filterByForeignId(array(12, 34)); // WHERE foreign_id IN (12, 34)
     * $query->filterByForeignId(array('min' => 12)); // WHERE foreign_id > 12
     * </code>
     *
     * @param     mixed $foreignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByForeignId($foreignId = null, $comparison = null)
    {
        if (is_array($foreignId)) {
            $useMinMax = false;
            if (isset($foreignId['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::FOREIGN_ID, $foreignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($foreignId['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::FOREIGN_ID, $foreignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::FOREIGN_ID, $foreignId, $comparison);
    }

    /**
     * Filter the query on the issue_date column
     *
     * Example usage:
     * <code>
     * $query->filterByIssueDate('2011-03-14'); // WHERE issue_date = '2011-03-14'
     * $query->filterByIssueDate('now'); // WHERE issue_date = '2011-03-14'
     * $query->filterByIssueDate(array('max' => 'yesterday')); // WHERE issue_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $issueDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByIssueDate($issueDate = null, $comparison = null)
    {
        if (is_array($issueDate)) {
            $useMinMax = false;
            if (isset($issueDate['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::ISSUE_DATE, $issueDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($issueDate['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::ISSUE_DATE, $issueDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::ISSUE_DATE, $issueDate, $comparison);
    }

    /**
     * Filter the query on the due_date column
     *
     * Example usage:
     * <code>
     * $query->filterByDueDate('2011-03-14'); // WHERE due_date = '2011-03-14'
     * $query->filterByDueDate('now'); // WHERE due_date = '2011-03-14'
     * $query->filterByDueDate(array('max' => 'yesterday')); // WHERE due_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $dueDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByDueDate($dueDate = null, $comparison = null)
    {
        if (is_array($dueDate)) {
            $useMinMax = false;
            if (isset($dueDate['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::DUE_DATE, $dueDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dueDate['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::DUE_DATE, $dueDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::DUE_DATE, $dueDate, $comparison);
    }

    /**
     * Filter the query on the created column
     *
     * Example usage:
     * <code>
     * $query->filterByCreated('2011-03-14'); // WHERE created = '2011-03-14'
     * $query->filterByCreated('now'); // WHERE created = '2011-03-14'
     * $query->filterByCreated(array('max' => 'yesterday')); // WHERE created > '2011-03-13'
     * </code>
     *
     * @param     mixed $created The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::CREATED, $created, $comparison);
    }

    /**
     * Filter the query on the modified column
     *
     * Example usage:
     * <code>
     * $query->filterByModified('2011-03-14'); // WHERE modified = '2011-03-14'
     * $query->filterByModified('now'); // WHERE modified = '2011-03-14'
     * $query->filterByModified(array('max' => 'yesterday')); // WHERE modified > '2011-03-13'
     * </code>
     *
     * @param     mixed $modified The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByModified($modified = null, $comparison = null)
    {
        if (is_array($modified)) {
            $useMinMax = false;
            if (isset($modified['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::MODIFIED, $modified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modified['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::MODIFIED, $modified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::MODIFIED, $modified, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the payment_method column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentMethod('fooValue');   // WHERE payment_method = 'fooValue'
     * $query->filterByPaymentMethod('%fooValue%'); // WHERE payment_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $paymentMethod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByPaymentMethod($paymentMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($paymentMethod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $paymentMethod)) {
                $paymentMethod = str_replace('*', '%', $paymentMethod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::PAYMENT_METHOD, $paymentMethod, $comparison);
    }

    /**
     * Filter the query on the cc_type column
     *
     * @param     mixed $ccType The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCcType($ccType = null, $comparison = null)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::CC_TYPE, $ccType, $comparison);
    }

    /**
     * Filter the query on the cc_num column
     *
     * @param     mixed $ccNum The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCcNum($ccNum = null, $comparison = null)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::CC_NUM, $ccNum, $comparison);
    }

    /**
     * Filter the query on the cc_exp_month column
     *
     * @param     mixed $ccExpMonth The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCcExpMonth($ccExpMonth = null, $comparison = null)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::CC_EXP_MONTH, $ccExpMonth, $comparison);
    }

    /**
     * Filter the query on the cc_exp_year column
     *
     * @param     mixed $ccExpYear The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCcExpYear($ccExpYear = null, $comparison = null)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::CC_EXP_YEAR, $ccExpYear, $comparison);
    }

    /**
     * Filter the query on the cc_code column
     *
     * @param     mixed $ccCode The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCcCode($ccCode = null, $comparison = null)
    {

        return $this->addUsingAlias(PluginInvoiceTableMap::CC_CODE, $ccCode, $comparison);
    }

    /**
     * Filter the query on the txn_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnId('fooValue');   // WHERE txn_id = 'fooValue'
     * $query->filterByTxnId('%fooValue%'); // WHERE txn_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByTxnId($txnId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $txnId)) {
                $txnId = str_replace('*', '%', $txnId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::TXN_ID, $txnId, $comparison);
    }

    /**
     * Filter the query on the processed_on column
     *
     * Example usage:
     * <code>
     * $query->filterByProcessedOn('2011-03-14'); // WHERE processed_on = '2011-03-14'
     * $query->filterByProcessedOn('now'); // WHERE processed_on = '2011-03-14'
     * $query->filterByProcessedOn(array('max' => 'yesterday')); // WHERE processed_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $processedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByProcessedOn($processedOn = null, $comparison = null)
    {
        if (is_array($processedOn)) {
            $useMinMax = false;
            if (isset($processedOn['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::PROCESSED_ON, $processedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($processedOn['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::PROCESSED_ON, $processedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::PROCESSED_ON, $processedOn, $comparison);
    }

    /**
     * Filter the query on the subtotal column
     *
     * Example usage:
     * <code>
     * $query->filterBySubtotal(1234); // WHERE subtotal = 1234
     * $query->filterBySubtotal(array(12, 34)); // WHERE subtotal IN (12, 34)
     * $query->filterBySubtotal(array('min' => 12)); // WHERE subtotal > 12
     * </code>
     *
     * @param     mixed $subtotal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySubtotal($subtotal = null, $comparison = null)
    {
        if (is_array($subtotal)) {
            $useMinMax = false;
            if (isset($subtotal['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::SUBTOTAL, $subtotal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subtotal['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::SUBTOTAL, $subtotal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::SUBTOTAL, $subtotal, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query on the tax column
     *
     * Example usage:
     * <code>
     * $query->filterByTax(1234); // WHERE tax = 1234
     * $query->filterByTax(array(12, 34)); // WHERE tax IN (12, 34)
     * $query->filterByTax(array('min' => 12)); // WHERE tax > 12
     * </code>
     *
     * @param     mixed $tax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByTax($tax = null, $comparison = null)
    {
        if (is_array($tax)) {
            $useMinMax = false;
            if (isset($tax['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::TAX, $tax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tax['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::TAX, $tax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::TAX, $tax, $comparison);
    }

    /**
     * Filter the query on the shipping column
     *
     * Example usage:
     * <code>
     * $query->filterByShipping(1234); // WHERE shipping = 1234
     * $query->filterByShipping(array(12, 34)); // WHERE shipping IN (12, 34)
     * $query->filterByShipping(array('min' => 12)); // WHERE shipping > 12
     * </code>
     *
     * @param     mixed $shipping The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByShipping($shipping = null, $comparison = null)
    {
        if (is_array($shipping)) {
            $useMinMax = false;
            if (isset($shipping['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::SHIPPING, $shipping['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shipping['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::SHIPPING, $shipping['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::SHIPPING, $shipping, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::TOTAL, $total, $comparison);
    }

    /**
     * Filter the query on the paid_deposit column
     *
     * Example usage:
     * <code>
     * $query->filterByPaidDeposit(1234); // WHERE paid_deposit = 1234
     * $query->filterByPaidDeposit(array(12, 34)); // WHERE paid_deposit IN (12, 34)
     * $query->filterByPaidDeposit(array('min' => 12)); // WHERE paid_deposit > 12
     * </code>
     *
     * @param     mixed $paidDeposit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByPaidDeposit($paidDeposit = null, $comparison = null)
    {
        if (is_array($paidDeposit)) {
            $useMinMax = false;
            if (isset($paidDeposit['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::PAID_DEPOSIT, $paidDeposit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paidDeposit['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::PAID_DEPOSIT, $paidDeposit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::PAID_DEPOSIT, $paidDeposit, $comparison);
    }

    /**
     * Filter the query on the amount_due column
     *
     * Example usage:
     * <code>
     * $query->filterByAmountDue(1234); // WHERE amount_due = 1234
     * $query->filterByAmountDue(array(12, 34)); // WHERE amount_due IN (12, 34)
     * $query->filterByAmountDue(array('min' => 12)); // WHERE amount_due > 12
     * </code>
     *
     * @param     mixed $amountDue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByAmountDue($amountDue = null, $comparison = null)
    {
        if (is_array($amountDue)) {
            $useMinMax = false;
            if (isset($amountDue['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::AMOUNT_DUE, $amountDue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amountDue['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::AMOUNT_DUE, $amountDue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::AMOUNT_DUE, $amountDue, $comparison);
    }

    /**
     * Filter the query on the currency column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrency('fooValue');   // WHERE currency = 'fooValue'
     * $query->filterByCurrency('%fooValue%'); // WHERE currency LIKE '%fooValue%'
     * </code>
     *
     * @param     string $currency The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByCurrency($currency = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($currency)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $currency)) {
                $currency = str_replace('*', '%', $currency);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::CURRENCY, $currency, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%'); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notes)) {
                $notes = str_replace('*', '%', $notes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::NOTES, $notes, $comparison);
    }

    /**
     * Filter the query on the y_logo column
     *
     * Example usage:
     * <code>
     * $query->filterByYLogo('fooValue');   // WHERE y_logo = 'fooValue'
     * $query->filterByYLogo('%fooValue%'); // WHERE y_logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yLogo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYLogo($yLogo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yLogo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yLogo)) {
                $yLogo = str_replace('*', '%', $yLogo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_LOGO, $yLogo, $comparison);
    }

    /**
     * Filter the query on the y_company column
     *
     * Example usage:
     * <code>
     * $query->filterByYCompany('fooValue');   // WHERE y_company = 'fooValue'
     * $query->filterByYCompany('%fooValue%'); // WHERE y_company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yCompany The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYCompany($yCompany = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yCompany)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yCompany)) {
                $yCompany = str_replace('*', '%', $yCompany);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_COMPANY, $yCompany, $comparison);
    }

    /**
     * Filter the query on the y_name column
     *
     * Example usage:
     * <code>
     * $query->filterByYName('fooValue');   // WHERE y_name = 'fooValue'
     * $query->filterByYName('%fooValue%'); // WHERE y_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYName($yName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yName)) {
                $yName = str_replace('*', '%', $yName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_NAME, $yName, $comparison);
    }

    /**
     * Filter the query on the y_street_address column
     *
     * Example usage:
     * <code>
     * $query->filterByYStreetAddress('fooValue');   // WHERE y_street_address = 'fooValue'
     * $query->filterByYStreetAddress('%fooValue%'); // WHERE y_street_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yStreetAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYStreetAddress($yStreetAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yStreetAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yStreetAddress)) {
                $yStreetAddress = str_replace('*', '%', $yStreetAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_STREET_ADDRESS, $yStreetAddress, $comparison);
    }

    /**
     * Filter the query on the y_country column
     *
     * Example usage:
     * <code>
     * $query->filterByYCountry(1234); // WHERE y_country = 1234
     * $query->filterByYCountry(array(12, 34)); // WHERE y_country IN (12, 34)
     * $query->filterByYCountry(array('min' => 12)); // WHERE y_country > 12
     * </code>
     *
     * @param     mixed $yCountry The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYCountry($yCountry = null, $comparison = null)
    {
        if (is_array($yCountry)) {
            $useMinMax = false;
            if (isset($yCountry['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::Y_COUNTRY, $yCountry['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($yCountry['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::Y_COUNTRY, $yCountry['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_COUNTRY, $yCountry, $comparison);
    }

    /**
     * Filter the query on the y_city column
     *
     * Example usage:
     * <code>
     * $query->filterByYCity('fooValue');   // WHERE y_city = 'fooValue'
     * $query->filterByYCity('%fooValue%'); // WHERE y_city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yCity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYCity($yCity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yCity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yCity)) {
                $yCity = str_replace('*', '%', $yCity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_CITY, $yCity, $comparison);
    }

    /**
     * Filter the query on the y_state column
     *
     * Example usage:
     * <code>
     * $query->filterByYState('fooValue');   // WHERE y_state = 'fooValue'
     * $query->filterByYState('%fooValue%'); // WHERE y_state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yState The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYState($yState = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yState)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yState)) {
                $yState = str_replace('*', '%', $yState);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_STATE, $yState, $comparison);
    }

    /**
     * Filter the query on the y_zip column
     *
     * Example usage:
     * <code>
     * $query->filterByYZip('fooValue');   // WHERE y_zip = 'fooValue'
     * $query->filterByYZip('%fooValue%'); // WHERE y_zip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yZip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYZip($yZip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yZip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yZip)) {
                $yZip = str_replace('*', '%', $yZip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_ZIP, $yZip, $comparison);
    }

    /**
     * Filter the query on the y_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByYPhone('fooValue');   // WHERE y_phone = 'fooValue'
     * $query->filterByYPhone('%fooValue%'); // WHERE y_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYPhone($yPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yPhone)) {
                $yPhone = str_replace('*', '%', $yPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_PHONE, $yPhone, $comparison);
    }

    /**
     * Filter the query on the y_fax column
     *
     * Example usage:
     * <code>
     * $query->filterByYFax('fooValue');   // WHERE y_fax = 'fooValue'
     * $query->filterByYFax('%fooValue%'); // WHERE y_fax LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yFax The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYFax($yFax = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yFax)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yFax)) {
                $yFax = str_replace('*', '%', $yFax);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_FAX, $yFax, $comparison);
    }

    /**
     * Filter the query on the y_email column
     *
     * Example usage:
     * <code>
     * $query->filterByYEmail('fooValue');   // WHERE y_email = 'fooValue'
     * $query->filterByYEmail('%fooValue%'); // WHERE y_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYEmail($yEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yEmail)) {
                $yEmail = str_replace('*', '%', $yEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_EMAIL, $yEmail, $comparison);
    }

    /**
     * Filter the query on the y_url column
     *
     * Example usage:
     * <code>
     * $query->filterByYUrl('fooValue');   // WHERE y_url = 'fooValue'
     * $query->filterByYUrl('%fooValue%'); // WHERE y_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByYUrl($yUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yUrl)) {
                $yUrl = str_replace('*', '%', $yUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::Y_URL, $yUrl, $comparison);
    }

    /**
     * Filter the query on the b_billing_address column
     *
     * Example usage:
     * <code>
     * $query->filterByBBillingAddress('fooValue');   // WHERE b_billing_address = 'fooValue'
     * $query->filterByBBillingAddress('%fooValue%'); // WHERE b_billing_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bBillingAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBBillingAddress($bBillingAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bBillingAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bBillingAddress)) {
                $bBillingAddress = str_replace('*', '%', $bBillingAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_BILLING_ADDRESS, $bBillingAddress, $comparison);
    }

    /**
     * Filter the query on the b_company column
     *
     * Example usage:
     * <code>
     * $query->filterByBCompany('fooValue');   // WHERE b_company = 'fooValue'
     * $query->filterByBCompany('%fooValue%'); // WHERE b_company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bCompany The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBCompany($bCompany = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bCompany)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bCompany)) {
                $bCompany = str_replace('*', '%', $bCompany);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_COMPANY, $bCompany, $comparison);
    }

    /**
     * Filter the query on the b_name column
     *
     * Example usage:
     * <code>
     * $query->filterByBName('fooValue');   // WHERE b_name = 'fooValue'
     * $query->filterByBName('%fooValue%'); // WHERE b_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBName($bName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bName)) {
                $bName = str_replace('*', '%', $bName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_NAME, $bName, $comparison);
    }

    /**
     * Filter the query on the b_address column
     *
     * Example usage:
     * <code>
     * $query->filterByBAddress('fooValue');   // WHERE b_address = 'fooValue'
     * $query->filterByBAddress('%fooValue%'); // WHERE b_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBAddress($bAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bAddress)) {
                $bAddress = str_replace('*', '%', $bAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_ADDRESS, $bAddress, $comparison);
    }

    /**
     * Filter the query on the b_street_address column
     *
     * Example usage:
     * <code>
     * $query->filterByBStreetAddress('fooValue');   // WHERE b_street_address = 'fooValue'
     * $query->filterByBStreetAddress('%fooValue%'); // WHERE b_street_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bStreetAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBStreetAddress($bStreetAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bStreetAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bStreetAddress)) {
                $bStreetAddress = str_replace('*', '%', $bStreetAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_STREET_ADDRESS, $bStreetAddress, $comparison);
    }

    /**
     * Filter the query on the b_country column
     *
     * Example usage:
     * <code>
     * $query->filterByBCountry(1234); // WHERE b_country = 1234
     * $query->filterByBCountry(array(12, 34)); // WHERE b_country IN (12, 34)
     * $query->filterByBCountry(array('min' => 12)); // WHERE b_country > 12
     * </code>
     *
     * @param     mixed $bCountry The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBCountry($bCountry = null, $comparison = null)
    {
        if (is_array($bCountry)) {
            $useMinMax = false;
            if (isset($bCountry['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::B_COUNTRY, $bCountry['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bCountry['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::B_COUNTRY, $bCountry['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_COUNTRY, $bCountry, $comparison);
    }

    /**
     * Filter the query on the b_city column
     *
     * Example usage:
     * <code>
     * $query->filterByBCity('fooValue');   // WHERE b_city = 'fooValue'
     * $query->filterByBCity('%fooValue%'); // WHERE b_city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bCity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBCity($bCity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bCity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bCity)) {
                $bCity = str_replace('*', '%', $bCity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_CITY, $bCity, $comparison);
    }

    /**
     * Filter the query on the b_state column
     *
     * Example usage:
     * <code>
     * $query->filterByBState('fooValue');   // WHERE b_state = 'fooValue'
     * $query->filterByBState('%fooValue%'); // WHERE b_state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bState The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBState($bState = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bState)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bState)) {
                $bState = str_replace('*', '%', $bState);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_STATE, $bState, $comparison);
    }

    /**
     * Filter the query on the b_zip column
     *
     * Example usage:
     * <code>
     * $query->filterByBZip('fooValue');   // WHERE b_zip = 'fooValue'
     * $query->filterByBZip('%fooValue%'); // WHERE b_zip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bZip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBZip($bZip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bZip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bZip)) {
                $bZip = str_replace('*', '%', $bZip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_ZIP, $bZip, $comparison);
    }

    /**
     * Filter the query on the b_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByBPhone('fooValue');   // WHERE b_phone = 'fooValue'
     * $query->filterByBPhone('%fooValue%'); // WHERE b_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBPhone($bPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bPhone)) {
                $bPhone = str_replace('*', '%', $bPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_PHONE, $bPhone, $comparison);
    }

    /**
     * Filter the query on the b_fax column
     *
     * Example usage:
     * <code>
     * $query->filterByBFax('fooValue');   // WHERE b_fax = 'fooValue'
     * $query->filterByBFax('%fooValue%'); // WHERE b_fax LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bFax The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBFax($bFax = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bFax)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bFax)) {
                $bFax = str_replace('*', '%', $bFax);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_FAX, $bFax, $comparison);
    }

    /**
     * Filter the query on the b_email column
     *
     * Example usage:
     * <code>
     * $query->filterByBEmail('fooValue');   // WHERE b_email = 'fooValue'
     * $query->filterByBEmail('%fooValue%'); // WHERE b_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBEmail($bEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bEmail)) {
                $bEmail = str_replace('*', '%', $bEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_EMAIL, $bEmail, $comparison);
    }

    /**
     * Filter the query on the b_url column
     *
     * Example usage:
     * <code>
     * $query->filterByBUrl('fooValue');   // WHERE b_url = 'fooValue'
     * $query->filterByBUrl('%fooValue%'); // WHERE b_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterByBUrl($bUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bUrl)) {
                $bUrl = str_replace('*', '%', $bUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::B_URL, $bUrl, $comparison);
    }

    /**
     * Filter the query on the s_shipping_address column
     *
     * Example usage:
     * <code>
     * $query->filterBySShippingAddress('fooValue');   // WHERE s_shipping_address = 'fooValue'
     * $query->filterBySShippingAddress('%fooValue%'); // WHERE s_shipping_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sShippingAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySShippingAddress($sShippingAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sShippingAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sShippingAddress)) {
                $sShippingAddress = str_replace('*', '%', $sShippingAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_SHIPPING_ADDRESS, $sShippingAddress, $comparison);
    }

    /**
     * Filter the query on the s_company column
     *
     * Example usage:
     * <code>
     * $query->filterBySCompany('fooValue');   // WHERE s_company = 'fooValue'
     * $query->filterBySCompany('%fooValue%'); // WHERE s_company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sCompany The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySCompany($sCompany = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sCompany)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sCompany)) {
                $sCompany = str_replace('*', '%', $sCompany);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_COMPANY, $sCompany, $comparison);
    }

    /**
     * Filter the query on the s_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySName('fooValue');   // WHERE s_name = 'fooValue'
     * $query->filterBySName('%fooValue%'); // WHERE s_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySName($sName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sName)) {
                $sName = str_replace('*', '%', $sName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_NAME, $sName, $comparison);
    }

    /**
     * Filter the query on the s_address column
     *
     * Example usage:
     * <code>
     * $query->filterBySAddress('fooValue');   // WHERE s_address = 'fooValue'
     * $query->filterBySAddress('%fooValue%'); // WHERE s_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySAddress($sAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sAddress)) {
                $sAddress = str_replace('*', '%', $sAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_ADDRESS, $sAddress, $comparison);
    }

    /**
     * Filter the query on the s_street_address column
     *
     * Example usage:
     * <code>
     * $query->filterBySStreetAddress('fooValue');   // WHERE s_street_address = 'fooValue'
     * $query->filterBySStreetAddress('%fooValue%'); // WHERE s_street_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sStreetAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySStreetAddress($sStreetAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sStreetAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sStreetAddress)) {
                $sStreetAddress = str_replace('*', '%', $sStreetAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_STREET_ADDRESS, $sStreetAddress, $comparison);
    }

    /**
     * Filter the query on the s_country column
     *
     * Example usage:
     * <code>
     * $query->filterBySCountry(1234); // WHERE s_country = 1234
     * $query->filterBySCountry(array(12, 34)); // WHERE s_country IN (12, 34)
     * $query->filterBySCountry(array('min' => 12)); // WHERE s_country > 12
     * </code>
     *
     * @param     mixed $sCountry The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySCountry($sCountry = null, $comparison = null)
    {
        if (is_array($sCountry)) {
            $useMinMax = false;
            if (isset($sCountry['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::S_COUNTRY, $sCountry['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sCountry['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::S_COUNTRY, $sCountry['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_COUNTRY, $sCountry, $comparison);
    }

    /**
     * Filter the query on the s_city column
     *
     * Example usage:
     * <code>
     * $query->filterBySCity('fooValue');   // WHERE s_city = 'fooValue'
     * $query->filterBySCity('%fooValue%'); // WHERE s_city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sCity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySCity($sCity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sCity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sCity)) {
                $sCity = str_replace('*', '%', $sCity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_CITY, $sCity, $comparison);
    }

    /**
     * Filter the query on the s_state column
     *
     * Example usage:
     * <code>
     * $query->filterBySState('fooValue');   // WHERE s_state = 'fooValue'
     * $query->filterBySState('%fooValue%'); // WHERE s_state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sState The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySState($sState = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sState)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sState)) {
                $sState = str_replace('*', '%', $sState);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_STATE, $sState, $comparison);
    }

    /**
     * Filter the query on the s_zip column
     *
     * Example usage:
     * <code>
     * $query->filterBySZip('fooValue');   // WHERE s_zip = 'fooValue'
     * $query->filterBySZip('%fooValue%'); // WHERE s_zip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sZip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySZip($sZip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sZip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sZip)) {
                $sZip = str_replace('*', '%', $sZip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_ZIP, $sZip, $comparison);
    }

    /**
     * Filter the query on the s_phone column
     *
     * Example usage:
     * <code>
     * $query->filterBySPhone('fooValue');   // WHERE s_phone = 'fooValue'
     * $query->filterBySPhone('%fooValue%'); // WHERE s_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySPhone($sPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sPhone)) {
                $sPhone = str_replace('*', '%', $sPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_PHONE, $sPhone, $comparison);
    }

    /**
     * Filter the query on the s_fax column
     *
     * Example usage:
     * <code>
     * $query->filterBySFax('fooValue');   // WHERE s_fax = 'fooValue'
     * $query->filterBySFax('%fooValue%'); // WHERE s_fax LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sFax The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySFax($sFax = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sFax)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sFax)) {
                $sFax = str_replace('*', '%', $sFax);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_FAX, $sFax, $comparison);
    }

    /**
     * Filter the query on the s_email column
     *
     * Example usage:
     * <code>
     * $query->filterBySEmail('fooValue');   // WHERE s_email = 'fooValue'
     * $query->filterBySEmail('%fooValue%'); // WHERE s_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySEmail($sEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sEmail)) {
                $sEmail = str_replace('*', '%', $sEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_EMAIL, $sEmail, $comparison);
    }

    /**
     * Filter the query on the s_url column
     *
     * Example usage:
     * <code>
     * $query->filterBySUrl('fooValue');   // WHERE s_url = 'fooValue'
     * $query->filterBySUrl('%fooValue%'); // WHERE s_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySUrl($sUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sUrl)) {
                $sUrl = str_replace('*', '%', $sUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_URL, $sUrl, $comparison);
    }

    /**
     * Filter the query on the s_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySDate('2011-03-14'); // WHERE s_date = '2011-03-14'
     * $query->filterBySDate('now'); // WHERE s_date = '2011-03-14'
     * $query->filterBySDate(array('max' => 'yesterday')); // WHERE s_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $sDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySDate($sDate = null, $comparison = null)
    {
        if (is_array($sDate)) {
            $useMinMax = false;
            if (isset($sDate['min'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::S_DATE, $sDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sDate['max'])) {
                $this->addUsingAlias(PluginInvoiceTableMap::S_DATE, $sDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_DATE, $sDate, $comparison);
    }

    /**
     * Filter the query on the s_terms column
     *
     * Example usage:
     * <code>
     * $query->filterBySTerms('fooValue');   // WHERE s_terms = 'fooValue'
     * $query->filterBySTerms('%fooValue%'); // WHERE s_terms LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sTerms The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySTerms($sTerms = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sTerms)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sTerms)) {
                $sTerms = str_replace('*', '%', $sTerms);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_TERMS, $sTerms, $comparison);
    }

    /**
     * Filter the query on the s_is_shipped column
     *
     * Example usage:
     * <code>
     * $query->filterBySIsShipped(true); // WHERE s_is_shipped = true
     * $query->filterBySIsShipped('yes'); // WHERE s_is_shipped = true
     * </code>
     *
     * @param     boolean|string $sIsShipped The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function filterBySIsShipped($sIsShipped = null, $comparison = null)
    {
        if (is_string($sIsShipped)) {
            $s_is_shipped = in_array(strtolower($sIsShipped), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PluginInvoiceTableMap::S_IS_SHIPPED, $sIsShipped, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPluginInvoice $pluginInvoice Object to remove from the list of results
     *
     * @return ChildPluginInvoiceQuery The current query, for fluid interface
     */
    public function prune($pluginInvoice = null)
    {
        if ($pluginInvoice) {
            $this->addUsingAlias(PluginInvoiceTableMap::ID, $pluginInvoice->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the plugin_invoice table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PluginInvoiceTableMap::clearInstancePool();
            PluginInvoiceTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPluginInvoice or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPluginInvoice object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginInvoiceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginInvoiceTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PluginInvoiceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginInvoiceTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PluginInvoiceQuery
