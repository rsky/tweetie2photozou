<?php
/**
 * シングルユーザー用プロキシクラス
 *
 * @package tweetie2photozou
 */
class T2P_Proxy_Single extends T2P_Proxy
{
    /**
     * Twitterのユーザー情報からフォト蔵の設定を取得する
     *
     * @param array $userInfo Twitterのユーザー情報
     * @return array {'username': 'フォト蔵のユーザー名',
     *                'password': 'フォト蔵のパスワード',
     *                'album_id': 'アップロードするアルバムのID'}
     */
    protected function getConfiguration($userInfo)
    {
        if (T2P_SINGLE_TWITTER_ID == $userInfo['id']) {
            return array(
                'username' => T2P_SINGLE_USERNAME,
                'password' => T2P_SINGLE_PASSWORD,
                'album_id' => T2P_SINGLE_ALBUM_ID,
            );
        } else {
            return null;
        }
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
