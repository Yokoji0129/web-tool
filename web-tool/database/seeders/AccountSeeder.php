<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Http\Controllers\MainController;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::truncate();
        $maincontroller_object = new MainController;
        $id = $maincontroller_object->hash('Test1234');
        $random_key = Str::random(20);
        $password = $random_key . 'Test1234';
        $password = $maincontroller_object->hash($password);
        $name = 'Test1234';

        Account::create([
            'account_id' => $id,
            'account_random_key' => $random_key,
            'account_password' => $password,
            'account_name' => $name
        ]);
    }
}
