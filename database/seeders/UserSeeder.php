<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;
use App\Models\User;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;
    /**
     * Run the database seeds.a
     *
     * @return void
     */
    public function run()
    {
        //
        $this->disableForeignKeys();
        $this->truncate('users');
        User::factory(1)->create([
            "name" => "admin",
            "gender" => true,
            "birthdate" => "2000/05/05",
            "email" => "admin@admin",
            "password" => Hash::make("admin12345"),
            "is_admin" => true
        ]);
        User::factory(4)->create();
        $this->enableForeignKeys();
    }
}