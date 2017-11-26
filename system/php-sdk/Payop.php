<?php
/**
 * Payop Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        Payop
 * @package         payop/payop
 * @version         1.0.3
 * @author          Payop
 * @copyright       Copyright (c) 2017 Payop
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

class Payop
{
    private $supportedPayopMethods = array('initPayment', 'getPayment', 'refundPayment');
    private $requiredPayopMethodsParams = array(
        'initPayment' => array('amount', 'currency', 'orderId', 'paymentType','payment'),
        'getPayment' => array('transactionId'),
        'refundPayment' => array('transactionId','refundAmount'),
    );

    private $apiUrl = 'https://payop.com/api/';
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
        if (isset($this->requiredPayopMethodsParams[$method])) {
            foreach ($this->requiredPayopMethodsParams[$method] as $rParam) {
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

        /*if (!in_array($ip, $this->supportedPayopIp)) {
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
