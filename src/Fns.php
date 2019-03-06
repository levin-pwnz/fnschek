<?php

namespace LevinPwnz\FnsCheck;

use Illuminate\Support\Collection;
use LevinPwnz\FnsCheck\Services\FnsService;
use LevinPwnz\FnsCheck\Services\QrService;

/**
 * Class Fns
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
     * @param QrService $qrService
     * @param FnsService $fnsService
     */
    public function __construct(QrService $qrService, FnsService $fnsService)
    {
        $this->qrService = $qrService;
        $this->fnsService = $fnsService;
    }


    /**
     * Get info about a check,
     * @param $checkFile
     * @return Collection|null
     * @throws \Exception
     */
    public function getInfoByCheck($checkFile): Collection
    {
        return collect($this->qrService->getCheck($checkFile));
    }


    /**
     * @param $checkFile
     * @return string
     * @throws \Exception
     */
    public function getAllCheItems($checkFile)
    {
        return $this
            ->fnsService
            ->getCheckItems($this->qrService->getCheck($checkFile));
    }
}
