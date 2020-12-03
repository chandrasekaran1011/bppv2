<?php

namespace App\Exports\Ethics;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use \Maatwebsite\Excel\Sheet;

class CDOReportExport implements  WithEvents,WithDrawings,WithColumnWidths,FromArray,WithHeadings
{
    use RegistersEventListeners;
    public  $partners;
    public static $month;

    public function __construct(array $partners,$month)
    {
        $this->partners = $partners;
        self::$month=$month;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('logo');
        $drawing->setPath(public_path('/images/systra.jpg'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function headings(): array
    {
        return [
            
            'Project/Contract','Partner Position','Partner Name',
            'Assessment progress ','Red Flags identified, and mitigation measures','Compliance Manager\'s recommendation'
            

        ];
    }


    public function array(): array
    {
        return $this->partners;
    }

    public function columnWidths(): array
    {
        return [
            'A'=>35,
            'B'=>30,
            'C'=>35,
            'D' => 35,
            'E' => 75,
            'F' => 75,             
        ];
    }

    public static function BeforeSheet(BeforeSheet $event){
        $event->sheet->mergeCells('A1:F1');

       $event->sheet->setCellValue('A1', 'CDO Report - '.self::$month);

       $event->sheet->getRowDimension(1)->setRowHeight(50);

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        $event->sheet->styleCells(
            'A1',[
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'font'=>[
                    'name'=>'Arial',
                    'size'=>'24',
                    'bold'=>true,
                    'color' => array('rgb' => 'FF0000'),
                ],
            ]);


    }

    public static function afterSheet(AfterSheet $event){
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        

        $event->sheet->styleCells(
            'A2:F2',
            [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'font'=>[
                    'name'=>'Arial',
                    'size'=>'14',
                    'bold'=>true,
                    'color' => array('rgb' => 'FF0000'),
                ],

            ]
        );

        $event->sheet->styleCells(
            'A3:F100',
            [
                'alignment' => [
                    
                    'wrapText'=>true
                ],
                'font'=>[
                    'name'=>'Arial',
                    'size'=>'12',

                ],



                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],

            ]
        );

        $event->sheet->styleCells(
            'A3:F100',
            [
                'alignment' => [
                    'vertical'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ]);

    }
}
