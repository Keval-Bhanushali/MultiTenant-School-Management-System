<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin (Platform Level)
        User::query()->create([
            'name' => 'Platform Administrator',
            'email' => 'superadmin@schoolhub.local',
            'password' => 'superadmin123',
            'role' => 'superadmin',
            'school_id' => null,
            'status' => 'active',
        ]);

        // Get schools for tenant context
        $schools = \App\Models\School::all();

        foreach ($schools as $school) {
            // School Admin
            User::query()->create([
                'name' => 'Admin - ' . $school->name,
                'email' => 'admin@' . strtolower(str_replace(' ', '.', $school->name)) . '.local',
                'password' => 'admin123',
                'role' => 'admin',
                'school_id' => $school->_id,
                'status' => 'active',
            ]);

            // Staff Members (Diverse roles)
            $staffRoles = ['Accountant', 'Librarian', 'Lab Technician', 'Office Manager'];
            foreach ($staffRoles as $index => $role) {
                User::query()->create([
                    'name' => $role . ' - ' . $school->name,
                    'email' => strtolower(str_replace(' ', '.', $role)) . '@' . strtolower(str_replace(' ', '.', $school->name)) . '.local',
                    'password' => 'staff123',
                    'role' => 'staff',
                    'school_id' => $school->_id,
                    'status' => 'active',
                ]);
            }

            // Teachers (Various subjects)
            $teachers = [
                ['name' => 'Mr. Arun Kumar', 'subject' => 'Mathematics'],
                ['name' => 'Ms. Priya Singh', 'subject' => 'English'],
                ['name' => 'Dr. Vikram Patel', 'subject' => 'Science'],
                ['name' => 'Ms. Anjali Mishra', 'subject' => 'History'],
                ['name' => 'Mr. Rohit Kumar', 'subject' => 'Geography'],
                ['name' => 'Ms. Deepika Sharma', 'subject' => 'Computer Science'],
            ];

            foreach ($teachers as $teacher) {
                User::query()->create([
                    'name' => $teacher['name'],
                    'email' => strtolower(str_replace(' ', '.', $teacher['name'])) . '@' . strtolower(str_replace(' ', '.', $school->name)) . '.local',
                    'password' => 'teacher123',
                    'role' => 'teacher',
                    'school_id' => $school->_id,
                    'status' => 'active',
                ]);
            }

            // Students (Multiple classes and sections)
            $studentNames = [
                'Aarav Patel', 'Vivaan Kumar', 'Arjun Singh', 'Rohan Sharma', 'Nikhil Gupta',
                'Ananya Verma', 'Diya Reddy', 'Pooja Shah', 'Neha Mehta', 'Zara Khan',
                'Aditya Singh', 'Harsh Patel', 'Varun Kumar', 'Siddharth Roy', 'Arun Nair',
                'Sarita Rao', 'Priya Kapoor', 'Sneha Bhat', 'Navya Gupta', 'Kritika Desai',
            ];

            foreach ($studentNames as $index => $name) {
                User::query()->create([
                    'name' => $name,
                    'email' => strtolower(str_replace(' ', '.', $name)) . '@' . strtolower(str_replace(' ', '.', $school->name)) . '.local',
                    'password' => 'student123',
                    'role' => 'student',
                    'school_id' => $school->_id,
                    'status' => 'active',
                ]);
            }
        }
    }
}
