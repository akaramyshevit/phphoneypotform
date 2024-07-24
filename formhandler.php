<?php

$formData = $_POST;
$userData = [
    'userName' => $formData['user_name'],
    'userEmail' => $formData['user_email'],
    'userMessage' => $formData['user_message']
];

function checkFormData($userData) {
    foreach ($userData as $userInputValue) {
        if  ($userInputValue === "") {
            return false;
        }
    }
    return true;
}


function logUserData($logFile) {
    $logMessageValues = [
        'UserCountry' => $_SERVER['GEOIP_COUNTRY_NAME'],
        'UserCity' => $_SERVER['GEOIP_CITY'],
        'UserIp4' => $_SERVER['REMOTE_ADDR'],
        'UserAgent' => $_SERVER['HTTP_USER_AGENT']
    ];
    $logMessageContents = "User Country: {$logMessageValues['UserCountry']}. UserCity: {$logMessageValues['UserCity']}. User IPv4 Address: {$logMessageValues['UserIp4']}. User Agent: {$logMessageValues['UserAgent']}.". PHP_EOL;
    file_put_contents($logFile, $logMessageContents, FILE_APPEND | LOCK_EX);
}

$checkFormDataResult = checkFormData($userData);
$currentDate = date('Y_m_d');
$logFile = "{$currentDate}_user_form_request_log.txt";

if ($checkFormDataResult) {
    echo '<pre>';
    echo '<b>Success Sending Data.</b>';
    logUserData($logFile);
    echo '</pre>';
} else {
    echo '<pre>';
    echo '<b>Empty or Partial Form Data Recevied from User: </b>';
    var_dump($formData);
    echo '</pre>';
}
