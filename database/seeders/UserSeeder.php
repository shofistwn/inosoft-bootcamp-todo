<?php
 
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'username' => 'user_' . $i,
                'password' => bcrypt('passworduser'), // password untuk login
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ]);
        }
    }
}