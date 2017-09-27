<?php
class Dreamcode_QuestionCheckout_Block_System_Config_Form_Field_Questionoptions extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct()
    {
        $this->addColumn('value', array(
            'label' => Mage::helper('questioncheckout')->__('Options'),
            'style' => 'width:250px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('questioncheckout')->__('Add');
        parent::__construct();
    }
}