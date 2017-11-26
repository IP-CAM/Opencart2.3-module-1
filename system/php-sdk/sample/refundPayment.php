<?php
header('Content-Type: text/html; charset=UTF-8');

// Paydo data
$publicKey = 'application-27';
$secretKey = '0a0642946ac8d8cb87008b9acfa7a07c';

// Order params
$params['transactionId'] = 1222;
$params['refundAmount'] = 1;

require_once('../Paydo.php');

$paydo = new Paydo($publicKey,$secretKey);
$response = $paydo->api('refundPayment', $params);

print_r($response);