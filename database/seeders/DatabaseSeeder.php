<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(AccountSeeder::class);
        // $this->call(UserSeeder::class);
        // \App\Models\Exam::factory()->create([
        //     'title' => "toeic",
        //     'desc' => "test listening and reading skill",
        //     'time_limit' => 30,
        //     'question_amount' => 24
        // ]);
        // $this->call(FeedbackSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EquipmentSeeder::class);
    }
}