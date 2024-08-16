<?php

namespace App\Exports;

use App\User;
//use App\Models\SellerMessage;
use App\Models\Category;
use App\Models\SellerOfflineCategory;
use App\Models\SellerProduct;
use App\Models\CompanyType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Helpers\XMLWriter;

class SellerExport implements FromView, ShouldAutoSize, WithEvents
{

    private $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('admin.seller.export.user_export', ['records' => $this->records]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(false);
            },
        ];
    } 
 }   

?>