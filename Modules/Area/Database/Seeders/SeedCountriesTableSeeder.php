<?php

namespace Modules\Area\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Area\Entities\Country;

class SeedCountriesTableSeeder extends Seeder
{
    private $records = [
        "Kuwait" => " ‫الكويت‬‎",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->records as $en => $ar){
            Country::create(['title' => ['ar' => $ar     , 'en' => $en],'status' => 1]);
        }
    }
}
