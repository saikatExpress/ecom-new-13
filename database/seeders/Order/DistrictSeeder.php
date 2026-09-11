<?php

namespace Database\Seeders\Order;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{

    public function run(): void
    {
        $districts = [
            // Dhaka Division
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Dhaka',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Faridpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Gazipur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Gopalganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Kishoreganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Madaripur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Manikganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Munshiganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Narayanganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Narsingdi',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Rajbari',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Shariatpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Dhaka',
                'district_name' => 'Tangail',
                'status'        => 'active',
            ],

            // Khulna Division
            [
                'division_name' => 'Khulna',
                'district_name' => 'Bagerhat',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Chuadanga',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Jashore',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Jhenaidah',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Khulna',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Kushtia',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Magura',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Meherpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Narail',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Khulna',
                'district_name' => 'Satkhira',
                'status'        => 'active',
            ],

            // Chattogram Division
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Bandarban',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Brahmanbaria',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Chandpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Chattogram',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Cumilla',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => "Cox's Bazar",
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Feni',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Khagrachhari',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Lakshmipur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Noakhali',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Chattogram',
                'district_name' => 'Rangamati',
                'status'        => 'active',
            ],

            // Rajshahi Division
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Bogura',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Joypurhat',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Naogaon',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Natore',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Chapainawabganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Pabna',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Rajshahi',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rajshahi',
                'district_name' => 'Sirajganj',
                'status'        => 'active',
            ],

            // Sylhet Division
            [
                'division_name' => 'Sylhet',
                'district_name' => 'Habiganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Sylhet',
                'district_name' => 'Moulvibazar',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Sylhet',
                'district_name' => 'Sunamganj',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Sylhet',
                'district_name' => 'Sylhet',
                'status'        => 'active',
            ],

            // Rangpur Division
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Dinajpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Gaibandha',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Kurigram',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Lalmonirhat',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Nilphamari',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Panchagarh',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Rangpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Rangpur',
                'district_name' => 'Thakurgaon',
                'status'        => 'active',
            ],

            // Mymensingh Division
            [
                'division_name' => 'Mymensingh',
                'district_name' => 'Jamalpur',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Mymensingh',
                'district_name' => 'Mymensingh',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Mymensingh',
                'district_name' => 'Netrokona',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Mymensingh',
                'district_name' => 'Sherpur',
                'status'        => 'active',
            ],

            // Barishal Division
            [
                'division_name' => 'Barishal',
                'district_name' => 'Barguna',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Barishal',
                'district_name' => 'Barishal',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Barishal',
                'district_name' => 'Bhola',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Barishal',
                'district_name' => 'Jhalokathi',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Barishal',
                'district_name' => 'Patuakhali',
                'status'        => 'active',
            ],
            [
                'division_name' => 'Barishal',
                'district_name' => 'Pirojpur',
                'status'        => 'active',
            ],
        ];

        DB::table('districts')->insert($districts);
    }
}
