<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::table('users')->insert([
            'firstname' => 'admin',
            'lastname' => 'super',
            'is_active' => 1,
            'is_admin' => 2,
            'email' => 'admin@gmail.com',
            'idrole' => 2,
            'password' => Hash::make('123456'),
            'adresse'=>'logpom',
            'phone'=>'679353205',
        ]);

        DB::table('users')->insert([
            'firstname' => 'Desto',
            'lastname' => 'super text',
            'is_active' => 1,
            'is_admin' => 2,
            'email' => 'desto237@gmail.com',
            'idrole' => 2,
            'password' => Hash::make('123456'),
            'adresse'=>'logpom',
            'phone'=>'679353205',
        ]);
        DB::table('users')->insert([
            'firstname' => 'admin',
            'lastname' => 'simple',
            'is_active' => 1,
            'is_admin' => 1,
            'email' => 'admin2@gmail.com',
            'idrole' => 2,
            'password' => Hash::make('123456'),
            'adresse'=>'Makepe',
            'phone'=>'660041366',

        ]);
        DB::table('users')->insert([
            'firstname' => 'admin 1',
            'lastname' => 'simple 1',
            'is_active' => 0,
            'is_admin' => 1,
            'email' => 'admin1@gmail.com',
            'idrole' => 1,
            'password' => Hash::make('123456'),
            'adresse'=>'Makepe',
            'phone'=>'660041366',
        ]);

        DB::table('users')->insert([
            'firstname' => 'user',
            'lastname' => 'user 1',
            'is_active' => 1,
            'is_admin' => 0,
            'email' => 'user1@gmail.com',
            'idrole' => 1,
            'password' => Hash::make('123456'),
            'adresse'=>'Douala',
            'phone'=>'660041366',
        ]);

        DB::table('users')->insert([
            'firstname' => 'user',
            'lastname' => 'user 2',
            'is_active' => 0,
            'is_admin' => 0,
            'email' => 'user2@gmail.com',
            'idrole' => 1,
            'password' => Hash::make('123456'),
            'adresse'=>'Douala',
            'phone'=>'660041366',
        ]);

        DB::table('users')->insert([
            'firstname' => 'user',
            'lastname' => 'user 3',
            'is_active' => 1,
            'is_admin' => 0,
            'email' => 'user3@gmail.com',
            'idrole' => 1,
            'password' => Hash::make('123456'),
            'adresse'=>'Douala',
            'phone'=>'660041366',
        ]);

        DB::table('roles')->insert([
            'title' => 'Utilisateur',
        ]);
        DB::table('roles')->insert([
            'title' => 'administrateur',
        ]);
    }
}
