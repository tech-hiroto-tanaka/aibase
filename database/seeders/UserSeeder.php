<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Enums\RoleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::query()->truncate();
        Admin::query()->truncate();
        $admin = new Admin();
        $admin->name = "admin";
        $admin->email = "system@gmail.com";
        $admin->password = Hash::make('12345678');
        $admin->save();

        $user = new User();
        $user->hira_first_name = "hira_first_name";
        $user->hira_last_name = "hira_last_name";
        $user->kata_first_name = "kata_first_name";
        $user->kata_last_name = "kata_last_name";
        $user->email = "user@gmail.com";
        $user->password = Hash::make('12345678');
        $user->birthday = '2022/01/01';
        $user->phone_number = '123456789';
        $user->email_verified_at = Carbon::now();
        $user->save();

    }
}
