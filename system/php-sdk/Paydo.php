<?php
/**
 * Paydo Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        Paydof
 * @package         paydo/paydo
 * @version         1.0.0
 * @author          Paydo
 * @copyright       Copyright (c) 2017 Paydo
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

class Paydo
{
    private $supportedPaydoMethods = array('initPayment', 'getPayment', 'refundPayment');
    private $requiredPaydoMethodsParams = array(
        'initPayment' => array('amount', 'currency', 'orderId', 'paymentType','payment'),
        'getPayment' => array('transactionId'),
        'refundPayment' => array('transactionId','refundAmount'),
    );

    private $apiUrl = 'https://paydo.com/api/';
    private $publicKey;
    private $secretKey;

    public function __construct($publicKey = null, $secretKey = null)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }


    /**
     * Call API
     */
    public function api($method, $params = array())
    {
        if (isset($this->requiredPaydoMethodsParams[$method])) {
            foreach ($this->requiredPaydoMethodsParams[$method] as $rParam) {
                if (!isset($params[$rParam])) {
                    throw new InvalidArgumentException('Param '.$rParam.' is null');
                }
            }
        }

        $params['secretKey'] = $this->secretKey;
        if (empty($params['secretKey'])) {
            throw new InvalidArgumentException('SecretKey is null');
        }

        $params['publicKey'] = $this->publicKey;
        if (empty($params['publicKey'])) {
            throw new InvalidArgumentException('PublicKey is null');
        };

        /*if (!in_array($ip, $this->supportedPaydoIp)) {
            throw new InvalidArgumentException('IP address Error');
        }*/

        $requestUrl = $this->apiUrl.$method.'?'.http_build_query($params);

        $response = file_get_contents($requestUrl);
        /*if (!is_object($response)) {
            throw new InvalidArgumentException('Temporary server error. Please try again later.');
        }*/

        return $response;

    }

}
