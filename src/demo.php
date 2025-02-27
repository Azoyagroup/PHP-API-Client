<?php
require 'sdk.php';

use Azoya\API\SDK;

define('TEST_API_URL', 'https://example.com');

// This is demo!!!
$sdk = new SDK(TEST_API_URL, 'exampleProviderCode', 'exampleApiKey', 'exampleApiSecret');

// Get Token
try {
    $tokenResponse = $sdk->getToken();
    $token = $tokenResponse["token"];
    echo 'Get Token: ' . $token . "\n";
} catch (Exception $e) {
    echo "Error Get Token: " . $e->getMessage();
    return;
}


// Product Create
$ProductCreateJson = '{
    "items": [
        {
            "sku": "exampletest80001",
            "name": "Down jacket for testM / Black0.8kg",
            "price": 3000,
            "special_price": 3000,
            "currency_code": "EUR",
            "qty": 1007,
            "is_in_stock": 1,
            "status": 1,
            "fields": [
                {
                    "name": "secondary_name",
                    "value": "Down jacket for testM / Black0.8kg"
                },
                {
                    "name": "size",
                    "value": "0.8kg"
                },
                {
                    "name": "barcode",
                    "value": "11002233"
                },
                {
                    "name": "color",
                    "value": "Black"
                }
            ]
        },
        {
            "sku": "exampletest80002",
            "name": "Down jacket for testL / Red0.8kg",
            "price": 3100,
            "special_price": 3100,
            "currency_code": "EUR",
            "qty": 18,
            "is_in_stock": 1,
            "status": 1,
            "fields": [
                {
                    "name": "secondary_name",
                    "value": "Down jacket for testL / Red0.8kg"
                },
                {
                    "name": "size",
                    "value": "0.8kg"
                },
                {
                    "name": "color",
                    "value": "Red"
                }
            ]
        }
    ]
}';
try {
    $productCreateParams = json_decode($ProductCreateJson, true);
    $productCreateResponse = $sdk->ProductCreate($token, $productCreateParams);
    echo 'ProductCreate Response:' . print_j($productCreateResponse) . "\n";
} catch (Exception $e) {
    echo "Error Product Create: " . $e->getMessage();
    return;
}


// Order Search
$orderSearchParamsJson = '{
  "order_status": "processing",
  "per_count": 1
}';
$orderSearchParams = json_decode($orderSearchParamsJson, true);
try {
    $orderSearchResponse = $sdk->OrderSearch($token, $orderSearchParams);
    echo 'OrderSearch Response:' . print_j($orderSearchResponse) . "\n";
} catch (Exception $e) {
    echo "Error Order Search: " . $e->getMessage();
    return;
}


// Order Synchronize
$orderSynchronizeParamsJson = '{
"items":[{
  "order_number": "FN17255260251854",
  "supplier_order_number": "SUPPLY17255260251854"
}]
}';
$orderSynchronizeParams = json_decode($orderSynchronizeParamsJson, true);
try {
    $orderSynchronizeResponse = $sdk->OrderSynchronize($token, $orderSynchronizeParams);
    echo 'OrderSynchronize Response:' . print_j($orderSynchronizeResponse) . "\n";
} catch (Exception $e) {
    echo "Error Order Synchronize: " . $e->getMessage();
    return;
}

// Order Cancel
$orderCancelParamsJson = '{
    "order_number":"FN17255260251854",
    "oos_items":[
        {
            "sku":"CSFN190016",
            "oos_qty":1
        }
    ]
}';
$orderCancelParams = json_decode($orderCancelParamsJson, true);
try {
    $orderCancelResponse = $sdk->OrderCancel($token, $orderCancelParams);
    echo 'OrderCancel Response:' . print_j($orderCancelResponse) . "\n";
} catch (Exception $e) {
    echo "Error Order Cancel: " . $e->getMessage();
    return;
}


// Shipment Synchronize
$shipmentSynchronizeParamsJson = '{
"items":[{
  "order_number": "FN17255260251854",
  "carrier_code":"CARRY17255260251854",
  "track_number":"TRACK17255260251854"
}]
}';
$shipmentSynchronizeParams = json_decode($shipmentSynchronizeParamsJson, true);
try {
    $shipmentSynchronizeResponse = $sdk->ShipmentSynchronize($token, $shipmentSynchronizeParams);
    echo 'ShipmentSynchronize Response:' . print_j($shipmentSynchronizeResponse) . "\n";
} catch (Exception $e) {
    echo "Error Shipment Synchronize: " . $e->getMessage();
    return;
}


// Shipment Notice
$shipmentNoticeParamsJson = '{
"items":[{
  "order_number": "FN17255260251854"
}]
}';
$shipmentNoticeParams = json_decode($shipmentNoticeParamsJson, true);
try {
    $shipmentNoticeResponse = $sdk->ShipmentNotice($token, $shipmentNoticeParams);
    echo 'ShipmentNotice Response:' . print_j($shipmentNoticeResponse) . "\n";
} catch (Exception $e) {
    echo "Error Shipment Notice: " . $e->getMessage();
    return;
}


function print_j($array)
{
    $json = json_encode($array, JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return ' - No errors' . "\n";
            case JSON_ERROR_DEPTH:
                return ' - Maximum stack depth exceeded' . "\n";
            case JSON_ERROR_STATE_MISMATCH:
                return ' - Underflow or the modes mismatch' . "\n";
            case JSON_ERROR_CTRL_CHAR:
                return ' - Unexpected control character found' . "\n";
            case JSON_ERROR_SYNTAX:
                return ' - Syntax error, malformed JSON' . "\n";
            case JSON_ERROR_UTF8:
                return ' - Malformed UTF-8 characters, possibly incorrectly encoded' . "\n";
            default:
                return ' - Unknown error' . "\n";
        }
    } else {
        return $json . "\n";
    }
}