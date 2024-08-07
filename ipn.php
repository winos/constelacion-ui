<?php
$cp_merchant_id = 'TU_PUBLIC_KEY';
$cp_ipn_secret = 'TU_PRIVATE_KEY';
$cp_debug_email = 'tu_email@example.com';

function errorAndDie($error_msg)
{
    global $cp_debug_email;
    if (!empty($cp_debug_email)) {
        $report = 'Error: ' . $error_msg . "\n\n";
        $report .= "POST Data\n\n";
        foreach ($_POST as $k => $v) {
            $report .= "| $k | $v |\n";
        }
        mail($cp_debug_email, 'CoinPayments IPN Error', $report);
    }
    die('IPN Error: ' . $error_msg);
}

if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
    errorAndDie('IPN Mode is not HMAC');
}

if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
    errorAndDie('No HMAC signature sent.');
}

$request = file_get_contents('php://input');
if ($request === FALSE || empty($request)) {
    errorAndDie('Error reading POST data');
}

if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
    errorAndDie('No or incorrect Merchant ID passed');
}

$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
    errorAndDie('HMAC signature does not match');
}

// Proceso de IPN aquí
// Verifica el estado del pago y actualiza la base de datos según sea necesario

http_response_code(200);
echo "IPN OK";
?>
