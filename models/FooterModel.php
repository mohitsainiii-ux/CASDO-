<?php
// models/FooterModel.php
class FooterModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Links
    public function getLinksBySection($section) {
        $stmt = $this->pdo->prepare("SELECT * FROM footer_links WHERE section = ? ORDER BY sort_order, id");
        $stmt->execute([$section]);
        return $stmt->fetchAll();
    }

    public function addLink($section, $label, $url, $sort_order = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO footer_links (section, label, url, sort_order) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$section, $label, $url, $sort_order]);
    }

    public function updateLink($id, $label, $url, $sort_order) {
        $stmt = $this->pdo->prepare("UPDATE footer_links SET label = ?, url = ?, sort_order = ? WHERE id = ?");
        return $stmt->execute([$label, $url, $sort_order, $id]);
    }

    public function deleteLink($id) {
        $stmt = $this->pdo->prepare("DELETE FROM footer_links WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // About
    public function getAbout() {
        $stmt = $this->pdo->query("SELECT * FROM footer_about LIMIT 1");
        return $stmt->fetch();
    }

    public function updateAbout($title, $description) {
        // If exists update, else insert
        $row = $this->getAbout();
        if ($row) {
            $stmt = $this->pdo->prepare("UPDATE footer_about SET title = ?, description = ? WHERE id = ?");
            return $stmt->execute([$title, $description, $row['id']]);
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO footer_about (title, description) VALUES (?, ?)");
            return $stmt->execute([$title, $description]);
        }
    }

    // Social
    public function getSocial() {
        $stmt = $this->pdo->query("SELECT * FROM footer_social ORDER BY sort_order, id");
        return $stmt->fetchAll();
    }

    public function addSocial($platform, $url, $sort_order = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO footer_social (platform, url, sort_order) VALUES (?, ?, ?)");
        return $stmt->execute([$platform, $url, $sort_order]);
    }

    public function updateSocial($id, $platform, $url, $sort_order) {
        $stmt = $this->pdo->prepare("UPDATE footer_social SET platform = ?, url = ?, sort_order = ? WHERE id = ?");
        return $stmt->execute([$platform, $url, $sort_order, $id]);
    }

    public function deleteSocial($id) {
        $stmt = $this->pdo->prepare("DELETE FROM footer_social WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Copyright
    public function getCopy() {
        $stmt = $this->pdo->query("SELECT * FROM footer_copy LIMIT 1");
        return $stmt->fetch();
    }

    public function updateCopy($text) {
        $row = $this->getCopy();
        if ($row) {
            $stmt = $this->pdo->prepare("UPDATE footer_copy SET text = ? WHERE id = ?");
            return $stmt->execute([$text, $row['id']]);
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO footer_copy (text) VALUES (?)");
            return $stmt->execute([$text]);
        }
    }

    // Contact
    public function getContact() {
        $stmt = $this->pdo->query("SELECT * FROM footer_contact LIMIT 1");
        return $stmt->fetch();
    }

    public function updateContact($email, $phone, $address) {
        $row = $this->getContact();
        if ($row) {
            $stmt = $this->pdo->prepare("UPDATE footer_contact SET email = ?, phone = ?, address = ? WHERE id = ?");
            return $stmt->execute([$email, $phone, $address, $row['id']]);
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO footer_contact (email, phone, address) VALUES (?, ?, ?)");
            return $stmt->execute([$email, $phone, $address]);
        }
    }
}

?>
