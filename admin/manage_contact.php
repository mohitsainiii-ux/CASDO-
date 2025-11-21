<?php
require_once 'header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/FooterController.php';

$controller = new FooterController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $controller->updateContact($email, $phone, $address);
    $message = 'Contact info updated.';
}

$contact = $controller->getContact();

?>
<div class="container mt-4">
    <h2>Manage Contact Info</h2>
    <?php if (isset($message)): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" class="form-control" value="<?php echo htmlspecialchars($contact['email'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input name="phone" class="form-control" value="<?php echo htmlspecialchars($contact['phone'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input name="address" class="form-control" value="<?php echo htmlspecialchars($contact['address'] ?? ''); ?>">
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
