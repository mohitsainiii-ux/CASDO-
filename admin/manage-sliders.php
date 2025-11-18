<?php
$pageTitle = "Manage Sliders";
require_once 'header.php';

// Handle slider actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_slider'])) {
        $title = trim($_POST['title']);
        $subtitle = trim($_POST['subtitle']);
        $button_text = trim($_POST['button_text']);
        $button_link = trim($_POST['button_link']);
        
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = uniqid() . '.' . $extension;
                $upload_path = '../uploads/sliders/' . $image;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            }
        } else {
            $error = "Please select an image.";
        }
        
        if (!isset($error)) {
            $stmt = $pdo->prepare("INSERT INTO sliders (title, subtitle, image, button_text, button_link) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $subtitle, $image, $button_text, $button_link]);
            header('Location: manage-sliders.php');
            exit;
        }
    } elseif (isset($_POST['update_slider'])) {
        $id = intval($_POST['id']);
        $title = trim($_POST['title']);
        $subtitle = trim($_POST['subtitle']);
        $button_text = trim($_POST['button_text']);
        $button_link = trim($_POST['button_link']);
        $active = isset($_POST['active']) ? 1 : 0;
        
        // Handle image upload
        $image = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                // Delete old image
                if ($image && file_exists('../uploads/sliders/' . $image)) {
                    unlink('../uploads/sliders/' . $image);
                }
                
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = uniqid() . '.' . $extension;
                $upload_path = '../uploads/sliders/' . $image;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            }
        }
        
        if (!isset($error)) {
            $stmt = $pdo->prepare("UPDATE sliders SET title = ?, subtitle = ?, image = ?, button_text = ?, button_link = ?, active = ? WHERE id = ?");
            $stmt->execute([$title, $subtitle, $image, $button_text, $button_link, $active, $id]);
            header('Location: manage-sliders.php');
            exit;
        }
    }
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $sliderId = intval($_GET['delete_id']);
    
    // Get slider image to delete
    $slider = $pdo->prepare("SELECT image FROM sliders WHERE id = ?");
    $slider->execute([$sliderId]);
    $slider = $slider->fetch(PDO::FETCH_ASSOC);
    
    if ($slider && $slider['image'] && file_exists('../uploads/sliders/' . $slider['image'])) {
        unlink('../uploads/sliders/' . $slider['image']);
    }
    
    $stmt = $pdo->prepare("DELETE FROM sliders WHERE id = ?");
    $stmt->execute([$sliderId]);
    header('Location: manage-sliders.php');
    exit;
}

// Get all sliders
$sliders = $pdo->query("SELECT * FROM sliders ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Slider</h5>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <textarea class="form-control" id="subtitle" name="subtitle" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Slider Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="button_text" class="form-label">Button Text</label>
                        <input type="text" class="form-control" id="button_text" name="button_text" required>
                    </div>
                    <div class="mb-3">
                        <label for="button_link" class="form-label">Button Link</label>
                        <input type="text" class="form-control" id="button_link" name="button_link" required>
                    </div>
                    <button type="submit" name="add_slider" class="btn btn-primary">Add Slider</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Sliders</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sliders as $slider): ?>
                            <tr>
                                <td><?php echo $slider['id']; ?></td>
                                <td>
                                    <img src="../uploads/sliders/<?php echo $slider['image']; ?>" 
                                         alt="<?php echo htmlspecialchars($slider['title']); ?>" 
                                         style="width: 100px; height: 60px; object-fit: cover;">
                                </td>
                                <td><?php echo htmlspecialchars($slider['title']); ?></td>
                                <td>
                                    <?php if ($slider['active']): ?>
                                    <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" data-bs-target="#editSliderModal<?php echo $slider['id']; ?>">
                                        Edit
                                    </button>
                                    <a href="manage-sliders.php?delete_id=<?php echo $slider['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Are you sure you want to delete this slider?')">Delete</a>
                                </td>
                            </tr>
                            
                            <!-- Edit Slider Modal -->
                            <div class="modal fade" id="editSliderModal<?php echo $slider['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Slider</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $slider['id']; ?>">
                                                <input type="hidden" name="current_image" value="<?php echo $slider['image']; ?>">
                                                
                                                <div class="mb-3">
                                                    <label for="title<?php echo $slider['id']; ?>" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="title<?php echo $slider['id']; ?>" 
                                                           name="title" value="<?php echo htmlspecialchars($slider['title']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="subtitle<?php echo $slider['id']; ?>" class="form-label">Subtitle</label>
                                                    <textarea class="form-control" id="subtitle<?php echo $slider['id']; ?>" 
                                                              name="subtitle" rows="3" required><?php echo htmlspecialchars($slider['subtitle']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="image<?php echo $slider['id']; ?>" class="form-label">Slider Image</label>
                                                    <input type="file" class="form-control" id="image<?php echo $slider['id']; ?>" name="image" accept="image/*">
                                                    <div class="mt-2">
                                                        <img src="../uploads/sliders/<?php echo $slider['image']; ?>" 
                                                             alt="Current Image" style="max-width: 200px; height: auto;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="button_text<?php echo $slider['id']; ?>" class="form-label">Button Text</label>
                                                    <input type="text" class="form-control" id="button_text<?php echo $slider['id']; ?>" 
                                                           name="button_text" value="<?php echo htmlspecialchars($slider['button_text']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="button_link<?php echo $slider['id']; ?>" class="form-label">Button Link</label>
                                                    <input type="text" class="form-control" id="button_link<?php echo $slider['id']; ?>" 
                                                           name="button_link" value="<?php echo htmlspecialchars($slider['button_link']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="active<?php echo $slider['id']; ?>" 
                                                               name="active" value="1" <?php echo $slider['active'] ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="active<?php echo $slider['id']; ?>">Active</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="update_slider" class="btn btn-primary">Update Slider</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>