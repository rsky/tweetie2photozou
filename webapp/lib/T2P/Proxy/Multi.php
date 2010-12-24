<?php
/**
 * マルチユーザー用プロキシクラス
 *
 * @package tweetie2photozou
 */
class T2P_Proxy_Multi extends T2P_Proxy
{
    /**
     * Twitterのユーザー名・パスワードからフォト蔵の設定を取得する
     *
     * @param string $username Twitterのユーザー名
     * @param string $password Twitterのパスワード
     * @return array {'username': 'フォト蔵のユーザー名',
     *                'password': 'フォト蔵のパスワード',
     *                'album_id': 'アップロードするアルバムのID'}
     */
    protected function getConfigration($username, $password)
    {
        return null;
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