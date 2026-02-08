<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;

class FormularioManualController extends Controller
{
    /**
     * Gera formulário manual de Demanda para impressão
     */
    public function gerarFormularioDemanda()
    {
        try {
            $pdf = Pdf::loadView('demandas::pdf.formulario-manual');
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'Formulario_Manual_Demanda_' . date('Ymd_His') . '.pdf';
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Erro ao gerar formulário: ' . $e->getMessage());
        }
    }

    /**
     * Gera formulário manual de Ordem de Serviço para impressão
     * Combina primeira página (retrato) com anexo (paisagem)
     */
    public function gerarFormularioOrdem()
    {
        $tempFile1 = null;
        $tempFile2 = null;
        
        try {
            // Gerar PDF da primeira página (retrato)
            $pdfPortrait = Pdf::loadView('ordens::pdf.formulario-manual');
            $pdfPortrait->setPaper('A4', 'portrait');
            
            // Gerar PDF do anexo (paisagem)
            $pdfLandscape = Pdf::loadView('ordens::pdf.formulario-manual-anexo');
            $pdfLandscape->setPaper('A4', 'landscape');
            
            // Salvar PDFs temporários
            $tempDir = sys_get_temp_dir();
            $tempFile1 = $tempDir . DIRECTORY_SEPARATOR . 'ordem_portrait_' . uniqid() . '.pdf';
            $tempFile2 = $tempDir . DIRECTORY_SEPARATOR . 'ordem_landscape_' . uniqid() . '.pdf';
            
            file_put_contents($tempFile1, $pdfPortrait->output());
            file_put_contents($tempFile2, $pdfLandscape->output());
            
            // Combinar PDFs usando FPDI
            $mergedPdf = new Fpdi();
            
            // Adicionar primeira página (retrato)
            $pageCount = $mergedPdf->setSourceFile($tempFile1);
            for ($i = 1; $i <= $pageCount; $i++) {
                $mergedPdf->AddPage('P', [210, 297]); // A4 Portrait em mm
                $tplId = $mergedPdf->importPage($i);
                $size = $mergedPdf->getTemplateSize($tplId);
                $mergedPdf->useTemplate($tplId, 0, 0, $size['width'], $size['height']);
            }
            
            // Adicionar anexo (paisagem)
            $pageCount = $mergedPdf->setSourceFile($tempFile2);
            for ($i = 1; $i <= $pageCount; $i++) {
                $mergedPdf->AddPage('L', [297, 210]); // A4 Landscape em mm
                $tplId = $mergedPdf->importPage($i);
                $size = $mergedPdf->getTemplateSize($tplId);
                $mergedPdf->useTemplate($tplId, 0, 0, $size['width'], $size['height']);
            }
            
            // Limpar arquivos temporários
            if ($tempFile1 && file_exists($tempFile1)) {
                @unlink($tempFile1);
            }
            if ($tempFile2 && file_exists($tempFile2)) {
                @unlink($tempFile2);
            }
            
            // Retornar PDF combinado
            $filename = 'Formulario_Manual_Ordem_Servico_' . date('Ymd_His') . '.pdf';
            return response($mergedPdf->Output('S'), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            // Limpar arquivos temporários em caso de erro
            if ($tempFile1 && file_exists($tempFile1)) {
                @unlink($tempFile1);
            }
            if ($tempFile2 && file_exists($tempFile2)) {
                @unlink($tempFile2);
            }
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'Erro ao gerar formulário: ' . $e->getMessage());
        }
    }

    /**
     * Gera anexo de materiais em paisagem para Ordem de Serviço (separado)
     */
    public function gerarFormularioOrdemAnexo()
    {
        try {
            $pdf = Pdf::loadView('ordens::pdf.formulario-manual-anexo');
            $pdf->setPaper('A4', 'landscape');
            
            $filename = 'Formulario_Manual_Ordem_Servico_Anexo_' . date('Ymd_His') . '.pdf';
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Erro ao gerar anexo: ' . $e->getMessage());
        }
    }
}

