<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::truncate();
        Account::create([
            'account_id' => 'A1',
            'account_password' => 'damekamo',
            'account_random_key' => 'daijoubudayo',
            'account_name' => 'test'
        ]);
    }
}
