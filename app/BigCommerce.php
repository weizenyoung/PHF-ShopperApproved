<?php
  class BigCommerce
  {
    const ORDER_STATUS_SHIPPED = 2;
    const ORDER_STATUS_CANCELLED = 5;

    private $server;
    private $header;

    function __construct()
    {
      $this->server = 'https://api.bigcommerce.com/stores/' . BC_STORE_HASH . '/v2/';

      $this->header = array();
      $this->header[] = "Accept: application/json";
      $this->header[] = "Content-Type: application/json";
      $this->header[] = "X-Auth-Client: " . BC_CLIENT_ID;
      $this->header[] = "X-Auth-Token: " . BC_ACCESS_TOKEN;
    }
   
    public function createWebhook() 
    {
      $url = $this->server . 'hooks/';
      $fields = '{
        "scope": "store/order/statusUpdated",
        "destination": "https://scripts.paulshomefashions.com/shopperapproved/public/webhook.php",
        "is_active": true
      }';
   
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;
    }

    public function getWebhooks() 
    {
      $url = $this->server . 'hooks/';
   
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;
    }    

    public function deleteWebhook($id) 
    {
      $url = $this->server . "hooks/{$id}";
  
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      
      $response = curl_exec($ch);
      curl_close($ch);
      echo $response;
    }    
    /*
    public function getOrder($orderId) 
    {
      $url = $this->server . 'orders/' . $orderId;
  
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      
      $response = curl_exec($ch);

      $errno = curl_errno($ch);
      if ($errno) {
        $error = curl_strerror($errno);
        throw new Exception($error);
      }
      curl_close($ch);

      $data = json_decode($response, true);
      if ($data === null) {
        throw new Exception('Invalid response!');
      }
      
      return $data;
    }
    */
    
  }
