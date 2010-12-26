<?php
/**
 * デバッグ用のログを取るクラス
 *
 * @package tweetie2photozou
 */
class T2P_Logger_Debug extends T2P_Logger
{
    /**
     * 正常なリクエストを記録する。
     *
     * @param void
     * @return void
     */
    public function dumpValidRequest()
    {
        $data = array(
            'date' => date(DATE_W3C),
            'addr' => $_SERVER['REMOTE_ADDR'],
            'message' => $_POST['message'],
            'media' => $_FILES['media'],
        );
        $this->saveArray('debug.request.valid.log', $data);
    }

    /**
     * 不正なリクエストを記録する。
     *
      * @param void
      * @return void
     */
    public function dumpInvalidRequest()
    {
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[substr($key, 5)] = $value;
            }
        }
        $data = array(
            'date' => date(DATE_W3C),
            'addr' => $_SERVER['REMOTE_ADDR'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'headers' => $headers,
            'get' => array_keys($_GET),
            'post' => array_keys($_POST),
            'files' => array_keys($_FILES),
        );
        $this->saveArray('debug.request.invalid.log', $data);
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
        $data = array(
            'date' => date(DATE_W3C),
            'addr' => $_SERVER['REMOTE_ADDR'],
            'headers' => $headers,
            'body' => $body,
        );
        $this->saveArray('debug.response.oauth.log', $data);
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
        $data = array(
            'date' => date(DATE_W3C),
            'addr' => $_SERVER['REMOTE_ADDR'],
            'headers' => $headers,
            'body' => $body,
        );
        $this->saveArray('debug.response.photozou.log', $data);
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
