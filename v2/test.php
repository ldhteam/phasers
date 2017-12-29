<?php
function postCurl($url, $data = '') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    //curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'
        )
    );
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        return curl_errno($curl);
    }
    var_dump($data);
    var_dump($result);
    //$result = explode("\r\n", $result);
    //$result = array_pop($result);
    curl_close($curl);

    return $result;
}

postCurl('https://ct.ctrip.com/corpservice/authorize/getticket','{"AppKey":"obk_nntest","AppSecurity":"obk_nntest"}');