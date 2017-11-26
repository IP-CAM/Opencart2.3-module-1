<?php
class ModelExtensionPaymentPaydo extends Model {
    public function getMethod($address) {
        $this->load->language('extension/payment/paydo');

        if ($this->config->get('paydo_status')) {
            $status = TRUE;
        } else {
            $status = FALSE;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code'         => 'paydo',
                'title'      => $this->language->get('text_title'),
                'terms'      => '',
                'sort_order' => 0
            );
        }

        return $method_data;
    }
}
?>