<?php
$apiKey = '84881b0c009c41999d2182a86b391186';

$city = $_GET['city'] ?? '';

if ($city) {
    $url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric&lang=ru";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Ошибка cURL: ' . curl_error($ch);
    } else {
        $data = json_decode($response, true);

        if ($data['cod'] !== 200) {
            echo 'Ошибка: ' . $data['message'];
        } else {
            $temperature = $data['main']['temp'];
            $description = $data['weather'][0]['description'];
            $icon = $data['weather'][0]['icon'];
            $iconUrl = "http://openweathermap.org/img/wn/{$icon}.png";

            echo "<h2>Погода в городе {$city}</h2>";
            echo "<p>Температура: {$temperature}°C</p>";
            echo "<p>Описание: {$description}</p>";
            echo "<img src='{$iconUrl}' alt='Иконка погоды'>";
        }
    }
    curl_close($ch);
} else {
    echo 'Пожалуйста, введите название города.';
}
?>