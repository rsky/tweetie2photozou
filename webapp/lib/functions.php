<?php
/**
 * ユーティリティ関数ファイル
 *
 * @package tweetie2photozou
 */

/**
 * プロキシクラスを取得する
 *
 * @param string $username Twitterのユーザー名
 * @param string $password Twitterのパスワード
 * @return T2P_Proxy
 */
function t2p_get_proxy($username, $password)
{
    if (T2P_MULTI_ACCOUNT) {
        return new T2P_Proxy_Multi($username, $password);
    } else {
        return new T2P_Proxy_Single($username, $password);
    }
}

/**
 * ロギングクラスを取得する
 *
 * @param void
 * @return T2P_Logger
 */
function t2p_get_logger()
{
    static $logger = null;
    if ($logger === null) {
        if (T2P_DEBUG) {
            $logger = new T2P_Logger_Debug();
        } else {
            $logger = new T2P_Logger_Void();
        }
    }
    return $logger;
}

/**
 * Twitterのユーザー名・パスワードをハッシュする
 *
 * @param string $username Twitterのユーザー名
 * @param string $password Twitterのパスワード
 * @return string ハッシュ値
 */
function t2p_hash($username, $password)
{
    return sha1(T2P_SALT . "\0{$username}\0{$password}");
}

/**
 * 画像データをファイルに保存する
 *
 * @param string $data 写真・動画等のバイナリデータ
 * @return string　保存したパス
 */
function t2p_save_media($data)
{
    list($usec, $sec) = explode(' ', microtime());
    $filename = date('Ymd', intval($sec)) . substr($usec, 1);
    $path = T2P_UPLOAD_DIR . DIRECTORY_SEPARATOR . $filename;
    $success = false;

    if (strlen($data) === file_put_contents($path, $data)) {
        $info = getimagesize($path);
        if ($info !== false) {
            $ext = image_type_to_extension($info[2]);
            if ($ext !== false) {
                if (rename($path, $path . $ext)) {
                    $path .= $ext;
                    $success = true;
                }
            }
        }
    }

    if ($success) {
        if (!T2P_DEBUG) {
            register_shutdown_function('unlink', $path);
        }
        return $path;
    } else {
        if (!T2P_DEBUG && file_exists($path)) {
            unlink($path);
        }
        return false;
    }
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
