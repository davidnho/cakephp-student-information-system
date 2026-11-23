<?php
$this->assign('title', 'Students | Student Information System');
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <p class="eyebrow mb-1">STUDENT DIRECTORY</p>
        <h1 class="page-title mb-1">Students</h1>
        <p class="text-secondary mb-0">Manage student records in one simple place.</p>
    </div>
    <?= $this->Html->link('+ Add Student', ['action' => 'add'], ['class' => 'btn btn-primary px-4']) ?>
</div>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="stat-card">
            <div class="stat-label">TOTAL STUDENTS</div>
            <div class="stat-number"><?= h((string)$totalStudents) ?></div>
            <div class="text-secondary small">Records in the directory</div>
        </div>
    </div>
</div>
<div class="panel">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-3">
        <h2 class="section-title mb-0">Student records</h2>
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'search-form']) ?>
            <div class="input-group">
                <?= $this->Form->control('q', ['label' => false, 'value' => $search, 'placeholder' => 'Search students...', 'class' => 'form-control', 'templates' => ['inputContainer' => '{{content}}']]) ?>
                <button class="btn btn-outline-secondary" type="submit">Search</button>
                <?php if ($search !== ''): ?>
                    <?= $this->Html->link('Clear', ['action' => 'index'], ['class' => 'btn btn-light border']) ?>
                <?php endif; ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
    <div class="table-responsive">
        <table class="table align-middle student-table">
            <thead><tr><th>Student</th><th>Student No.</th><th>Course</th><th>Year</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><div class="fw-semibold"><?= h($student->first_name . ' ' . $student->last_name) ?></div><div class="small text-secondary"><?= h($student->email) ?></div></td>
                    <td><span class="student-number"><?= h($student->student_number) ?></span></td>
                    <td><?= h($student->course) ?></td>
                    <td><span class="year-pill"><?= h($student->year_level) ?></span></td>
                    <td class="text-end text-nowrap">
                        <?= $this->Html->link('View', ['action' => 'view', $student->id], ['class' => 'btn btn-sm btn-light border']) ?>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $student->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $student->id], ['confirm' => 'Are you sure you want to delete this student?', 'class' => 'btn btn-sm btn-outline-danger']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($students) === 0): ?>
                <tr><td colspan="5" class="text-center py-5 text-secondary">No student records found. Add your first student to get started.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-3">
        <div class="small text-secondary">Page <?= h((string)$page) ?> of <?= h((string)$pageCount) ?></div>
        <nav aria-label="Student pages">
            <ul class="pagination pagination-sm mb-0">
                <?php if ($page > 1): ?><li class="page-item"><a class="page-link" href="<?= $this->Url->build(['action'=>'index','?'=>['q'=>$search,'page'=>$page-1]]) ?>">Previous</a></li><?php endif; ?>
                <?php if ($page < $pageCount): ?><li class="page-item"><a class="page-link" href="<?= $this->Url->build(['action'=>'index','?'=>['q'=>$search,'page'=>$page+1]]) ?>">Next</a></li><?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
