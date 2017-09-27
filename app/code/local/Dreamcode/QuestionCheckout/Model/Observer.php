<?php
class Dreamcode_QuestionCheckout_Model_Observer  {

    /**
     * This function is called just before $quote object get stored to database.
     * Here, from POST data, we capture our custom field and put it in the quote object
     * @param  $evt
     */
    public function saveQuoteBefore($evt){
        $quote = $evt->getQuote();
        $post = Mage::app()->getFrontController()->getRequest()->getPost();
        if(isset($post['question_shipping']['answers'])){
            Mage::log($post['question_shipping']);
            $var = serialize($post['question_shipping']);
            $quote->setData('questioncheckout_field',$var);
        }

        return $this;
    }
    /**
     * This function is called, just after $quote object get saved to database.
     * Here, after the quote object gets saved in database
     * we save our custom field in the our table created i.e sales_quote_custom
     * @param  $evt
     */
    public function saveQuoteAfter($evt){
        $quote = $evt->getQuote();
        Mage::log(__LINE__.' '.__METHOD__);
        Mage::log($quote->getData('questioncheckout_field'));
    }
    /**
     *
     * When load() function is called on the quote object,
     * we read our custom fields value from database and put them back in quote object.
     * @param  $evt
     */
    public function loadQuoteAfter($evt){
        $quote = $evt->getQuote();
        Mage::log(__LINE__.' '.__METHOD__);
        Mage::log($quote->getData('questioncheckout_field'));
    }

    /**
     *
     * This function is called when $order->load() is done.
     * Here we read our custom fields value from database and set it in order object.
     * @param  $evt
     */
    public function loadOrderAfter($evt){
        $order = $evt->getOrder();
        $var = $order->getData('questioncheckout_field');
        if($var == '' || !isset($var)){
            $order->setData('questioncheckout_field_html', false);
            return $this;
        }
        $var = unserialize($var);
        if(!array_key_exists('answers', $var )){
            $order->setData('questioncheckout_field_html', false);
            return $this;
        }

        $question = $var['question'];
        $html = '';
        $html = '<p><b>'.$question.'</b></p>';
        foreach ($var['answers'] as $answer){
            $html.= '<p>'.$answer.'</p>';
        }
        Mage::log(__LINE__.' '.__METHOD__);
        Mage::log($html);

        $order->setData('questioncheckout_field_html',$html);
        $order->save();

        Mage::log($order->getData('questioncheckout_field_html'));
        return $this;
    }

    public function printDebugBacktrace($title = 'Debug Backtrace:')
    {
        $output = "";
        $output .= "
            <hr />
            <div>" . $title . '
            <table border="1" cellpadding="2" cellspacing="2">';
        $stacks = debug_backtrace(); $output .= "
            <thead>
                <tr>
                    <th><strong>File</strong></th>
                    <th><strong>Line</strong></th>
                    <th><strong>Function</strong></th>
                    " . "
                </tr>
            </thead>
        ";
        foreach ($stacks as $_stack) {
            if (!isset($_stack['file'])) $_stack['file'] = '[PHP Kernel]';
            if (!isset($_stack['line'])) $_stack['line'] = '';
            $output .= "
                <tr>
                    <td>{$_stack["file"]}</td>
                    <td>{$_stack["line"]}</td>
                    " . "
                    <td>{$_stack["function"]}</td>
                </tr>
            ";
        }
        $output .= "</table></div><hr />";
        return $output;
    }
}