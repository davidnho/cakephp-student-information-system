<?php $this->assign('title', 'Edit Student'); ?>
<div class="mb-4">
    <p class="eyebrow mb-1">STUDENT DIRECTORY</p>
    <h1 class="page-title mb-1">Edit student</h1>
    <p class="text-secondary mb-0">Update the student's information.</p>
</div>
<div class="panel form-panel">
    <?= $this->Form->create($student) ?>
    <?= $this->element('student_form') ?>
    <?= $this->Form->end() ?>
</div>
