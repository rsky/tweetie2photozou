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
            'params' => array(
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'source' => $_POST['source'],
            ),
        );
        $this->saveArray('debug.request.valid.log', $data);

        $date = date('Ymd.His');
        $usec = substr(microtime(), 2, 6);
        $filename = "media.{$date}.{$usec}";
        $data = $_POST['media'];
        if (strlen($data) === $this->saveBinary($filename, $data)) {
            $info = getimagesize($filename);
            if ($info !== false) {
                $extension = image_type_to_extension($info[2]);
                if ($extension !== false) {
                    rename($filename, $filename . $extension);
                }
            }
        }
    }

    /**
     * 不正なリクエストを記録する。
     *
      * @param void
      * @return void
     */
    public function dumpInvalidRequest()
    {
        $data = array(
            'date' => date(DATE_W3C),
            'addr' => $_SERVER['REMOTE_ADDR'],
            'method' => $_SERVER['HTTP_REQUEST_METHOD'],
            'params' => array_keys($_REQUEST),
        );
        $this->saveArray('debug.request.invalid.log', $data);
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
