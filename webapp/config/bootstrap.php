<?php
/**
 * 初期化スクリプト
 *
 * @package tweetie2photozou
 */

// 構成を読み込む
require __DIR__ . '/config.php';
if (T2P_MULTI_ACCOUNT) {
	require __DIR__ . '/config-multi.php';
} else {
	require __DIR__ . '/config-single.php';
}

// 関数を読み込む
require T2P_APP_ROOT　. '/lib/functions.php';

// インクルードパスとオートローダを設定
set_include_path(T2P_APP_ROOT　. '/lib' .
                 PATH_SEPARATOR .
                 T2P_APP_ROOT　. '/lib/vendor');
spl_autoload_extensions('.php');
spl_autoload_register();

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
