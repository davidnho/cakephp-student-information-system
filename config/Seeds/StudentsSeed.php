<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class StudentsSeed extends BaseSeed
{
    public function run(): void
    {
        $data = [
            [
                'student_number' => '2026-0001',
                'first_name' => 'Alex',
                'last_name' => 'Santos',
                'email' => 'alex.santos@example.com',
                'course' => 'BS Information Technology',
                'year_level' => '2nd Year',
                'date_of_birth' => '2005-04-18',
                'gender' => 'Male',
                'phone' => '09171234567',
                'address' => 'San Fernando, Pampanga',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'student_number' => '2026-0002',
                'first_name' => 'Mia',
                'last_name' => 'Reyes',
                'email' => 'mia.reyes@example.com',
                'course' => 'BS Computer Science',
                'year_level' => '3rd Year',
                'date_of_birth' => '2004-09-02',
                'gender' => 'Female',
                'phone' => '09179876543',
                'address' => 'Angeles City, Pampanga',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'student_number' => '2026-0003',
                'first_name' => 'Jordan',
                'last_name' => 'Garcia',
                'email' => 'jordan.garcia@example.com',
                'course' => 'BS Information Systems',
                'year_level' => '1st Year',
                'date_of_birth' => '2006-01-27',
                'gender' => 'Prefer not to say',
                'phone' => null,
                'address' => 'Mabalacat, Pampanga',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('students')->insert($data)->save();
    }
}
