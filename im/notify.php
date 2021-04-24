<?php
//echo json_encode($_POST);

$orderId = $_POST["orderId"];
$orderAmount = $_POST["orderAmount"];
$referenceId = $_POST["referenceId"];
$txStatus = $_POST["txStatus"];
$paymentMode = $_POST["paymentMode"];
$txMsg = $_POST["txMsg"];
$txTime = $_POST["txTime"];
$signature = $_POST["signature"];
$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
$secretKey = "f0051992cf1487372eaa81f964c071811e8108ed";
$hash_hmac = hash_hmac('sha256', $data, $secretKey, true) ;
$computedSignature = base64_encode($hash_hmac);
if ($signature == $computedSignature) {
   echo "<h1>Your order is successfully confirmed!</h1>";
 } else {
   echo "<h1>Something went wrong</h1>";
  // Reject this call
}
?>
