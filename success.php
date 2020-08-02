<?php

/**
 * Emulates javascript fetch
 * @param string $url the url to fetch
 * @return string the response
 */
function fetch(string $url): string
{
    if (!empty($url)) {
        $timeout = 90;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        $content = curl_exec($curl);
        curl_close($curl);

        return trim($content);
    }
}

echo '<h2>REQUEST</h2>';
echo "<pre>" . print_r($_REQUEST, true) . "</pre>";

//GET PAYMENT
if (array_key_exists('collection_id', $_REQUEST)) $id = $_REQUEST['collection_id'];
elseif (array_key_exists('data_id', $_REQUEST)) $id = $_REQUEST['data_id'];
elseif (array_key_exists('id', $_REQUEST)) $id = $_REQUEST['id'];
else $id = '';

if (is_numeric($id)) {

    if (array_key_exists('preference_id', $_REQUEST)) $preference_id = $_REQUEST['preference_id'];
    else $preference_id = '';

    echo "<p>{$preference_id}</p><br/>" .
        "<p>{$id}</p></br>";

    echo fetch('https://ircsasw-mp-ecommerce-php.herokuapp.com/webhook.txt');

    $payment_url = "https://api.mercadopago.com/v1/payments/{$id}?access_token=" . 'APP_USR-1159009372558727-072921-8d0b9980c7494985a5abd19fbe921a3d-617633181';
    echo "<hr><h2>PAYMENT DATA</h2><p><a href='{$payment_url}' target='_blank'>{$payment_url}</a></p>";
    $fetch = json_decode(fetch($payment_url), true);
    echo "<pre>" . print_r($fetch, true) . "</pre>";
}
