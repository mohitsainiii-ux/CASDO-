<?php
require_once 'header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/FooterController.php';

$controller = new FooterController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $controller->updateAbout($title, $description);
    $message = 'About section updated.';
}

$about = $controller->getAbout();

?>
<div class="container mt-4">
    <h2>Manage About CASDO</h2>
    <?php if (isset($message)): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" value="<?php echo htmlspecialchars($about['title'] ?? 'About CASDO'); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="6"><?php echo htmlspecialchars($about['description'] ?? ''); ?></textarea>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
