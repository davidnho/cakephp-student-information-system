<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Student;
use App\Service\JsonStudentStore;
use Cake\Http\Exception\NotFoundException;

class StudentsController extends AppController
{
    private JsonStudentStore $store;

    public function initialize(): void
    {
        parent::initialize();
        $this->store = new JsonStudentStore();
    }

    public function index()
    {
        $search = trim((string)$this->request->getQuery('q', ''));
        $rows = $this->store->all();
        if ($search !== '') {
            $needle = mb_strtolower($search);
            $rows = array_values(array_filter($rows, static function (array $row) use ($needle): bool {
                foreach (['first_name', 'last_name', 'student_number', 'email', 'course'] as $field) {
                    if (str_contains(mb_strtolower((string)($row[$field] ?? '')), $needle)) {
                        return true;
                    }
                }
                return false;
            }));
        }

        usort($rows, static fn(array $a, array $b): int => strcmp((string)($a['last_name'] ?? ''), (string)($b['last_name'] ?? '')));
        $totalStudents = count($this->store->all());
        $page = max(1, (int)$this->request->getQuery('page', 1));
        $perPage = 10;
        $pageCount = max(1, (int)ceil(count($rows) / $perPage));
        $page = min($page, $pageCount);
        $students = array_map(fn(array $row): Student => $this->toEntity($row), array_slice($rows, ($page - 1) * $perPage, $perPage));
        $this->set(compact('students', 'search', 'totalStudents', 'page', 'pageCount'));
    }

    public function view($id = null)
    {
        $row = $this->store->find((int)$id);
        if ($row === null) {
            throw new NotFoundException('Student not found.');
        }
        $student = $this->toEntity($row);
        $this->set(compact('student'));
    }

    public function add()
    {
        $student = new Student();
        if ($this->request->is('post')) {
            $data = $this->cleanData((array)$this->request->getData());
            $errors = $this->validateData($data);
            if ($this->hasDuplicateStudentNumber($data['student_number'] ?? '')) {
                $errors['student_number']['unique'] = 'This student number is already in use.';
            }
            if ($errors === []) {
                $this->store->create($data);
                $this->Flash->success(__('Student record has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $student = new Student($data);
            $student->setErrors($errors);
            $this->Flash->error(__('Please correct the highlighted fields.'));
        }
        $this->set(compact('student'));
    }

    public function edit($id = null)
    {
        $row = $this->store->find((int)$id);
        if ($row === null) {
            throw new NotFoundException('Student not found.');
        }
        $student = $this->toEntity($row);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->cleanData((array)$this->request->getData());
            $errors = $this->validateData($data);
            if ($this->hasDuplicateStudentNumber($data['student_number'] ?? '', (int)$id)) {
                $errors['student_number']['unique'] = 'This student number is already in use.';
            }
            if ($errors === []) {
                $this->store->update((int)$id, $data);
                $this->Flash->success(__('Student record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $student = new Student(array_merge($row, $data));
            $student->setErrors($errors);
            $this->Flash->error(__('Please correct the highlighted fields.'));
        }
        $this->set(compact('student'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        if (!$this->store->delete((int)$id)) {
            throw new NotFoundException('Student not found.');
        }
        $this->Flash->success(__('Student record has been deleted.'));
        return $this->redirect(['action' => 'index']);
    }

    private function cleanData(array $data): array
    {
        $fields = ['student_number','first_name','last_name','email','course','year_level','date_of_birth','gender','phone','address'];
        $clean = [];
        foreach ($fields as $field) {
            $value = $data[$field] ?? '';
            $clean[$field] = is_scalar($value) ? trim((string)$value) : '';
        }
        return $clean;
    }

    private function validateData(array $data): array
    {
        $errors = [];
        foreach (['student_number','first_name','last_name','email','course','year_level'] as $field) {
            if (($data[$field] ?? '') === '') {
                $errors[$field]['required'] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
            }
        }
        if (($data['email'] ?? '') !== '' && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email']['format'] = 'Enter a valid email address.';
        }
        if (($data['year_level'] ?? '') !== '' && !in_array($data['year_level'], ['1st Year','2nd Year','3rd Year','4th Year','5th Year'], true)) {
            $errors['year_level']['valid'] = 'Select a valid year level.';
        }
        if (($data['date_of_birth'] ?? '') !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date_of_birth'])) {
            $errors['date_of_birth']['format'] = 'Enter a valid date.';
        }
        return $errors;
    }

    private function hasDuplicateStudentNumber(string $number, ?int $exceptId = null): bool
    {
        foreach ($this->store->all() as $row) {
            if ((string)($row['student_number'] ?? '') === $number && (int)($row['id'] ?? 0) !== $exceptId) {
                return true;
            }
        }
        return false;
    }

    private function toEntity(array $row): Student
    {
        $student = new Student($row);
        if (!empty($row['date_of_birth'])) {
            try {
                $student->set('date_of_birth', new \DateTimeImmutable((string)$row['date_of_birth']));
            } catch (\Exception) {
                $student->set('date_of_birth', null);
            }
        } else {
            $student->set('date_of_birth', null);
        }
        return $student;
    }
}
