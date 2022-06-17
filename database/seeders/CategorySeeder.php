<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;

class CategorySeeder extends Seeder
{

    use TruncateTable, DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->disableForeignKeys();
        $this->truncate('categories');
        Category::factory()->create([
            'title' => 'Laptop'
        ]);
        Category::factory()->create([
            'title' => 'PC'
        ]);
        $this->enableForeignKeys();
    }
}