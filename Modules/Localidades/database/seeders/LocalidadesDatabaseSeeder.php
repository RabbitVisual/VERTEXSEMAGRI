<?php

namespace Modules\Localidades\Database\Seeders;

use Illuminate\Database\Seeder;

class LocalidadesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CoracaoDeMariaSeeder::class,
        ]);
    }
}
