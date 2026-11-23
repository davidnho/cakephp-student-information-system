<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Student extends Entity
{
    protected $_accessible = [
        'id' => true, 'student_number' => true, 'first_name' => true, 'last_name' => true,
        'email' => true, 'course' => true, 'year_level' => true, 'date_of_birth' => true,
        'gender' => true, 'phone' => true, 'address' => true, 'created' => true, 'modified' => true,
    ];
}
