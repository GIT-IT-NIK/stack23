<?php
session_start();
/*
include 'store.php';
echo $email."</br>";
echo $name."</br>";
echo $phone."</br>";
echo $gender."</br>";
echo $ogname."</br>";
echo $ieee_no."</br>";
echo $member_type."</br>";
echo $wie_no."</br>";
echo $location."</br>";*/

$nvalue = $_SESSION['NAME'];
$evalue = $_SESSION['EMAIL'];
$pvalue = $_SESSION['PHONE'];

$orderId = $_POST["orderId"];
$orderAmount = $_POST["amount"];

//echo $orderId . "|" . $orderAmount;
$host = "https://0461f3ccc57a.ngrok.io";
//$host = "localhost";
$notifyUrl = $host. "/icsm/notify.php";
$returnUrl = $host. "/icsm/return.php";

/*
$email = $_POST["r_email"];
$name = $_POST["name"];
$phone = $_POST["phone"];

echo $name."</br>";
echo $email."</br>";
echo $phone."</br>";
*/

$orderDetails = array();
$orderDetails["notifyUrl"] = $notifyUrl;
$orderDetails["returnUrl"] = $returnUrl;

$userDetails = getUserDetails($orderId);
$order = getOrderDetails($orderId);

$orderDetails["customerName"] = $userDetails["customerName"];
$orderDetails["customerEmail"] = $userDetails["customerEmail"];
$orderDetails["customerPhone"] = $userDetails["customerPhone"];

$orderDetails["orderId"] = $order["orderId"];
$orderDetails["orderAmount"] = $order["orderAmount"];
$orderDetails["orderNote"] = $order["orderNote"];
$orderDetails["orderCurrency"] = $order["orderCurrency"];

$orderDetails["appId"] = "109962618088ea8ed6157b2489269901";

$orderDetails["signature"] = generateSignature($orderDetails);

//echo json_encode($orderDetails);

function generateSignature($postData){
  $secretKey = "f0051992cf1487372eaa81f964c071811e8108ed";
 ksort($postData);
 $signatureData = "";
 foreach ($postData as $key => $value){
      $signatureData .= $key.$value;
 }
 $signature = hash_hmac('sha256', $signatureData, $secretKey,true);
 $signature = base64_encode($signature);
 return $signature;
}



function getUserDetails($orderId) {
	global $nvalue;
	global $evalue;
	global $pvalue;
    return array(
      "customerName" => "$nvalue",
      "customerEmail" => "$evalue",
      "customerPhone" => "$pvalue"
    );
}

function getOrderDetails($orderId) {
  return array(
    "orderId" => time(),
    "orderAmount" => "1",
    "orderNote" => "test order",
    "orderCurrency" => "INR"
  );
}
?>

<form id="redirectForm" method="post" action="https://www.cashfree.com/checkout/post/submit">
    <input type="hidden" name="appId" value="<?php echo $orderDetails["appId"] ?>"/>
    <input type="hidden" name="orderId" value="<?php echo $orderDetails["orderId"] ?>"/>
    <input type="hidden" name="orderAmount" value="<?php echo $orderDetails["orderAmount"] ?>"/>
    <input type="hidden" name="orderCurrency" value="<?php echo $orderDetails["orderCurrency"] ?>"/>
    <input type="hidden" name="orderNote" value="<?php echo $orderDetails["orderNote"] ?>"/>
    <input type="hidden" name="customerName" value="<?php echo $orderDetails["customerName"] ?>"/>
    <input type="hidden" name="customerEmail" value="<?php echo $orderDetails["customerEmail"] ?>"/>
    <input type="hidden" name="customerPhone" value="<?php echo $orderDetails["customerPhone"] ?>"/>
    <input type="hidden" name="returnUrl" value="<?php echo $orderDetails["returnUrl"] ?>"/>
    <input type="hidden" name="notifyUrl" value="<?php echo $orderDetails["notifyUrl"] ?>"/>
    <input type="hidden" name="signature" value="<?php echo $orderDetails["signature"] ?>"/>
  </form>

  <script>document.getElementById("redirectForm").submit();</script>
