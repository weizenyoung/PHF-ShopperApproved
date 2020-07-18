<?php
  class Database {
    private $dbh;
    public $dataset;
    public $row;

    function __construct() {
      $this->connect();
    }
     
    private function connect() {
      $str = "mysql:host=" . DB_HOST;
      if (DB_PORT != '') {
        $str = $str . ";port=" . DB_PORT;
      }
      $str = $str . ";dbname=" . DB_NAME;
      $this->dbh = new PDO($str, DB_USER, DB_PASSWORD);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function secure($string) {
      // Because some servers still use magic quotes
      if (get_magic_quotes_gpc()) {
        if (!is_array($string)) {
          $string = htmlspecialchars(stripslashes(trim($string)));
        } else {
          foreach ($string as $key => $value) {
            $string[$key] = htmlspecialchars(stripslashes(trim($value)));
          }
        }
      } else {
        if (!is_array($string)) {
          $string = htmlspecialchars(trim($string));
        } else {
          foreach ($string as $key => $value) {
            $string[$key] = htmlspecialchars(trim($value));
          }
        }
      }

      return $string;
    }

    private function query($query, $params = array()) 
    {
      if (!is_array($params)) {
        throw new Exception('Invalid params array.');
      }
      
      $dbh = $this->dbh;
      if (empty($dbh)) {
        throw new Exception('Connection is empty.');
      }

      $stmt = $dbh->prepare($query);
      $stmt->execute($params);

      return $stmt;
    }

    public function insertPayload($json, $orderId, $statusId) {
      $sql = "INSERT INTO webhook_log(payload_json,  payload_order_id, payload_new_status_id) VALUES (:payload_json, :payload_order_id, :payload_new_status_id)";
      $params = [];
      $params[':payload_json'] = $json;
      $params[':payload_order_id'] = $orderId;
      $params[':payload_new_status_id'] = $statusId;
      $dataset = $this->query($sql, $params);         
      return $this->dbh->lastInsertId();
    }

    public function updateFollowUp($id, $followUp) {
      $sql = "UPDATE webhook_log SET follow_up  = :follow_up WHERE id = :id";
      $params = [];
      $params[':id'] = $id;
      $params[':follow_up'] = $followUp;
      $dataset = $this->query($sql, $params); 
    }

    public function updateResponse($id, $response) {
      $data = json_decode($response, true);
      $status = null;
      $message = null;
      $errorCode = null;
      if ($data) {
        if (isset($data['status'])) {
          $status = $data['status'];
        };
        if (isset($data['message'])) {
          $message = $data['message'];
        };
        if (isset($data['error_code'])) {
          $errorCode = $data['error_code'];
        }
        if (isset($data['error code'])) {
          $errorCode = $data['error code'];
        }
      };
  
      $sql = "
        UPDATE webhook_log 
        SET 
          response_json = :response_json,
          response_status = :response_status, 
          response_message = :response_message, 
          response_error_code = :response_error_code 
        WHERE id = :id";
      $params = [];
      $params[':id'] = $id;
      $params[':response_json'] = $response;
      $params[':response_status'] = $status;
      $params[':response_message'] = $message;
      $params[':response_error_code'] = $errorCode;
      $dataset = $this->query($sql, $params); 
    }
   
  }
