<?php
/**
 * ユーティリティ関数ファイル
 *
 * @package tweetie2photozou
 */

/**
 * プロキシクラスを取得する
 *
 * @param void
 * @return T2P_Proxy
 */
function t2p_get_proxy()
{
    if (T2P_MULTI_ACCOUNT) {
        return new T2P_Proxy_Multi();
    } else {
        return new T2P_Proxy_Single();
    }
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
