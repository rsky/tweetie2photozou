<?php
/**
 * 送信された画像をフォト蔵にアップロードするプロキシクラス
 *
 * @package tweetie2photozou
 */
abstract class T2P_Proxy
{
    /**
     * Services_Photozouのインスタンス
     *
     * @var Services_Photozou
     */
    protected $photozou;

    /**
     * 写真をアップロードするアルバムのID
     *
     * @var int
     */
    protected $albumId;

    /**
     * コンストラクタ
     *
     * @param string $username Twitterのユーザー名
     * @param string $password Twitterのパスワード
     * @throws T2P_Exception
     */
    public function __construct($username, $password)
    {
        $config = $this->getConfigration($username, $password);
        if (!$config) {
            $e = T2P_Exception('authentication failed');
            $e->setHttpResponseCode(403);
            throw $e;
        }
        $this->photozou = new Services_Photozou($config['username'],
                                                $config['password']);
        $this->albumId = $config['album_id'];
    }

    /**
     * Twitterのユーザー名・パスワードからフォト蔵の設定を取得する
     *
     * @param string $username Twitterのユーザー名
     * @param string $password Twitterのパスワード
     * @return array {'username': 'フォト蔵のユーザー名',
     *                'password': 'フォト蔵のパスワード',
     *                'album_id': 'アップロードするアルバム'}
     */
    abstract protected function getConfigration($username, $password);

    /**
     * 写真をアップロードする
     *
     * @param string $media 写真・動画等のバイナリデータ
     * @return string アップロードした写真を閲覧できるURI
     * @throws T2P_Exception
     */
    public function upload($media)
    {
        $params = array(
            'photo' => $media,
            'album_id' => $this->albumId,
        );
        if (T2P_USE_EXIF) {
            $params['date_type'] = 'exif';
        } else {
            $params['date_type'] = 'date';
            $date = explode('-', date('Y-m-d'));
            $params['year']  = $date[0];
            $params['month'] = $date[1];
            $params['day']   = $date[2];
        }

        $result = $this->photozou->photo_add($params);
        if (PEAR::isError($result)) {
            throw new T2P_Exception($result->getMessage());
        }
        return $result['url'];
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
