<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/coinpaymentsnet/coinpayments-php/src/CoinpaymentsAPI.php'; 
require(__DIR__ .'/src/keys.php');

try {
    $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');
    $information = $cps_api->GetBasicInfo();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// Check for success of API call
if ($information['error'] == 'ok') {
    // Prepare start of sample HTML output
    $output = '<table><tbody><tr><td>Username</td><td>Merchant ID</td><td>Email</td><td>Public Name</td></tr>';
    $output .= '<tr><td>' . $information['result']['username'] . '</td><td>' . $information['result']['merchant_id'] . '</td><td>' . $information['result']['email'] . '</td><td>' . $information['result']['public_name'] . '</td></tr>';
    
    // Close the sample output HTML and echo it onto the page
    $output .= '</tbody></table>';
    echo $output;
} else {
    // Throw an error if both API calls were not successful
    echo 'There was an error returned by the API call: ' . $information['error'];
}