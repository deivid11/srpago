<?php
/**
 * Created by PhpStorm.
 * User: epalacio
 * Date: 10/8/2017
 * Time: 1:51 PM
 * Edited by Deivid11
 */
namespace ApiSrPago;

include_once 'init.php';

class SrPago
{
    private $apiKey;

    private $apiSecret;

    private $liveMode;

    public function __construct($apiKey, $apiSecret, $liveMode)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->liveMode = $liveMode;
    }

    public function Setup(){

        \SrPago\SrPago::$apiKey = $this->apiKey; //Aquí va tu App Key
        \SrPago\SrPago::$apiSecret = $this->apiSecret; // Aquí va tu App Secret
        \SrPago\SrPago::$liveMode = ($this->liveMode === 'true') ? true : false; // false = Sandbox true = Producción

    }


    /*
    *
    *    Función para crear un nuevo Customer, necesario para tokenización OnDemand
    *
    */
    /**
     *
     * @param array $parameters
     * @return mixed
     */
    public function createCustomer($data){
        $customerService = new \SrPago\Customer();

        $newCustomer = $customerService->create($data);

        return $newCustomer;

    }

    /*
     *
     * Función para encontrar un Customer
     *
     */
    /**
     *
     * @param array $parameters
     * @return mixed
     */
    public function findCustomer($data){
        $customerService = new \SrPago\Customer();

        $newCustomer = $customerService->find($data);

        return $newCustomer;
    }


    /*
     *
     * Función para agregarle una tarjeta a un Customer (Tokenización onDemand)
     *
     */

    /**
     *
     * @param array $parameters
     * @return mixed
     */
    public function addCardToCustomer($user, $token){
        $customerCardService = new \SrPago\CustomerCards();

        $newCard = $customerCardService->add($user, $token);

        return $newCard;
    }


    /*
     *
     * Función para quitarle una tarjeta a un Customer
     *
     */

    /**
     *
     * @param string $user
     * @param string token
     * @return mixed
     */
    public function removeCustomerCard($user, $token){
        $customerCardService = new \SrPago\CustomerCards();

        $removedCard = $customerCardService->remove($user, $token);

        return $removedCard;
    }


    /*
     *
     * Función para Crear un Cargo
     *
     */

    /**
     *
     * @param array $chargeParams
     * @param array metadata
     * @return mixed
     */
    public function ChargesCreateCharge($chargeParams, $metadata){
        $chargesService = new \SrPago\Charges();

        $chargeParams['metadata'] = $metadata;

        $newCharge = $chargesService->create($chargeParams);

        return $newCharge;
    }

    /**
     * @param $transaction
     * @return mixed
     */
    public function cancelOperation($transaction)
    {
        $cancelOperationService = new \SrPago\Operations();

        $cancelOperation = $cancelOperationService->reversal($transaction);

        return $cancelOperation;
    }

    /**
     * @param $transaction
     * @param $email
     * @return array
     */
    public function sendOperationByEmail($transaction, $email)
    {
        $sendOperationService = new \SrPago\Operations();

        $data = [
            'id' => $transaction,
            'email' => $email
        ];

        $sendOperationByEmail = $sendOperationService->sendEmail($data);

        return $sendOperationByEmail;
    }
    
        public function getTransactionData($token)
    {
        $chargeService = new \SrPago\Charges();

        return $chargeService->retreive($token);

    }

}

?>
