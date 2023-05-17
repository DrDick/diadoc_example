<?php

//title: получаем статусы

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


$url = 'https://diadoc-api.kontur.ru/Authenticate?login=&password=';
$headers = array(
'Authorization: ', //вставить свой id
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
'Authorization: DiadocAuth ddauth_api_client_id=' . $response . '', //вставить свой id
'Content-Type: application/json charset=utf-8',
'Accept: application/json'
);

$NonformalizedDocumentPath = "/home/bitrix/www/поля переименованные.txt"; // путь к файлу, который нужно отправить
$content = file_get_contents($NonformalizedDocumentPath,); // бинарное содержимое файла
$content = unpack('H*', bin2hex($content));
//$way = "/home/bitrix/www/binary.bin";
//file_put_contents($way,$content);

var_dump($content);


// Заполнение информации о документе в структуре DocumentAttachment
$documentAttachment = array(
"TypeNamedId" => "nonformalized",
"SignedContent" => array(
"Content" => $content[1],
"SignWithTestSignature" => true
),
"Comment" => "Текстовый комментарий к документу",
"CustomDocumentId" => "Строковый идентификатор учетной системы",
"Metadata" => array(
array(
"Key" => "FileName",
"Value" => pathinfo($NonformalizedDocumentPath, PATHINFO_FILENAME)
)
)
);

$documentAttachment = mb_convert_encoding($documentAttachment, 'UTF-8', 'UTF-8');

// Заполнение информации о документе в MessageToPost
$messageToPost = array(
"FromBoxId" => '',
"ToBoxId" => '',
"DocumentAttachments" => array($documentAttachment),
//"StructuredDataAttachments" => array($documentAttachment)
);

$inn = 6671273007;
$get_counterparty_url = "https://diadoc-api.kontur.ru/V3/GetDocument?boxId=";


$data_json = json_encode($messageToPost, JSON_THROW_ON_ERROR);

curl_setopt($ch, CURLOPT_URL, $get_counterparty_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTPGET, true);
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
$counterparty_data = json_decode($response);
curl_close($ch);

var_dump($counterparty_data); // ответ сервера
//var_dump($headers);
//var_dump($info);
