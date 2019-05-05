<?php

namespace LevinPwnz\FnsCheck\Services;

use Exception;
use FnsCheck\FnsCheckHelper;
use RobbieP\ZbarQrdecoder\ZbarDecoder;
use Zxing\QrReader;

/**
 * Class QrService
 *
 * @package LevinPwnz\FnsCheck\services
 */
class QrService
{
    const CHECK_NOT_RECOGNIZED = false;
    /**
     * @var string
     */
    private $recognized;

    /**
     * @param $checkFile
     * @return bool|array
     * @throws Exception
     */
    public function getCheck($checkFile)
    {
        $this->readCodeFromFile($checkFile);

        if ($this->recognized == null) {
            return self::CHECK_NOT_RECOGNIZED;
        }

        return $this->makeCheckData();
    }

    /**
     * Read QR code from check image file
     *
     * @param $file
     * @return bool
     * @throws Exception
     */
    protected function readCodeFromFile($file)
    {
        if (is_null($file)) {
            throw new Exception('File must be a file');
        }

        $recognized = (new QrReader($file))->text();

        if (!$recognized) {
            $recognized = (new ZbarDecoder())->make($file);
        }

        if (isset($recognized->code) && $recognized->code == 200) {
            $this->recognized = $recognized->text;
        }

        $this->recognized = $recognized;

        return self::CHECK_NOT_RECOGNIZED;
    }

    /**
     * @throws Exception
     */
    protected function makeCheckData()
    {
        if (is_null($this->recognized)) {
            return null;
        }

        return FnsCheckHelper::fromQRCode($this->recognized);
    }

    /**
     * @return mixed
     */
    public function getRecognized()
    {
        return $this->recognized;
    }

    /**
     * @param  mixed  $recognized
     */
    public function setRecognized($recognized)
    {
        $this->recognized = $recognized;
    }
}
