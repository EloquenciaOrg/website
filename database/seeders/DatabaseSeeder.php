<?php

namespace Database\Seeders;

use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::factory()->create([
            'email' => 'contact@ethanduault.fr',
            'password' => '$2y$12$Id3wQapDZX3wUU2Oy/S2hOyAL5Xcp7d2z454TMvVIY24EiEuC9OKK',
        ]);
    }
}
