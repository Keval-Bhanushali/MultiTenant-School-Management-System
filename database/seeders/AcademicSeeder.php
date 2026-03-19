<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $schools = School::all();

        foreach ($schools as $school) {
            // Create Standards (Grades)
            $standards = [
                ['name' => 'Grade 6', 'order' => 6],
                ['name' => 'Grade 7', 'order' => 7],
                ['name' => 'Grade 8', 'order' => 8],
                ['name' => 'Grade 9', 'order' => 9],
                ['name' => 'Grade 10', 'order' => 10],
                ['name' => 'Grade 11', 'order' => 11],
                ['name' => 'Grade 12', 'order' => 12],
            ];

            $createdStandards = [];
            foreach ($standards as $std) {
                $created = Standard::query()->create([
                    'school_id' => $school->_id,
                    'name' => $std['name'],
                    'order' => $std['order'],
                    'status' => 'active',
                ]);
                $createdStandards[] = $created;
            }

            // Create Subjects
            $subjects = [
                ['name' => 'Mathematics', 'code' => 'MATH'],
                ['name' => 'English', 'code' => 'ENG'],
                ['name' => 'Science', 'code' => 'SCI'],
                ['name' => 'History', 'code' => 'HIST'],
                ['name' => 'Geography', 'code' => 'GEO'],
                ['name' => 'Computer Science', 'code' => 'CS'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Art', 'code' => 'ART'],
            ];

            $createdSubjects = [];
            foreach ($subjects as $subject) {
                $created = Subject::query()->create([
                    'school_id' => $school->_id,
                    'standard_id' => $createdStandards[0]->_id,
                    'name' => $subject['name'],
                    'code' => $subject['code'],
                ]);
                $createdSubjects[] = $created;
            }

            // Create Courses
            foreach ($createdStandards as $standard) {
                Course::query()->create([
                    'school_id' => $school->_id,
                    'standard_id' => $standard->_id,
                    'name' => 'Core Curriculum - ' . $standard->name,
                    'description' => 'Main academic curriculum for ' . $standard->name,
                    'subject_ids' => array_map(fn($s) => $s->_id, $createdSubjects),
                ]);
            }
        }
    }
}
