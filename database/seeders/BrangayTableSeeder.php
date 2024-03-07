<?php

namespace Database\Seeders;

use App\Models\BaranggayModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrangayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brgys = ['Abango', 'Arahit', 'Balire', 'Balud', 'Bukid', 'Bulod'];
        foreach ($brgys as $brgy) {
            BaranggayModel::create([
                'city'=>'Barugo',
                'province'=>'Leyte',
                'purok'=>rand(1,50),
                'baranggay'=>$brgy,
            ]);
        }
    }
}
