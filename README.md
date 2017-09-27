# m1-field-checkout
custom field on checkout page magento 1.9.3

# use to review
    <div class="clear"></div>
    <div>
        <!-- question_ship -->
        <?php $scopeId = Mage::app()->getStore()->getStoreId(); ?>
        <?php if(Mage::app()->getStore($scopeId)->getConfig('questioncheckout/general/allow')):?>
            <div class="onestepcheckout-enable-terms">
                <label><?php echo Mage::app()->getStore($scopeId)->getConfig('questioncheckout/general/question');?> </label> <br>
                <input type="hidden" name="question_shipping[question]" value="<?php echo Mage::app()->getStore($scopeId)->getConfig('questioncheckout/general/question');?>">
                <?php
                $questionShippingOptions = Mage::app()->getStore($scopeId)->getConfig('questioncheckout/general/options');
                if ($questionShippingOptions) {
                    $qs_options = unserialize($questionShippingOptions);
                    if (is_array($qs_options)) {
                        foreach($qs_options as $qs_key => $qs_row) : ?>
                            <input type="checkbox" id="qs_row_<?php echo $qs_key;?>" name="question_shipping[answers][]" value="<?php echo $qs_row['value']; ?>"> <label for="qs_row_<?php echo $qs_key;?>"><?php echo $qs_row['value']; ?> </label><br>
                        <?php endforeach;
                    }
                }
                ?>
            </div>
        <?php endif ?>
    </div>

# use in email

{{depend order.getQuestioncheckoutFieldHtml()}}
<tr>
    <td class="address-details">
        <p>{{var order.getQuestioncheckoutFieldHtml()}} &nbsp;</p>
    </td>
</tr>
{{/depend}}