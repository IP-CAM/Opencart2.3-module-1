<?php

class ControllerExtensionPaymentpaydo extends Controller {
    public function index() {
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['button_back'] = $this->language->get('button_back');
        $data['text_loading'] = $this->language->get('text_loading');

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $data['paydo_login'] = $this->config->get('paydo_login');
        $data['paydo_key']= $this->config->get('paydo_key');
        $data['success_url'] = $this->config->get('paydo_success_url');
        $data['fail_url'] = $this->config->get('paydo_fail_url');

        $params['amount'] = $order_info['total'];
        $params['currency'] = $order_info['currency_code'];
        $params['orderId'] = $order_info['order_id'];
        $params['paymentType'] = 'app';
        $params['payment'] = 'ALL';
        $params['language'] = 'ru';
        $params['result_url'] = $data['success_url'];
        $params['fail_url'] = $data['fail_url'];

        require $_SERVER['DOCUMENT_ROOT']."/system/php-sdk/Paydo.php";

        $paydo = new Paydo($data['paydo_login'],$data['paydo_key']);
        $response = $paydo->api('initPayment', $params);

        if(!empty($response->result->payUrl)){
            $data['merchant_url'] =  $response->result->payUrl;
            return $this->load->view('extension/payment/paydo.tpl', $data);
        }else{
            print_r($response);
            exit;
        }
    }
}
?>