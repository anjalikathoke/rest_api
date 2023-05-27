<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderDetailsSeeder::class);
        $this->call(RoleSeeder::class);

        // \App\Models\User::factory(10)->create();

        $users = array(
                ['name' => 'Superadmin', 'email' => 'superadmin@example.com', 'status' => 'active', 'role_id' => 1, 'password' => Hash::make('secret')],
                ['name' => 'Ryan Chenkie', 'email' => 'ryanchenkie@example.com', 'status' => 'active', 'role_id' => 2, 'password' => Hash::make('secret')],
                ['name' => 'Chris Sevilleja', 'email' => 'chris@example.com', 'status' => 'active', 'role_id' => 2, 'password' => Hash::make('secret')],
                ['name' => 'Holly Lloyd', 'email' => 'holly@example.com', 'status' => 'inactive', 'role_id' => 3, 'password' => Hash::make('secret')],
                ['name' => 'Adnan Kukic', 'email' => 'adnan@example.com', 'status' => 'active', 'role_id' => 3, 'password' => Hash::make('secret')],
        );
        foreach ($users as $user){
            User::factory()->create($user);
         }

    }
}
