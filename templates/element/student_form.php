<?php
$years = ['1st Year' => '1st Year', '2nd Year' => '2nd Year', '3rd Year' => '3rd Year', '4th Year' => '4th Year', '5th Year' => '5th Year'];
$genders = ['Female' => 'Female', 'Male' => 'Male', 'Prefer not to say' => 'Prefer not to say'];
?>
<div class="row g-3">
    <div class="col-md-6">
        <?= $this->Form->control('student_number', ['label' => 'Student number *', 'class' => 'form-control', 'placeholder' => 'e.g. 2026-0001']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('email', ['label' => 'Email address *', 'class' => 'form-control', 'type' => 'email', 'placeholder' => 'student@example.com']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('first_name', ['label' => 'First name *', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('last_name', ['label' => 'Last name *', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('course', ['label' => 'Course / Program *', 'class' => 'form-control', 'placeholder' => 'e.g. BS Information Technology']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('year_level', ['label' => 'Year level *', 'type' => 'select', 'options' => $years, 'empty' => 'Select year level', 'class' => 'form-select']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('date_of_birth', ['label' => 'Date of birth', 'type' => 'date', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('gender', ['label' => 'Gender', 'type' => 'select', 'options' => $genders, 'empty' => 'Select (optional)', 'class' => 'form-select']) ?>
    </div>
    <div class="col-md-6">
        <?= $this->Form->control('phone', ['label' => 'Phone number', 'class' => 'form-control', 'placeholder' => 'Optional']) ?>
    </div>
    <div class="col-12">
        <?= $this->Form->control('address', ['label' => 'Address', 'type' => 'textarea', 'rows' => 2, 'class' => 'form-control', 'placeholder' => 'Optional']) ?>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <?= $this->Form->button('Save Student', ['class' => 'btn btn-primary px-4']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-light border']) ?>
</div>
