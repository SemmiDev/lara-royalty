<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // user dummy
         User::create([
             'name' => 'Sammi Aldhi Yanto',
             'email' => 'sammidev4@gmail.com',
             'password' => bcrypt('password123'),
             'email_verified_at' => now(),
         ]);


        // Tenant
        Tenant::create([
            'name' => 'Toko Sammi',
            'owner_id' => 1,
        ]);

        // customer dummy
        Customer::create([
            'name' => 'Shelvi',
            'tenant_id' => 1,
        ]);
    }
}
