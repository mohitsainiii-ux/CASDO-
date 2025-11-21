-- SQL dump for footer tables and sample data
CREATE TABLE IF NOT EXISTS `footer_links` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(64) NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `footer_about` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `footer_social` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `footer_copy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `footer_contact` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data matching screenshot categories
INSERT INTO footer_links (section, label, url, sort_order) VALUES
('shop', 'All Products', 'products.php', 1),
('shop', 'New Releases', 'products.php?new=1', 2),
('shop', 'Best Sellers', 'products.php?featured=1', 3),
('shop', 'Today's Deals', 'products.php?deals=1', 4);

INSERT INTO footer_links (section, label, url, sort_order) VALUES
('customer_service', 'Help Center', 'help.php', 1),
('customer_service', 'Returns', 'returns.php', 2),
('customer_service', 'Shipping', 'shipping.php', 3),
('customer_service', 'Track Order', 'track.php', 4);

INSERT INTO footer_about (title, description) VALUES
('About CASDO', 'CASDO is your premium online shopping destination offering curated products, fast shipping and exceptional customer service.');

INSERT INTO footer_social (platform, url, sort_order) VALUES
('Facebook', 'https://facebook.com/yourpage', 1),
('Twitter', 'https://twitter.com/yourpage', 2),
('Instagram', 'https://instagram.com/yourpage', 3),
('LinkedIn', 'https://linkedin.com/company/yourpage', 4);

INSERT INTO footer_copy (text) VALUES
('© 2023 CASDO. All rights reserved.');

INSERT INTO footer_contact (email, phone, address) VALUES
('support@casdo.com', '+1-555-123-4567', '123 Market Street, City, Country');
