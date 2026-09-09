<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        User::updateOrCreate([
            'email' => 'admin@ppproducoes.com',
        ], [
            'name' => 'Administrador PP',
            'password' => 'password',
            'role' => UserRole::Admin,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate([
            'email' => 'equipe@ppproducoes.com',
        ], [
            'name' => 'Equipe PP',
            'password' => 'password',
            'role' => UserRole::Team,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        $this->call(EquipmentSeeder::class);
    }
}
