<?php
require_once 'header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/FooterModel.php';

$model = new FooterModel($pdo);

?>
<div class="container mt-4">
    <h2>Footer Dashboard</h2>
    <p>Manage footer content from the links below.</p>
    <div class="list-group">
        <a href="manage_links.php" class="list-group-item list-group-item-action">Manage Links (Shop & Customer Service)</a>
        <a href="manage_about.php" class="list-group-item list-group-item-action">Manage About CASDO</a>
        <a href="manage_social.php" class="list-group-item list-group-item-action">Manage Social Links</a>
        <a href="manage_contact.php" class="list-group-item list-group-item-action">Manage Contact Info</a>
        <a href="logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
    </div>
</div>
