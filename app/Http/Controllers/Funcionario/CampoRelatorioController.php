<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Ordens\App\Services\CampoOrdensService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CampoRelatorioController extends Controller
{
    protected $campoOrdensService;

    public function __construct(CampoOrdensService $campoOrdensService)
    {
        $this->campoOrdensService = $campoOrdensService;
    }

    /**
     * Gerar relatório em PDF
     */
    public function pdf(Request $request)
    {
        $user = Auth::user();
        $filtros = $this->processarFiltros($request);

        $ordens = $this->campoOrdensService->buscarOrdensDoFuncionario($user, $filtros)
            ->with(['demanda.localidade', 'equipe'])
            ->get();

        $estatisticas = $this->calcularEstatisticas($ordens);

        $pdf = PDF::loadView('campo.relatorios.pdf', [
            'ordens' => $ordens,
            'estatisticas' => $estatisticas,
            'filtros' => $filtros,
            'user' => $user,
            'dataGeracao' => Carbon::now(),
        ]);

        $filename = 'relatorio-campo-' . Carbon::now()->format('Y-m-d-His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Gerar relatório em Excel
     */
    public function excel(Request $request)
    {
        $user = Auth::user();
        $filtros = $this->processarFiltros($request);

        $ordens = $this->campoOrdensService->buscarOrdensDoFuncionario($user, $filtros)
            ->with(['demanda.localidade', 'equipe'])
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalho
        $headers = ['Número', 'Descrição', 'Status', 'Prioridade', 'Localidade', 'Data Criação', 'Data Início', 'Data Conclusão', 'Tempo Execução (horas)'];
        $col = 1;
        foreach ($headers as $header) {
            $cell = Coordinate::stringFromColumnIndex($col) . '1';
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $col++;
        }

        // Dados
        $row = 2;
        foreach ($ordens as $ordem) {
            $tempoExecucao = null;
            if ($ordem->data_inicio && $ordem->data_conclusao) {
                $inicio = Carbon::parse($ordem->data_inicio);
                $fim = Carbon::parse($ordem->data_conclusao);
                $tempoExecucao = $inicio->diffInHours($fim);
            }

            $sheet->setCellValue(Coordinate::stringFromColumnIndex(1) . $row, $ordem->numero);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(2) . $row, $ordem->descricao);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(3) . $row, ucfirst($ordem->status));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(4) . $row, ucfirst($ordem->prioridade));
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(5) . $row, $ordem->demanda->localidade->nome ?? 'N/A');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(6) . $row, $ordem->created_at ? $ordem->created_at->format('d/m/Y H:i') : 'N/A');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(7) . $row, $ordem->data_inicio ? Carbon::parse($ordem->data_inicio)->format('d/m/Y H:i') : 'N/A');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(8) . $row, $ordem->data_conclusao ? Carbon::parse($ordem->data_conclusao)->format('d/m/Y H:i') : 'N/A');
            $sheet->setCellValue(Coordinate::stringFromColumnIndex(9) . $row, $tempoExecucao ?? 'N/A');
            $row++;
        }

        // Ajustar largura das colunas
        foreach (range(1, count($headers)) as $col) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_');
        $writer->save($tempFile);

        $filename = 'relatorio-campo-' . Carbon::now()->format('Y-m-d-His') . '.xlsx';

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Processar filtros da requisição
     */
    private function processarFiltros(Request $request)
    {
        $filtros = [];

        if ($request->has('data_inicio')) {
            $filtros['data_inicio'] = Carbon::parse($request->data_inicio)->startOfDay();
        }

        if ($request->has('data_fim')) {
            $filtros['data_fim'] = Carbon::parse($request->data_fim)->endOfDay();
        }

        if ($request->has('status')) {
            $filtros['status'] = $request->status;
        }

        if ($request->has('prioridade')) {
            $filtros['prioridade'] = $request->prioridade;
        }

        if ($request->has('localidade_id')) {
            $filtros['localidade_id'] = $request->localidade_id;
        }

        return $filtros;
    }

    /**
     * Calcular estatísticas das ordens
     */
    private function calcularEstatisticas($ordens)
    {
        return [
            'total' => $ordens->count(),
            'pendentes' => $ordens->where('status', 'pendente')->count(),
            'em_execucao' => $ordens->where('status', 'em_execucao')->count(),
            'concluidas' => $ordens->where('status', 'concluida')->count(),
            'alta' => $ordens->where('prioridade', 'alta')->count(),
            'media' => $ordens->where('prioridade', 'media')->count(),
            'baixa' => $ordens->where('prioridade', 'baixa')->count(),
        ];
    }
}

