<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportCustomerExport implements FromView, WithEvents
{
    public $customers;
    public $options;
    public function __construct( $customers, $options ) {
        $this->customers = $customers;
        $this->options = $options;
    }

    /**
    * @return View
    */
    public function view() : View
    {
        return view('exports.customer', [
            'options' => $this->options,
            'customers' => $this->customers
        ]);
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        $size = count($this->options->statuses)+ count($this->options->priorities)+ count($this->options->categories)+4;
        return [
            AfterSheet::class    => function(AfterSheet $event) use($size){
                $i = 0;
                $letter = 'A';
                while ($i <= $size) {
                    $event->sheet->getColumnDimension($letter)->setAutoSize(true);
                    $letter++;
                    $i++;
                }
            },
        ];
    }
}
