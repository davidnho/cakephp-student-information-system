<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateStudents extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('students');
        $table
            ->addColumn('student_number', 'string', ['limit' => 30])
            ->addColumn('first_name', 'string', ['limit' => 100])
            ->addColumn('last_name', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 190])
            ->addColumn('course', 'string', ['limit' => 120])
            ->addColumn('year_level', 'string', ['limit' => 20])
            ->addColumn('date_of_birth', 'date', ['null' => true, 'default' => null])
            ->addColumn('gender', 'string', ['limit' => 30, 'null' => true, 'default' => null])
            ->addColumn('phone', 'string', ['limit' => 30, 'null' => true, 'default' => null])
            ->addColumn('address', 'text', ['null' => true, 'default' => null])
            ->addTimestamps()
            ->addIndex(['student_number'], ['unique' => true])
            ->addIndex(['email'])
            ->create();
    }
}
