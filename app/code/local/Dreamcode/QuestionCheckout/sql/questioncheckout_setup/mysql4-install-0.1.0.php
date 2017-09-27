<?php
$installer = $this;
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer->startSetup();

$this->getConnection()->dropColumn($this->getTable('sales_flat_order'), 'questioncheckout_field');
$this->getConnection()->dropColumn($this->getTable('sales_flat_quote'), 'questioncheckout_field');

$installer->addAttribute('order', 'questioncheckout_field', array('type' => 'text', 'default' => ''));
$installer->addAttribute('quote', 'questioncheckout_field', array('type' => 'text', 'default' => ''));


$installer->endSetup();