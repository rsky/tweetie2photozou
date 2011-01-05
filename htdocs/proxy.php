<?php
/**
 * API用エントリーポイント
 *
 * @package tweetie2photozou
 */

require dirname(__FILE__) . '/../webapp/config/bootstrap.php';

$logger = t2p_get_logger();

// リクエストを検証
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    array_key_exists('HTTP_X_AUTH_SERVICE_PROVIDER', $_SERVER) &&
    array_key_exists('HTTP_X_VERIFY_CREDENTIALS_AUTHORIZATION', $_SERVER) &&
    array_key_exists('message', $_POST) &&
    is_string($_POST['message']) &&
    array_key_exists('media', $_FILES) &&
    is_array($_FILES['media']) &&
    is_string($_FILES['media']['name']) &&
    is_string($_FILES['media']['type']) &&
    is_string($_FILES['media']['tmp_name']) &&
    is_int($_FILES['media']['error']) &&
    is_int($_FILES['media']['size'])) {
    $logger->dumpValidRequest();
} else {
    $logger->dumpInvalidRequest();
    header('Content-Type: text/plain', true, 400);
    echo "invalid request\n";
    return;
}

// 画像をリネーム
$media = t2p_rename_media($_FILES['media']['tmp_name']);
if ($media === false) {
    header('Content-Type: text/plain', true, 500);
    echo "cannot rename the media\n";
    return;
}

// 認証&ポスト
try {
    $oauth = new T2P_OAuth_Echo($_SERVER['HTTP_X_AUTH_SERVICE_PROVIDER']);
    $result = $oauth->verify($_SERVER['HTTP_X_VERIFY_CREDENTIALS_AUTHORIZATION']);
    $proxy = t2p_get_proxy($result['data']);
    $uri = $proxy->upload($media, $_POST['message']);
    header('Content-Type: application/xml');
    echo '<mediaurl>',
         htmlspecialchars($uri, ENT_QUOTES),
         '</mediaurl>', "\n";
} catch (T2P_Exception $e) {
    header('Content-Type: text/plain', true, $e->getHttpResponseCode());
    echo $e->getMessage(), "\n";
}

/*
 * Local Variables:
 * mode: php
 * coding: utf-8
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=utf-8 ai et ts=4 sw=4 sts=4 fdm=marker:
