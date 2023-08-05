<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@demoapplicationz.com',
            'mobile' => '1234567890',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
        ]);
        User::create([
            'first_name' => 'Nawaz',
            'last_name' => 'Syed',
            'email' => 'nawaz.syed@amnext.tech',
            'mobile' => '1234567891',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
        ]);
        User::create([
            'first_name' => 'Naveed',
            'last_name' => '',
            'email' => 'naveed@amnext.tech',
            'mobile' => '1234567892',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
        ]);
    }
}
