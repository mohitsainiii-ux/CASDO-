<?php
// views/footer.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/FooterModel.php';

$model = new FooterModel($pdo);
$shop = $model->getLinksBySection('shop');
$customer = $model->getLinksBySection('customer_service');
$about = $model->getAbout();
$social = $model->getSocial();
$contact = $model->getContact();
$copy = $model->getCopy();
?>

<link rel="stylesheet" href="assets/css/footer.css">
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-col">
            <h4>Shop</h4>
            <ul>
                <?php foreach ($shop as $item): ?>
                    <li><a href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Customer Service</h4>
            <ul>
                <?php foreach ($customer as $item): ?>
                    <li><a href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer-col about-col">
            <h4><?php echo htmlspecialchars($about['title'] ?? 'About CASDO'); ?></h4>
            <p><?php echo htmlspecialchars($about['description'] ?? 'CASDO is your premium online shopping destination.'); ?></p>
        </div>

        <div class="footer-col">
            <h4>Stay Connected</h4>
            <ul class="social-list">
                <?php foreach ($social as $s): ?>
                    <li><a href="<?php echo htmlspecialchars($s['url']); ?>" target="_blank"><?php echo htmlspecialchars($s['platform']); ?></a></li>
                <?php endforeach; ?>
            </ul>

            <?php if ($contact): ?>
            <div class="contact-info">
                <?php if (!empty($contact['email'])): ?><div>Email: <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"><?php echo htmlspecialchars($contact['email']); ?></a></div><?php endif; ?>
                <?php if (!empty($contact['phone'])): ?><div>Phone: <?php echo htmlspecialchars($contact['phone']); ?></div><?php endif; ?>
                <?php if (!empty($contact['address'])): ?><div>Address: <?php echo htmlspecialchars($contact['address']); ?></div><?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container-copy">
            <?php echo htmlspecialchars($copy['text'] ?? '© 2023 CASDO. All rights reserved.'); ?>
        </div>
    </div>
</footer>
