<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class StudentsController extends AppController
{
    protected \\App\\Model\\Table\\StudentsTable $Students;

    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    public function index()
    {
        $query = $this->Students->find();
        $search = trim((string)$this->request->getQuery('q', ''));

        if ($search !== '') {
            $query->where([
                'OR' => [
                    'Students.first_name ILIKE' => '%' . $search . '%',
                    'Students.last_name ILIKE' => '%' . $search . '%',
                    'Students.student_number ILIKE' => '%' . $search . '%',
                    'Students.email ILIKE' => '%' . $search . '%',
                    'Students.course ILIKE' => '%' . $search . '%',
                ],
            ]);
        }

        $students = $this->paginate($query->orderBy(['Students.last_name' => 'ASC']));
        $totalStudents = $this->Students->find()->count();
        $this->set(compact('students', 'search', 'totalStudents'));
    }

    public function view($id = null)
    {
        $student = $this->Students->get($id);
        $this->set(compact('student'));
    }

    public function add()
    {
        $student = $this->Students->newEmptyEntity();

        if ($this->request->is('post')) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('Student record has been added.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please check the form.'));
        }

        $this->set(compact('student'));
    }

    public function edit($id = null)
    {
        $student = $this->Students->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('Student record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be updated. Please check the form.'));
        }

        $this->set(compact('student'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student = $this->Students->get($id);

        if ($this->Students->delete($student)) {
            $this->Flash->success(__('Student record has been deleted.'));
        } else {
            $this->Flash->error(__('The student could not be deleted. Please try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
