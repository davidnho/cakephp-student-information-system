<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StudentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('students');
        $this->setDisplayField('student_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('student_number')
            ->maxLength('student_number', 30)
            ->requirePresence('student_number', 'create')
            ->notEmptyString('student_number', 'A student number is required.')
            ->add('student_number', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'This student number is already in use.',
            ]);

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name', 'First name is required.');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name', 'Last name is required.');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required.');

        $validator
            ->scalar('course')
            ->maxLength('course', 120)
            ->requirePresence('course', 'create')
            ->notEmptyString('course', 'Course is required.');

        $validator
            ->scalar('year_level')
            ->inList('year_level', ['1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year'])
            ->requirePresence('year_level', 'create')
            ->notEmptyString('year_level');

        $validator->date('date_of_birth')->allowEmptyDate('date_of_birth');
        $validator->inList('gender', ['Female', 'Male', 'Prefer not to say'])->allowEmptyString('gender');
        $validator->scalar('phone')->maxLength('phone', 30)->allowEmptyString('phone');
        $validator->scalar('address')->maxLength('address', 500)->allowEmptyString('address');

        return $validator;
    }
}
