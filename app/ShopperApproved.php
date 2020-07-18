<?php
  class ShopperApproved
  {

    public function send($reviewId, $fields) 
    {
      $header = array();
      $header[] = "Accept: application/json";
      $header[] = "Content-Type: application/x-www-form-urlencoded";

      $url = 'https://api.shopperapproved.com/reviews/' . SA_SITE_ID . '/' . $reviewId . '?xml=false';
      $fields = 'token=' . SA_API_TOKEN . '&' . $fields;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
      $response = curl_exec($ch);
      $errno = curl_errno($ch);
      if ($errno) {
        $error = curl_strerror($errno);
        throw new Exception($error);
      }
      curl_close($ch);

      /*
      {
        "error_code": 404,
        "message": "We could not find this review in oursystem."
      }
      { 
        "status": "success", 
        "message": "The followup date for this review has been updated." 
      } 
      {
        "message": "Already cancelled", 
        "cancelled_on": "Tue, 23 Jun 2020 00:00:00 GMT"
      }
      */

      /*
      $data = json_decode($response, true);
      if ($data === null) {
        throw new Exception('Invalid response!');
      }

      if (isset($data['error_code'])) {
        if (isset($data['message'])) {
          throw new Exception('Error: ' . $data['message']);
        } else {
          throw new Exception('Error: ' . $response);
        }
      }
      if (isset($data['status']) && $data['status'] != 'success') {
        if (isset($data['message'])) {
          throw new Exception('Error: ' . $data['message']);
        } else {
          throw new Exception('Error: ' . $response);
        }
      }
      */

      return $response;
    }
  }
