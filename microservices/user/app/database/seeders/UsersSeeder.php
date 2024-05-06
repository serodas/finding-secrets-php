<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'name'      => 'John Doe',
                'city'      => 'Barcelona',
                'email'     => 'john@phpmicroservices.com',
                'password'  =>  Hash::make('852456'),
                'api_token' => NULL,
            ],
            [
                'name'      => 'Joe',
                'city'      => 'Paris',
                'email'     => 'joe@phpmicroservices.com',
                'password'  =>  Hash::make('963258741'),
                'api_token' => NULL,
            ],
            [
                'name'      => 'Samir Rodas',
                'city'      => 'Pereira',
                'email'     => 'serodas@phpmicroservices.com',
                'password'  =>  Hash::make('12345678'),
                'api_token' => NULL,
            ],
        ]);
    }
}
