<?php
header('Content-Type: text/html; charset=UTF-8');

// Paydo data
$publicKey = 'application-27';
$secretKey = '0a0642946ac8d8cb87008b9acfa7a07c';

// Order params
$params['amount'] = 1;
$params['currency'] = 'RUB';
$params['orderId'] = 1;
$params['paymentType'] = 'app';
$params['payment'] = 'ALL';

require_once('../Paydo.php');

$paydo = new Paydo($publicKey,$secretKey);
$response = $paydo->api('initPayment', $params);

if(!empty($response->result->payUrl)){
    header("Location: " . $response->result->payUrl);
}
