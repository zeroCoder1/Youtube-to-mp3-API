<?php 

include 'defines.php';

define('LOG_FILE', './ipn.log');

if(!USE_KEYS) exit;

$raw = file_get_contents('php://input');
parse_str($raw, $array);

$file = fopen(LOG_FILE, 'a');
fwrite($file, '['.date('Y/m/d H:i:s').']' . json_encode($array) . PHP_EOL);
fclose($file);

$keyfile = fopen(KEY_FILE, 'w');

$json = json_decode(file_get_contents(KEY_FILE), true);

if(isset($array['txn_type'])) {
    $txn_type = $array['txn_type'];
    $payerEmail = $array['payer_email'];

    if($txn_type == 'subscr_payment') {
        if(strtolower($array['payment_status']) == 'completed') {
            $key = bin2hex(random_bytes(32));
            $json[$payerEmail] = $key;

            mail($payerEmail, 'Your API key for ' . GET_KEY_AT, 'Hi, We\'ve successfully received your payment for your subscription to the service. Your api key is "'.$key.'" - do not loose this key.');
        }
    } elseif($txn_type == 'subscr_cancel') {
        unset($json[$payerEmail]);
    }
}

fwrite($keyfile, json_encode($json, JSON_FORCE_OBJECT));
fclose($keyfile);