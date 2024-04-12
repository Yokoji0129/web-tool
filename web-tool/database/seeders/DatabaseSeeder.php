<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(SessionAccountSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(AccountDiarySeeder::class);
        $this->call(DiarySeeder::class);
        $this->call(DiaryPageSeeder::class);
        $this->call(PageSeeder::class);
    }
}
