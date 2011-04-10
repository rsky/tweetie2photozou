<?php
/**
 * ユーティリティ関数ファイル
 *
 * @package tweetie2photozou
 */

/**
 * プロキシクラスを取得する
 *
 * @param string $userInfo Twitterのユーザー情報
 * @return T2P_Proxy
 */
function t2p_get_proxy($userInfo)
{
    if (T2P_MULTI_ACCOUNT) {
        return new T2P_Proxy_Multi($userInfo);
    } else {
        return new T2P_Proxy_Single($userInfo);
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
 * アップロードされた画像をリネームする
 *
 * @param string $tmp_name アップロードされたファイル
 * @return string 保存したパス
 */
function t2p_rename_media($tmp_name)
{
    if (!file_exists($tmp_name) || !is_uploaded_file($tmp_name)) {
        return false;
    }
    list($usec, $sec) = explode(' ', microtime());
    $filename = date('Ymd', intval($sec)) . substr($usec, 1);
    $path = T2P_UPLOAD_DIR . DIRECTORY_SEPARATOR . $filename;
    $success = false;

    if (move_uploaded_file($tmp_name, $path)) {
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
