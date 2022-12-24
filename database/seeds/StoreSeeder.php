<?php

use App\StoreLevel;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeLevels = [
            ['name' => 'Bronze', 'description' => 'Bronze Level Store'],
            ['name' => 'Silver', 'description' => 'Silver Level Store'],
            ['name' => 'Gold', 'description' => 'Gold Level Store'],
        ];
        StoreLevel::insert($storeLevels);
    }
}
