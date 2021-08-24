<?php

namespace App\Jobs;

use App\Services\Catalog\InputPriceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportPriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $spreadsheet;
    protected $keysFromExcel;
    protected $inputPriceService;
    protected $companyId;


    /**
     * ImportPriceJob constructor.
     * @param $spreadsheet
     * @param $keysFromExcel
     */
    public function __construct($spreadsheet, $keysFromExcel, $companyId)
    {
        $this->inputPriceService = new InputPriceService();
        $this->spreadsheet = $spreadsheet;
        $this->keysFromExcel = $keysFromExcel;
        $this->companyId = $companyId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->inputPriceService->insertFromJob($this->spreadsheet, $this->keysFromExcel, $this->companyId);

    }
}
