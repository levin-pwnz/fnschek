<?php

namespace LevinPwnz\FnsCheck\Services;

use Zxing\QrReader;
use FnsCheck\FnsCheckHelper;

/**
 * Class QrService
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
     * @return mixed
     */
    public function getRecognized()
    {
        return $this->recognized;
    }

    /**
     * @param mixed $recognized
     */
    public function setRecognized($recognized): void
    {
        $this->recognized = $recognized;
    }

    /**
     * Read QR code from check image file
     * @param $file
     * @return bool|string
     * @throws \Exception
     */
    protected function readCodeFromFile($file)
    {
        if (is_null($file)) {
            throw new \Exception('File must be a file');
        }

        $recognized = (new QrReader($file))->text();

        if ($recognized == false) return self::CHECK_NOT_RECOGNIZED;


        $this->setRecognized($recognized);
    }

    /**
     * @throws \Exception
     */
    protected function makeCheckData()
    {
        $recognizedText = $this->getRecognized();


        if (! $recognizedText) {
            return self::CHECK_NOT_RECOGNIZED;
        }
        return FnsCheckHelper::fromQRCode($recognizedText);
    }


    /**
     * @param $checkFile
     * @return array
     * @throws \Exception
     */
    public function getCheck($checkFile)
    {
        $this->readCodeFromFile($checkFile);

        return $this->makeCheckData($this->getRecognized());
    }
}
