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


class MasterReportExport  implements WithEvents, WithDrawings, WithColumnWidths, FromArray, WithHeadings
{
    use RegistersEventListeners;
    public  $partners;
    public static $month;
    public static $count = 0;

    public function __construct(array $partners, $month, $count)
    {
        $this->partners = $partners;
        self::$month = $month;
        self::$count = $count + 2;
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
            'Sl No',
            'Entity',
            'Initiation Date',
            'Partner Name',
            'Project',
            'Position',
            'Org. Type',
            'Ques.  Submitted',
            'Ques.  Submitted Date',
            'Form Submitted',
            'Form Submitted Date',
            'Red Flags',
            'Mitigation action',
            'Internet Search',
            'Enhanced Integrity',
            'Mitigation Action Proposed by compliance Manager',
            'Decision',
            'Reason for Decision',
            'Conditions',
            'Approved Date',
            'Registraion Number'


        ];
    }


    public function array(): array
    {
        return $this->partners;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 20,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 30,
            'I' => 30,
            'J' => 30,
            'K' => 30,
            'L' => 50,
            'M' => 50,
            'N' => 20,
            'O' => 20,
            'P' => 50,
            'Q' => 20,
            'R' => 50,
            'S' => 50,
            'T' => 20,
            'U' => 40,
        ];
    }

    public static function BeforeSheet(BeforeSheet $event)
    {
        $event->sheet->mergeCells('A1:K1');

        $event->sheet->setCellValue('A1', 'Master Tracker - ' . self::$month);

        $event->sheet->getRowDimension(1)->setRowHeight(50);


        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        $event->sheet->styleCells(
            'A1',
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'font' => [
                    'name' => 'Arial',
                    'size' => '24',
                    'bold' => true,
                    'color' => array('rgb' => 'FF0000'),
                ],
            ]
        );
    }

    public static function afterSheet(AfterSheet $event)
    {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });



        $event->sheet->styleCells(
            'A2:U2',
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'font' => [
                    'name' => 'Arial',
                    'size' => '14',
                    'bold' => true,
                    'color' => array('rgb' => 'FF0000'),
                ],

            ]
        );

        $event->sheet->styleCells(
            'A3:U' . self::$count,
            [
                'alignment' => [

                    'wrapText' => true
                ],
                'font' => [
                    'name' => 'Arial',
                    'size' => '12',

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
            'A3:U' . self::$count,
            [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ]
        );

        $event->sheet->getRowDimension(2)->setRowHeight(30);
    }
}
