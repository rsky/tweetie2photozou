<?php
/**
 * API用エントリーポイント
 *
 * @package tweetie2photozou
 */

require __DIR__ . '/../webapp/config/bootstrap.php';

$valid = true;
if ($_SERVER['HTTP_REQUEST_METHOD'] !== 'POST') {
    $valid = false;
} else {
    foreach (array('username', 'password', 'source', 'media') as $key) {
        if (!array_key_exists($key, $_POST)) {
            $valid = false;
            break;
        }
    }
}

if (!$valid) {
    header('Content-Type: text/plain', true, 400);
    return;
}

try {
    $proxy = new t2p_get_proxy($_POST['username'], $_POST['password']);
    $uri = $proxy->upload($_POST['media']);
    header('Content-Type: application/xml');
    echo '<mediaurl>', htmlspecialchars($uri, ENT_QUATES), '</mediaurl>';
} catch (T2P_Exception $e) {
    header('Content-Type: text/plain', true, $e->getHttpResponseCode());
    echo $e->getMessage();
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
