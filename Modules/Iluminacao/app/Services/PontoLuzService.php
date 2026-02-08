<?php

namespace Modules\Iluminacao\App\Services;

use Modules\Iluminacao\App\Models\PontoLuz;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class PontoLuzService
{
    public function exportToCsv()
    {
        $pontos = PontoLuz::with('localidade')->get();
        $csv = [];
        // Header according to Neoenergia/Audit format
        $csv[] = [
            'ID',
            'Codigo',
            'Localidade ID',
            'Localidade Nome',
            'Endereco',
            'Latitude',
            'Longitude',
            'Barramento',
            'Trafo',
            'Quantidade',
            'Potencia (W)',
            'Tipo Lampada',
            'Codigo Lampada', // NEW
            'Horas Diarias',
            'Status',
            'Observacoes'
        ];

        foreach ($pontos as $ponto) {
            $csv[] = [
                $ponto->id,
                $ponto->codigo,
                $ponto->localidade_id,
                $ponto->localidade ? $ponto->localidade->nome : '',
                $ponto->endereco,
                $ponto->latitude,
                $ponto->longitude,
                $ponto->barramento,
                $ponto->trafo,
                $ponto->quantidade,
                $ponto->potencia,
                $ponto->tipo_lampada,
                $this->mapTipoLampadaToCode($ponto->tipo_lampada), // NEW
                $ponto->horas_diarias,
                $ponto->status,
                $ponto->observacoes
            ];
        }

        $output = fopen('php://temp', 'r+');
        foreach ($csv as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        return $content;
    }

    private function mapTipoLampadaToCode($tipo)
    {
        if (!$tipo) return '';
        $tipo = strtoupper($tipo);
        if (strpos($tipo, 'LED') !== false) return 'LD';
        if (strpos($tipo, 'VAPOR') !== false && strpos($tipo, 'SODIO') !== false) return 'VS';
        if (strpos($tipo, 'VAPOR') !== false && strpos($tipo, 'METALICO') !== false) return 'VM';
        if (strpos($tipo, 'FLUORESCENTE') !== false) return 'FL';
        return 'OUT';
    }

    public function importFromCsv($file)
    {
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // Skip header

        // Basic header validation could be added here
        
        $processed = 0;
        $errors = [];
        $rowNumber = 1;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                
                // Map columns based on assumed order from export
                // Offset by +1 for columns after 'Tipo Lampada' because of 'Codigo Lampada'
                // ID (0), Codigo (1), LocID (2), LocNome (3), Endereco (4), Lat (5), Long (6), Bar (7), Trafo (8), Qtd (9), Pot (10), Tipo (11), CodTipo (12), Horas (13), Status (14), Obs (15)
                
                // Validate row length
                if (count($row) < 5) {
                    $errors[] = "Row $rowNumber: Invalid row format.";
                    continue;
                }

                $id = $row[0] ?? null;
                // If ID is numeric, it's an update. If empty, create.
                
                $data = [
                    'localidade_id' => !empty($row[2]) ? $row[2] : null,
                    'endereco' => $row[4] ?? null,
                    'latitude' => !empty($row[5]) ? $row[5] : null,
                    'longitude' => !empty($row[6]) ? $row[6] : null,
                    'barramento' => $row[7] ?? null,
                    'trafo' => $row[8] ?? null,
                    'quantidade' => !empty($row[9]) ? $row[9] : 1,
                    'potencia' => !empty($row[10]) ? $row[10] : null,
                    'tipo_lampada' => $row[11] ?? null,
                    'horas_diarias' => !empty($row[13]) ? $row[13] : null, // Index shifted by 1 due to new column
                    'status' => $row[14] ?? 'funcionando',
                    'observacoes' => $row[15] ?? null,
                ];

                // Validate duplicates for Trafo
                if (!empty($data['trafo'])) {
                    $query = PontoLuz::where('trafo', $data['trafo']);
                    if ($id && is_numeric($id)) {
                        $query->where('id', '!=', $id);
                    }
                    if ($query->exists()) {
                        $errors[] = "Row $rowNumber: Trafo '{$data['trafo']}' already exists.";
                        continue;
                    }
                }

                // Create or Update
                if ($id && is_numeric($id)) {
                    $ponto = PontoLuz::find($id);
                    if ($ponto) {
                        $ponto->update($data);
                        $processed++;
                    } else {
                        $errors[] = "Row $rowNumber: ID $id not found.";
                    }
                } else {
                    // Create
                    if (empty($data['localidade_id']) || empty($data['endereco'])) {
                         $errors[] = "Row $rowNumber: Localidade ID and Endereco are required for new records.";
                         continue;
                    }
                    PontoLuz::create($data);
                    $processed++;
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                // Format errors as string
                throw ValidationException::withMessages(['csv_import' => implode("\n", $errors)]);
            }

            DB::commit();
            return $processed;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            if (is_resource($handle)) {
                fclose($handle);
            }
        }
    }
}
