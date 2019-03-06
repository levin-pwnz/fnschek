<?php

namespace LevinPwnz\FnsCheck\Services;

use FnsCheck\FnsCheckApi;
use FnsCheck\FnsCheckAuth;
use Illuminate\Support\Collection;

/**
 * Class FnsService
 * @package LevinPwnz\FnsCheck\services
 */
class FnsService
{
    /**
     * @var FnsCheckApi
     */
    private $checkApi;

    /**
     * FnsService constructor.
     * @param FnsCheckApi $checkApi
     */
    public function __construct(FnsCheckApi $checkApi)
    {
        $this->checkApi = $checkApi;
    }

    /**
     * @return FnsCheckAuth
     */
    protected function auth(): FnsCheckAuth
    {
        $auth = new FnsCheckAuth(config('fnsconfig.phone'), config('fnsconfig.password'));

        return $auth;
    }

    /**
     * @param $checkData
     * @return string
     */
    protected function getResponseFromFns($checkData)
    {
        $response = $this->checkApi->checkDetail($checkData, $this->auth())
            ->getContents();

        return $response;
    }

    /**
     * If QrService doesn't recognize QRCode on image, we return false.
     * If Qr Service can recognize text we return collection with check items
     * @param $checkData
     * @return bool|mixed
     */
    public function getCheckItems($checkData)
    {
        //If check not recognized
        if (!is_array($checkData)) {
            return false;
        }

        $items = json_decode($this->getResponseFromFns($checkData));

        $items = $items->document->receipt->items;

        return collect($items);

    }

}
