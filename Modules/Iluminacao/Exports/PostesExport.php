<?php

namespace Modules\Iluminacao\Exports;

use Modules\Iluminacao\App\Models\Poste;
use Modules\Iluminacao\App\Services\NeoenergiaService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostesExport
{
    protected $neoenergiaService;

    public function __construct()
    {
        $this->neoenergiaService = new NeoenergiaService();
    }

    public function download(string $fileName): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Headings
        $headings = [
            'CÓDIGO (IP)',
            'LATITUDE',
            'LONGITUDE',
            'TIPO LÂMPADA',
            'POTÊNCIA (W)',
            'LOGRADOURO',
            'BAIRRO',
            'TRAFO',
            'BARRAMENTO'
        ];

        $sheet->fromArray([$headings], NULL, 'A1');

        // 2. Data
        $postes = Poste::all();
        $row = 2;
        foreach ($postes as $poste) {
            $sheet->fromArray([
                $poste->codigo,
                $poste->latitude,
                $poste->longitude,
                $this->neoenergiaService->translateToNeoenergia($poste->tipo_lampada),
                $poste->potencia,
                $poste->logradouro,
                $poste->bairro,
                $poste->trafo,
                $poste->barramento ? 'SIM' : 'NÃO',
            ], NULL, 'A' . $row);
            $row++;
        }

        $lastRow = $row - 1;
        $lastColumn = 'I'; // A to I

        // 3. Styles

        // Header Style (Dark Blue)
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F4E78'], // Dark Blue
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(25);

        if ($lastRow >= 2) {
             // Column A (Código) - Light Blue
             $sheet->getStyle('A2:A' . $lastRow)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFDDEBF7'],
                ],
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            // Columns B & C (Geo) - Light Gray
            $sheet->getStyle('B2:C' . $lastRow)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF2F2F2'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            // Columns D & E (Technical) - Light Yellow
            $sheet->getStyle('D2:E' . $lastRow)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFF2CC'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

             // Columns F & G (Location) - Light Green
             $sheet->getStyle('F2:G' . $lastRow)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2EFDA'],
                ],
            ]);

            // General Borders
            $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FFBFBFBF'],
                    ],
                ],
            ]);
        }

        // AutoSize Columns
        foreach (range('A', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 4. Return Output Stream
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
