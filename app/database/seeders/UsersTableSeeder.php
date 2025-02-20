<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
          //admin
          [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'pseudo' => 'admin123', 
            'bio' => 'Je suis l\'administrateur de la plateforme.', 
            'role' => 'admin',
            'status' => 'online',
          ],
          //agent
          [
            'name' => 'Agent',
            'email' => 'agent@gmail.com',
            'password' => Hash::make('agent@gmail.com'),
            'pseudo' => 'agent007', 
            'bio' => 'Je suis un agent de la plateforme.', 
            'role' => 'agent',
            'status' => 'online',
          ],
          //user
          [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user@gmail.com'),
            'pseudo' => 'user123',
            'bio' => 'Je suis un utilisateur de la plateforme.', 
            'role' => 'user',
            'status' => 'online',
          ],
        ]);
    }
}
