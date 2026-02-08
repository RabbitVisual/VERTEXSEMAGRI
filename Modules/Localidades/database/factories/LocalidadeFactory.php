<?php

namespace Modules\Localidades\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Localidades\App\Models\Localidade;

class LocalidadeFactory extends Factory
{
    protected $model = Localidade::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->city(),
            'codigo' => 'LOC-' . $this->faker->unique()->numerify('####'),
            'tipo' => $this->faker->randomElement(['comunidade', 'bairro', 'distrito']),
            'cep' => $this->faker->postcode(),
            'endereco' => $this->faker->streetAddress(),
            'numero' => $this->faker->buildingNumber(),
            'bairro' => $this->faker->citySuffix(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'lider_comunitario' => $this->faker->name(),
            'telefone_lider' => $this->faker->phoneNumber(),
            'numero_moradores' => $this->faker->numberBetween(50, 500),
            'ativo' => true,
        ];
    }
}

