<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    DB::table('equipment')->insert([
        ['name' => 'Liebherr LTM 11200 Crane', 'plate_number' => 'CRN-11200', 'status' => 'available'],
        ['name' => 'Tadano TG-500E Mobile Crane', 'plate_number' => 'CRN-TG500', 'status' => 'available'],
        ['name' => 'Kobelco CK-500G Tower Crane', 'plate_number' => 'CRN-CK500', 'status' => 'available'],
        ['name' => 'Zoomlion ZTC250', 'plate_number' => 'CRN-ZTC250', 'status' => 'available'],
        ['name' => 'Manitowoc MLC300', 'plate_number' => 'CRN-MLC300', 'status' => 'available'],
    ]);
}
}