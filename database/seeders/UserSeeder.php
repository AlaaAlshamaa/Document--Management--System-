<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'alaa',
            'last_name'  => 'shamaa',
            'email'      => 'alaashamaa93@gmail.com',
            'password'   => 'Alaa1212!',
            'isAdmin'    => true
        ]);
    }
}
