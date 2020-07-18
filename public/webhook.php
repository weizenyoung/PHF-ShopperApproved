<?php
  require("../app/init.php");

  $payload = '';
  $response =  '';
  writeLog('Started');
  try {
    writeLog('Getting payload...');
    $payload = file_get_contents("php://input");
    writeLog($payload);
    $json = json_decode($payload, true);

    writeLog('Connecting to database...');
    $database = new Database();

    $orderId = null;
    if (isset($json['data']['id'])) {
      $orderId = $json['data']['id'];
    }
    $statusId = null;
    if (isset($json['data']['status']['new_status_id'])) {
      $statusId = $json['data']['status']['new_status_id'];
    }
    $id = $database->insertPayload($payload, $orderId, $statusId);
    writeLog('Database ID: ' . $id);

    if (!isset($json['data'])) {
      throw new Exception('No data property');
    }
    if (!isset($json['data']['type'])) {
      throw new Exception('No type property');
    }
    if (!isset($json['data']['id'])) {
      throw new Exception('No id property');
    }
    if (!isset($json['data']['status'])) {
      throw new Exception('No status property');
    }
    if (!isset($json['data']['status']['new_status_id'])) {
      throw new Exception('No new_status_id property');
    }
    if (($json['data']['type'] == 'order')) {
      if ($statusId == BigCommerce::ORDER_STATUS_SHIPPED) {
        writeLog('ReviewId: ' . $orderId);
        $followUp = date("Y-m-d", strtotime("+ 10 days"));
        writeLog('FollowUp: ' . $followUp);
        writeLog('Update follow up');
        $database->updateFollowUp($id, $followUp);
        $sa = new ShopperApproved();
        writeLog('Sending shipped status...');
        $response = $sa->send($orderId, 'followup=' . $followUp);
        writeLog($response);
        $database->updateResponse($id, $response);
      }
      if ($statusId == BigCommerce::ORDER_STATUS_CANCELLED) {
        writeLog('ReviewId: ' . $orderId);
        $sa = new ShopperApproved();
        writeLog('Sending cancelled status...');
        $response = $sa->send($orderId, 'cancel=1');
        writeLog($response);
        $database->updateResponse($id, $response);
      }
    }
 
    writeLog('Finished');
  } catch (Exception $e) {
    $error = $e->getMessage();
    writeError($error);
    writeError($payload);
    writeError($response);
    writeLog($error);
  }
