<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('email', 'sales@coffee.shop')->doesntExist()) {
            User::factory()->create([
                'name' => 'Sales Agent',
                'email' => 'sales@coffee.shop',
            ]);

            $this->call([
                ProductSeeder::class
            ]);
        }
    }
}
