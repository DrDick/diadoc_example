<?php
//title: получаем организацию по ИНН

$login = ""; //имя учетной записи пользователя
$password = ""; //пароль учетной записи пользователя
$key = ""; //ключ, полученный доверенным сервисом
$id = ""; //идентификатор пользователя доверенного сервиса


$data = array(
'login' => $login,
'password' => $password,
'key' => $key,
'id' => $id
);


$url = 'https://diadoc-api.kontur.ru/Authenticate?login=vostrotin00@gmail.com&password=eBF_ze^fRAyD1';
$headers = array(
'Authorization: DiadocAuth ddauth_api_client_id=API-0b37ebe9-a9d6-498a-8895-979516597791', //вставить свой id
'Content-Type: application/json'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

var_dump($response);


$headers = array(
'Authorization: DiadocAuth ddauth_api_client_id='.$response.'', //вставить свой id
'Content-Type: application/json'
);

$inn = 9664128340;
$get_counterparty_url = "https://diadoc-api.kontur.ru/GetOrganization?inn=$inn";

curl_setopt($ch, CURLOPT_URL, $get_counterparty_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
$counterparty_data = json_decode($response);
curl_close($ch);

var_dump($response); // ответ сервера
