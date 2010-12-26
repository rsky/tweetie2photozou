<?php
/**
 * ログを取るように見せかけて何もしないクラス
 *
 * @package tweetie2photozou
 */
class T2P_Logger_Void extends T2P_Logger
{
    /**
     * 正常なリクエストを記録する。
     *
     * @param void
     * @return void
     */
    public function dumpValidRequest()
    {
        // nothing to do
    }

    /**
     * 不正なリクエストを記録する。
     *
     * @param void
     * @return void
     */
    public function dumpInvalidRequest()
    {
        // nothing to do
    }

    /**
     * OAuth Echo認証の結果を記録する。
     *
     * @param array $headers HTTPレスポンスヘッダ
     * @param string $body HTTPレスポンスボディ
     * @return void
     */
    public function dumpOAuthResponse($headers, $body)
    {
        // nothing to do
    }

    /**
     * フォト蔵APIからのレスポンスを記録する。
     *
     * @param array $headers HTTPレスポンスヘッダ
     * @param string $body HTTPレスポンスボディ
     * @return void
     */
    public function dumpPhotozouResponse($headers, $body)
    {
        // nothing to do
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
