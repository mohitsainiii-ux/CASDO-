<?php
require_once 'header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/FooterController.php';

$controller = new FooterController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $controller->addSocial($_POST['platform'] ?? '', $_POST['url'] ?? '', $_POST['sort_order'] ?? 0);
    }
    if ($action === 'update') {
        $controller->updateSocial($_POST['id'] ?? 0, $_POST['platform'] ?? '', $_POST['url'] ?? '', $_POST['sort_order'] ?? 0);
    }
    if ($action === 'delete') {
        $controller->deleteSocial($_POST['id'] ?? 0);
    }
}

$list = $controller->getSocial();

?>
<div class="container mt-4">
    <h2>Manage Social Links</h2>

    <table class="table">
        <thead><tr><th>Platform</th><th>URL</th><th>Sort</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($list as $row): ?>
            <tr>
                <form method="POST">
                    <td><input name="platform" class="form-control" value="<?php echo htmlspecialchars($row['platform']); ?>"></td>
                    <td><input name="url" class="form-control" value="<?php echo htmlspecialchars($row['url']); ?>"></td>
                    <td><input name="sort_order" class="form-control" value="<?php echo (int)$row['sort_order']; ?>" style="width:80px;"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button name="action" value="update" class="btn btn-sm btn-primary">Update</button>
                        <button name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete?');">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST" class="row g-2">
        <input type="hidden" name="action" value="add">
        <div class="col-md-4"><input name="platform" placeholder="Platform" class="form-control" required></div>
        <div class="col-md-6"><input name="url" placeholder="URL" class="form-control" required></div>
        <div class="col-md-1"><input name="sort_order" placeholder="Sort" class="form-control"></div>
        <div class="col-md-1"><button class="btn btn-success">Add</button></div>
    </form>
</div>
