<?php
// Работа с БД для получения заголовка и URL
require '../wp-config.php';

$validation = [];
date_default_timezone_set('Europe/Moscow');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); // подключение к БД
mysqli_set_charset($connection, 'utf8');
if ($connection) {
    $fieldToken = "SELECT * FROM wp_options WHERE option_name='options_header-send-vacancy'"; // токен
    $token = getData($connection, $fieldToken);
    $fieldUrl = "SELECT * FROM wp_options WHERE option_name='options_url-send-vacancy'"; // URL
    $url = getData($connection, $fieldUrl);
}

// Функция для конвертирования многомерного массива
function build_post_fields($data, &$returnArray, $existingKeys = '') {
    if (($data instanceof CURLFile) or !(is_array($data) or is_object($data))) {
        $returnArray[$existingKeys] = $data;
        return $returnArray;
    } else {
        foreach ($data as $key => $item) {
            build_post_fields($item, $returnArray, ($existingKeys) ? $existingKeys . "[$key]" : $key);
        }
        return $returnArray;
    }
}

if ($token && $url && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'])) {
    header('Content-Type: application/json; charset=utf-8');
    $post = [];
    if ($_POST['site'])
        $post['site'] = $_POST['site'];
    if ($_POST['name'])
        $post['name'] = $_POST['name'];
    if ($_POST['email'])
        $post['email'] = $_POST['email'];
    if ($_POST['phone'])
        $post['phone'] = $_POST['phone'];
    if ($_POST['message'])
        $post['message'] = $_POST['message'];

    // Добавление $_FILES в $post
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $row) {
            $diff = count($row) - count($row, COUNT_RECURSIVE);
            if ($diff == 0) {
                if (!empty($row['name']) && empty($row['error'])) {
                    $curl_file = new CURLFile($row['tmp_name'], $row['type'], $row['name']);
                    $post[$key] = $curl_file;
                }
            } else {
                $files = array();
                foreach ($row as $k => $l) {
                    foreach ($l as $i => $v) {
                        $files[$i][$k] = $v;
                    }
                }
                foreach ($files as $file) {
                    if (!empty($file['name']) && empty($file['error'])) {
                        $curl_file = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
                        $post[$key][] = $curl_file;
                    }
                }
            }
        }
    }

    $fields = array();
    build_post_fields($post, $fields);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);

    $headers = array(
        'X-Auth-Token: ' . $token . ''
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

    $info = curl_getinfo($curl);
    $result = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Выводим результат:
    // echo $result;

    http_response_code($http_code);
    if ($http_code === 200) {
        $validation['valid'] = 'yes-valid';
//        echo `<script>ym(94778377, "reachGoal", "sentform"); return true;</script>`;
    }
} else {
    $validation['valid'] = 'not-valid';
    echo json_encode($validation);
    header("HTTP/1.0 403 Forbidden");
}

echo json_encode($validation);
die();
?>
