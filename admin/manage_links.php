<?php
require_once 'header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/FooterController.php';

$controller = new FooterController($pdo);

// Handle add/edit/delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $section = $_POST['section'] ?? '';
        $label = $_POST['label'] ?? '';
        $url = $_POST['url'] ?? '';
        $sort = $_POST['sort_order'] ?? 0;
        $controller->addLink($section, $label, $url, $sort);
    }
    if ($action === 'update') {
        $id = $_POST['id'] ?? 0;
        $label = $_POST['label'] ?? '';
        $url = $_POST['url'] ?? '';
        $sort = $_POST['sort_order'] ?? 0;
        $controller->updateLink($id, $label, $url, $sort);
    }
    if ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        $controller->deleteLink($id);
    }
}

$shop = $controller->getLinksBySection('shop');
$customer = $controller->getLinksBySection('customer_service');

?>
<div class="container mt-4">
    <h2>Manage Links</h2>

    <h4>Shop</h4>
    <table class="table">
        <thead><tr><th>Label</th><th>URL</th><th>Sort</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($shop as $row): ?>
            <tr>
                <form method="POST">
                    <td><input name="label" value="<?php echo htmlspecialchars($row['label']); ?>" class="form-control"></td>
                    <td><input name="url" value="<?php echo htmlspecialchars($row['url']); ?>" class="form-control"></td>
                    <td><input name="sort_order" value="<?php echo (int)$row['sort_order']; ?>" class="form-control" style="width:80px;"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button name="action" value="update" class="btn btn-sm btn-primary">Update</button>
                        <button name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete link?');">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST" class="row g-2">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="section" value="shop">
        <div class="col-md-4"><input name="label" placeholder="Label" class="form-control" required></div>
        <div class="col-md-5"><input name="url" placeholder="URL" class="form-control" required></div>
        <div class="col-md-2"><input name="sort_order" placeholder="Sort" class="form-control"></div>
        <div class="col-md-1"><button class="btn btn-success">Add</button></div>
    </form>

    <hr>

    <h4>Customer Service</h4>
    <table class="table">
        <thead><tr><th>Label</th><th>URL</th><th>Sort</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($customer as $row): ?>
            <tr>
                <form method="POST">
                    <td><input name="label" value="<?php echo htmlspecialchars($row['label']); ?>" class="form-control"></td>
                    <td><input name="url" value="<?php echo htmlspecialchars($row['url']); ?>" class="form-control"></td>
                    <td><input name="sort_order" value="<?php echo (int)$row['sort_order']; ?>" class="form-control" style="width:80px;"></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button name="action" value="update" class="btn btn-sm btn-primary">Update</button>
                        <button name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete link?');">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST" class="row g-2">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="section" value="customer_service">
        <div class="col-md-4"><input name="label" placeholder="Label" class="form-control" required></div>
        <div class="col-md-5"><input name="url" placeholder="URL" class="form-control" required></div>
        <div class="col-md-2"><input name="sort_order" placeholder="Sort" class="form-control"></div>
        <div class="col-md-1"><button class="btn btn-success">Add</button></div>
    </form>

</div>
