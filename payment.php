<?php
require 'vendor/autoload.php';
require __DIR__ . '/vendor/coinpaymentsnet/coinpayments-php/src/CoinpaymentsAPI.php'; 
require(__DIR__ .'/src/keys.php');

// Obtener datos del formulario
$price_amount = $_POST['price_amount'];
$price_currency = $_POST['price_currency'];
$pay_currency = $_POST['pay_currency'];

// Crear un cliente Nowpayments
$client = new CoinpaymentsAPI($private_key, $public_key, 'json');

try {
    // Crear el pago
    $payment = $client->createPayment([
        'price_amount' => $price_amount,
        'price_currency' => $price_currency,
        'pay_currency' => $pay_currency,
        'ipn_callback_url' => 'https://tu_dominio.com/ipn_handler.php', // Asegúrate de cambiar esto por tu URL real
        'order_id' => '1234', // Puedes generar un ID único para cada pedido
        'order_description' => 'Pago por plan premium',
    ]);

    // Redirigir al usuario a la URL de pago
    header('Location: ' . $payment['pay_url']);
    exit();
} catch (Exception $e) {
    echo "Error al crear el pago: " . $e->getMessage();
}
?>
