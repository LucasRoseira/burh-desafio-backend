<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Company::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Company::create([
            'name' => 'Acme Corp',
            'description' => 'Empresa de tecnologia',
            'cnpj' => '12.345.678/0001-90',
            'plan' => 'premium',
        ]);

        Company::create([
            'name' => 'Beta Ltda',
            'description' => 'Startup inovadora',
            'cnpj' => '98.765.432/0001-01',
            'plan' => 'free',
        ]);
    }
}
