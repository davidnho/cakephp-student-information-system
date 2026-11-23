<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($this->fetch('title') ?: 'Student Information System') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?= $this->Html->css('app') ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="<?= $this->Url->build('/') ?>">Campus<span class="brand-dot">.</span></a>
        <span class="navbar-text text-white-50 small">Student Information System</span>
    </div>
</nav>
<main class="container py-4 py-md-5">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>
<footer class="container py-4 text-center text-secondary small">
    Student Information System · Built with CakePHP 5
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
