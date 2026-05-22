<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImovelSeeder extends Seeder
{
    public function run()
    {
        $tipos = ['Apartamento', 'Casa', 'Terreno', 'Cobertura', 'Sítio'];
        $adjetivos = ['Espaçoso', 'Moderno', 'Aconchegante', 'Luxuoso', 'Central'];
        $bairros = ['Centro', 'Jardins', 'Bela Vista', 'Barra', 'Sul'];

        $imoveis = [];

        for ($i = 0; $i < 50; $i++) {
            $descricao = $tipos[array_rand($tipos)] . ' ' . 
                         $adjetivos[array_rand($adjetivos)] . ' no ' . 
                         $bairros[array_rand($bairros)];

            $imoveis[] = [
                'descricao' => $descricao,
                'preco' => rand(15000000, 200000000) / 100, 
                'disponibilidade' => (rand(0, 10) > 3) ? 'DISPONIVEL' : 'VENDIDO', 
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('imoveis')->insert($imoveis);
    }
}