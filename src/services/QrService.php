<?php

namespace LevinPwnz\FnsCheck\Services;

use phpDocumentor\Reflection\Types\Self_;
use Zxing\QrReader;

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
     * @return void|bool
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

        if (!is_string($recognizedText)) {
            return self::CHECK_NOT_RECOGNIZED;
        }

        $tmp = explode('&', $recognizedText);

        $checkData = [
            'fiscalNumber' => '', // "ФН" в чеке
            'fiscalSign' => '', // "ФП" в чеке
            'fiscalDocument' => '', // "ФД" в чеке
        ];

        foreach ($tmp as $item) {

            $tmpIntem = explode('=', $item);

            if ($tmpIntem[0] == 'fn') $checkData['fiscalNumber'] = $tmpIntem[1];
            if ($tmpIntem[0] == 'fp') $checkData['fiscalSign'] = $tmpIntem[1];
            if ($tmpIntem[0] == 'i') $checkData['fiscalDocument'] = $tmpIntem[1];

        }

        return $checkData;
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
