<?php

// TODO: post json without curl.
function http_post_json($url, $jsons)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsons);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsons),
            'api-key: kgyKoDtZXfopL3=RX4T4WkoCdMA='
        )
    );
    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array($code, $response);
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method)
{

    case "GET":
    {
        $token = '1331103982';

        $msg = $_GET["msg"];
        $nonce = $_GET["nonce"];
        $signature = $_GET["signature"];

        $encryption = urlencode(base64_encode(md5($token.$nonce.$msg)));
/*
        if ($encryption == $signature) {
            echo $msg;
        }
        else {
            echo "invalid";
        }
*/
        echo $msg;
        break;
    }

    case "POST":
    {
        $body = file_get_contents("php://input"); // body contains json.
/*
// json details.
{
"msg": 
    [
        {
            "type": 1,
            "dev_id": 8910787,
            "ds_id": "datastream_id",
            "at": 1466133706841,
            "value": 42
        },
        {
            "type": 1,
            "dev_id": 8910787,
            "ds_id": "datastream_id",
            "at": 1466133706842,
            "value": 43
        }, ... // remove comma & ellipsis when testing.
    ],
    "msg_signature": "message_signature",
    "nonce": "random_serial_number"
}
*/
        $json = json_decode($body);
        $v = 0;
        $a = 0;
        foreach ($json->msg as $msg)
        {
            switch($msg->ds_id)
            {
                case "volt":
                {
                    $v = $msg->value;
                    break;
                }
                case "ampere":
                {
                    $a = $msg->value;
                    break;
                }
                default:break;
            }
        }
        $watt = $v * $a;
        $work = "{'datastreams':[{'id':'work','datapoints':[{'at':'','value':$watt}]}]}";

        $url = "http://api.heclouds.com/devices/8910787/datapoints";
        list($code, $content) = http_post_json($url, $work);
        echo $code." ".$content;

        break;
    }

    default:break;
}
