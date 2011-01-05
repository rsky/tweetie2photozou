<?php
/**
 * OAuth Echoクラス
 *
 * @package tweetie2photozou
 * @link http://dev.twitter.com/pages/oauth_echo
 */
class T2P_OAuth_Echo
{
    /**
     * OAuthサービスプロバイダのURI
     *
     * @var string
     */
    private $serviceProvider;

    /**
     * コンストラクタ
     *
     * @param $serviceProvider OAuthサービスプロバイダのURI
     * @throws InvalidArgumentException
     */
    public function __construct($serviceProvider)
    {
        if (!is_string($serviceProvider) ||
            !preg_match('/^https?:\\/\\//', $serviceProvider)) {
            throw new InvalidArgumentException('invalid service provider');
        }
        $this->serviceProvider = $serviceProvider;
    }

    /**
     * 認証する
     *
     * @param string $authorizationData OAuth認証データ
     * @return void
     * @throws InvalidArgumentException, T2P_Exception
     */
    public function verify($authorizationData)
    {
        if (!is_string($authorizationData) ||
            strpos($authorizationData, 'OAuth ') !== 0) {
            throw new InvalidArgumentException('invalid authorization data');
        }

        // リクエスト
        $ctx = stream_context_create(array('http' => array(
            'header' => "Authorization: {$authorizationData}\r\n",
            'user_agent' => __CLASS__,
        )));
        $json = file_get_contents($this->serviceProvider, false, $ctx);
        t2p_get_logger()->dumpOAuthResponse($http_response_header, $json);

        // HTTPヘッダを解析
        $headers = array();
        $code = 0;
        foreach ($http_response_header as $header) {
            if (preg_match('/^HTTP\\/1\\.[01] (\\d+)/', $header, $matches)) {
                $code = intval($matches[1]);
            } elseif (strpos($header, ':') !== false) {
                list($key, $value) = explode(':', $header, 2);
                $headers[strtoupper(trim($key))] = trim($value);
            }
        }

        // 200 OK以外なら例外をスロー
        if ($code !== 200) {
            $e = new T2P_Exception('verification failed');
            if ($code > 200) {
                $e->setHttpResponseCode($code);
            }
            throw $e;
        }

        return array(
            'headers' => $headers,
            'data' => json_decode($json, true),
        );
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
