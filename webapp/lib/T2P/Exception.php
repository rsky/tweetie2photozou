<?php
/**
 * 例外クラス
 *
 * @package tweetie2photozou
 */
class T2P_Exception extends Exception
{
    /**
     * エラー時に返すHTTPレスポンスコード
     *
     * @var int
     */
    private $httpResponseCode = 500;

    /**
     * HTTPレスポンスコードを取得する
     *
     * @param void
     * @return int
     */
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    /**
     * HTTPレスポンスコードを設定する
     *
     * @param int $code
     * @return void
     */
    public function setHttpResponseCode($code)
    {
        $this->httpResponseCode = $code;
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
