<?php
/**
 * ログを取るクラス
 *
 * @package tweetie2photozou
 */
abstract class T2P_Logger
{
    /**
     * ファイルにデータを書き込む
     *
     * @param string $filename ディレクトリ名を含まないファイル名
     * @param string $data 記録するデータ
     * @param int $flags 書き込みフラグ
     * @return int 書き込んだバイト数
     */
    private function putLog($filename, $data, $flags = 0)
    {
        $path = T2P_LOG_DIR . DIRECTORY_SEPARATOR . $filename;
        return file_put_contents($path, $data, $flags | LOCK_EX);
    }

    /**
     * 配列データをログに記録する
     *
     * @param string $filename ディレクトリ名を含まないファイル名
     * @param array $data 記録するデータ
     * @return int 書き込んだバイト数
     */
    protected function saveArray($filename, array $data)
    {
        $data = json_encode($data) . "\n";
        return $this->putLog($filename, $data, FILE_APPEND);
    }

    /**
     * バイナリデータをログに記録する
     *
     * @param string $filename ディレクトリ名を含まないファイル名
     * @param array $data 記録するデータ
     * @return int 書き込んだバイト数
     */
    protected function saveBinary($filename, $data)
    {
        return $this->putLog($filename, $data);
    }

    /**
     * 正常なリクエストを記録する。
     *
     * @param void
     * @return void
     */
    abstract public function dumpValidRequest();

    /**
     * 不正なリクエストを記録する。
     *
     * @param void
     * @return void
     */
    abstract public function dumpInvalidRequest();
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
