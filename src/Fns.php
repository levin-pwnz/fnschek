<?php

namespace LevinPwnz\FnsCheck;

use FnsCheck\FnsCheckHelper;
use Illuminate\Support\Collection;
use LevinPwnz\FnsCheck\Services\FnsService;
use LevinPwnz\FnsCheck\Services\QrService;

/**
 * Class Fns
 *
 * @package LevinPwnz\FnsCheck
 */
class Fns
{

    /**
     * @var QrService
     */
    private $qrService;
    /**
     * @var FnsService
     */
    private $fnsService;

    /**
     * Fns constructor.
     *
     * @param  QrService  $qrService
     * @param  FnsService  $fnsService
     */
    public function __construct(QrService $qrService, FnsService $fnsService)
    {
        $this->qrService = $qrService;
        $this->fnsService = $fnsService;
    }


    /**
     * Get info about a check,
     *
     * @param $checkFile
     * @return Collection|bool
     * @throws \Exception
     */
    public function getInfoByCheck($checkFile)
    {
        if ($this->qrService->getCheck($checkFile)) {
            return collect($this->qrService->getCheck($checkFile));
        }

        return false;
    }


    /**
     * Return Collection if check recognized, if check not recognized return false
     *
     * @param $checkFile
     * @return Collection|bool
     * @throws \Exception
     */
    public function getAllCheckItems($checkFile)
    {
        return $this->fnsService->getCheckItems($this->qrService->getCheck($checkFile));
    }

    public function getCheckByQr($qr)
    {
        $data = FnsCheckHelper::fromQRCode($qr);
        return $this->fnsService->getCheckItems($data);
    }
}
