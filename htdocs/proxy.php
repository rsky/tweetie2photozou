<?php
/**
 * API用エントリーポイント
 *
 * @package tweetie2photozou
 */

require __DIR__ . '/../webapp/config/bootstrap.php';

$logger = t2p_get_logger();

$valid = true;
$media = null;
if ($_SERVER['HTTP_REQUEST_METHOD'] !== 'POST') {
    $valid = false;
} else {
    foreach (array('username', 'password', 'source', 'media') as $key) {
        if (!array_key_exists($key, $_POST)) {
            $valid = false;
            break;
        }
    }
    if ($valid) {
        $media = t2p_save_media($_POST['media']);
        if ($media === false) {
            $valid = false;
        }
    }
}

if (!$valid) {
    $logger->dumpInvalidRequest();
    header('Content-Type: text/plain', true, 400);
    return;
}

$logger->dumpValidRequest();

try {
    $proxy = t2p_get_proxy($_POST['username'], $_POST['password']);
    $uri = $proxy->upload($media, $_POST['source']);
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
