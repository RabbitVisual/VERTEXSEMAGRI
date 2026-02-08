<?php

namespace Modules\Iluminacao\App\Services;

class NeoenergiaService
{
    public const TYPE_MAPPING = [
        'LD' => 'led',
        'VS' => 'sodio',
        'VM' => 'mercurio',
        'VMet' => 'vapor_metalico',
        'Mista' => 'mista',
        'Outra' => 'outra',
    ];

    public const REVERSE_MAPPING = [
        'led' => 'LD',
        'sodio' => 'VS',
        'mercurio' => 'VM',
        'vapor_metalico' => 'VMet',
        'mista' => 'Mista',
        'outra' => 'Outra',
    ];

    public function translateToSystem(string $code): string
    {
        return self::TYPE_MAPPING[$code] ?? 'outra';
    }

    public function translateToNeoenergia(?string $systemType): string
    {
        return self::REVERSE_MAPPING[$systemType] ?? 'Outra';
    }

    public function parseCsv(string $filePath): array
    {
        $rows = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ","); // Assume header row
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Adjust mapping based on column index or header name
                // Assuming standard Neoenergia format: Código, Lat, Long, Tipo, Potência, Logradouro...
                // Ideally this should be flexible.
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }
}
