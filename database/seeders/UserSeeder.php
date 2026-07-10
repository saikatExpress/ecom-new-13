<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // =========================
            // SUPER ADMIN
            // =========================
            [
                'username'     => 'Saikat Dev',
                'email'        => 'superadmin1@example.com',
                'phone_number' => '01710000001',
                'role'         => 'superadmin',
            ],
            [
                'username'     => 'Tanvir Hasan',
                'email'        => 'superadmin2@example.com',
                'phone_number' => '01710000002',
                'role'         => 'superadmin',
            ],
            [
                'username'     => 'Mahmudul Hasan',
                'email'        => 'superadmin3@example.com',
                'phone_number' => '01710000003',
                'role'         => 'superadmin',
            ],
            [
                'username'     => 'Rakib Hossain',
                'email'        => 'superadmin4@example.com',
                'phone_number' => '01710000004',
                'role'         => 'superadmin',
            ],
            [
                'username'     => 'Sabbir Ahmed',
                'email'        => 'superadmin5@example.com',
                'phone_number' => '01710000005',
                'role'         => 'superadmin',
            ],

            // =========================
            // ADMIN
            // =========================
            [
                'username'     => 'Nayeem Islam',
                'email'        => 'admin1@example.com',
                'phone_number' => '01710000006',
                'role'         => 'admin',
            ],
            [
                'username'     => 'Shakil Ahmed',
                'email'        => 'admin2@example.com',
                'phone_number' => '01710000007',
                'role'         => 'admin',
            ],
            [
                'username'     => 'Imran Hossain',
                'email'        => 'admin3@example.com',
                'phone_number' => '01710000008',
                'role'         => 'admin',
            ],
            [
                'username'     => 'Mehedi Hasan',
                'email'        => 'admin4@example.com',
                'phone_number' => '01710000009',
                'role'         => 'admin',
            ],
            [
                'username'     => 'Arif Rahman',
                'email'        => 'admin5@example.com',
                'phone_number' => '01710000010',
                'role'         => 'admin',
            ],

            // =========================
            // TEAM LEAD
            // =========================
            [
                'username'     => 'Jahid Hasan',
                'email'        => 'teamlead1@example.com',
                'phone_number' => '01710000011',
                'role'         => 'teamlead',
            ],
            [
                'username'     => 'Fahim Ahmed',
                'email'        => 'teamlead2@example.com',
                'phone_number' => '01710000012',
                'role'         => 'teamlead',
            ],
            [
                'username'     => 'Rifat Hossain',
                'email'        => 'teamlead3@example.com',
                'phone_number' => '01710000013',
                'role'         => 'teamlead',
            ],
            [
                'username'     => 'Mizanur Rahman',
                'email'        => 'teamlead4@example.com',
                'phone_number' => '01710000014',
                'role'         => 'teamlead',
            ],
            [
                'username'     => 'Nafis Islam',
                'email'        => 'teamlead5@example.com',
                'phone_number' => '01710000015',
                'role'         => 'teamlead',
            ],

            // =========================
            // STAFF
            // =========================
            [
                'username'     => 'Shuvo Roy',
                'email'        => 'staff1@example.com',
                'phone_number' => '01710000016',
                'role'         => 'staff',
            ],
            [
                'username'     => 'Rasel Mia',
                'email'        => 'staff2@example.com',
                'phone_number' => '01710000017',
                'role'         => 'staff',
            ],
            [
                'username'     => 'Sumon Khan',
                'email'        => 'staff3@example.com',
                'phone_number' => '01710000018',
                'role'         => 'staff',
            ],
            [
                'username'     => 'Nazmul Islam',
                'email'        => 'staff4@example.com',
                'phone_number' => '01710000019',
                'role'         => 'staff',
            ],
            [
                'username'     => 'Sohel Rana',
                'email'        => 'staff5@example.com',
                'phone_number' => '01710000020',
                'role'         => 'staff',
            ],
        ];

        foreach ($users as $item) {

            $role = Role::where('name', $item['role'])->first();

            $user = User::updateOrCreate(
                [
                    'phone_number' => $item['phone_number'],
                ],
                [
                    'username' => $item['username'],
                    'email' => $item['email'],
                    'password' => Hash::make('12345678'),
                    'status' => 'active',
                ]
            );

            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }
    }
}
