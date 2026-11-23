<?php $this->assign('title', 'Student Profile'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="eyebrow mb-1">STUDENT DIRECTORY</p>
        <h1 class="page-title mb-0">Student profile</h1>
    </div>
    <div class="d-flex gap-2">
        <?= $this->Html->link('Edit', ['action' => 'edit', $student->id], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link('Back', ['action' => 'index'], ['class' => 'btn btn-light border']) ?>
    </div>
</div>
<div class="panel">
    <div class="profile-heading mb-4">
        <div class="avatar"><?= h(strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1))) ?></div>
        <div>
            <h2 class="section-title mb-1"><?= h($student->first_name . ' ' . $student->last_name) ?></h2>
            <div class="text-secondary"><?= h($student->student_number) ?></div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6"><div class="detail-label">Email</div><div><?= h($student->email) ?></div></div>
        <div class="col-md-6"><div class="detail-label">Phone</div><div><?= h($student->phone ?: '—') ?></div></div>
        <div class="col-md-6"><div class="detail-label">Course / Program</div><div><?= h($student->course) ?></div></div>
        <div class="col-md-6"><div class="detail-label">Year level</div><div><?= h($student->year_level) ?></div></div>
        <div class="col-md-6"><div class="detail-label">Date of birth</div><div><?= $student->date_of_birth ? h($student->date_of_birth->format('M d, Y')) : '—' ?></div></div>
        <div class="col-md-6"><div class="detail-label">Gender</div><div><?= h($student->gender ?: '—') ?></div></div>
        <div class="col-12"><div class="detail-label">Address</div><div><?= nl2br(h($student->address ?: '—')) ?></div></div>
    </div>
</div>
