<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'name' => 'Delhi Public School',
                'address' => '123 Education Lane, New Delhi, India',
                'phone' => '+91-11-45678901',
                'email' => 'admin@dps.edu.in',
                'principal' => 'Dr. Rajesh Kumar',
                'established_year' => 2005,
                'board' => 'CBSE',
                'status' => 'active',
            ],
            [
                'name' => 'St. Xavier Academy',
                'address' => '456 Learning Boulevard, Mumbai, India',
                'phone' => '+91-22-45678902',
                'email' => 'admin@stxavier.edu.in',
                'principal' => 'Fr. Vincent Mascarenhas',
                'established_year' => 1998,
                'board' => 'ICSE',
                'status' => 'active',
            ],
            [
                'name' => 'Brilliant Academy',
                'address' => '789 Knowledge Drive, Bangalore, India',
                'phone' => '+91-80-45678903',
                'email' => 'admin@brilliant.edu.in',
                'principal' => 'Priya Sharma',
                'established_year' => 2010,
                'board' => 'CBSE',
                'status' => 'active',
            ],
        ];

        foreach ($schools as $school) {
            School::query()->create($school);
        }
    }
}
