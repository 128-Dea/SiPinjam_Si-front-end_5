<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Buat akun petugas/admin
        $admin = User::firstOrCreate([
            'email' => 'admin@petugas.com'
        ], [
            'name' => 'Admin Petugas',
            'email' => 'admin@petugas.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // Buat akun mahasiswa test
        $testUser = User::firstOrCreate([
            'email' => 'test@example.com'
        ], [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Buat akun petugas dengan email rin@admin.ac.id
        $rinAdmin = User::firstOrCreate([
            'email' => 'rin@admin.ac.id'
        ], [
            'name' => 'Rin Admin',
            'email' => 'rin@admin.ac.id',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // Buat akun mahasiswa dengan email yang sesuai domain baru
        $mahasiswa = User::firstOrCreate([
            'email' => 'mahasiswa@mhs.unesa.ac.id'
        ], [
            'name' => 'Mahasiswa Test',
            'email' => 'mahasiswa@mhs.unesa.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Sinkronisasi semua user ke tabel pengguna
        $users = User::all();
        foreach ($users as $user) {
            \App\Models\Pengguna::firstOrCreate([
                'email' => $user->email
            ], [
                'nama' => $user->name,
                'email' => $user->email,
                'nomor_hp' => null,
                'role' => $user->role,
            ]);
        }
    }
}
