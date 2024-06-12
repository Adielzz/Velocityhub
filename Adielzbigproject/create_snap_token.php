<?php
require_once 'midtrans/Midtrans.php';

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-PMOh3u1QkIZdN8c7DdQlIuYH';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

header('Content-Type: application/json');

$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => intval($_POST['price']), // no decimal allowed for credit card
);

$item_details = array(
    array(
        'id' => 'a1',
        'price' => intval($_POST['price']),
        'quantity' => 1,
        'name' => $_POST['name']
    ),
);

$customer_details = array(
    'first_name' => "Customer",
    'last_name' => "Name",
    'email' => "customer@example.com",
    'phone' => "08111222333",
);

$transaction = array(
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details
);

$snapToken = \Midtrans\Snap::getSnapToken($transaction);
echo json_encode(['snapToken' => $snapToken]);
?>