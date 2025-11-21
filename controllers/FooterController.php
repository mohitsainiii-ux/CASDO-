<?php
// controllers/FooterController.php
require_once __DIR__ . '/../models/FooterModel.php';

class FooterController {
    private $model;

    public function __construct(PDO $pdo) {
        $this->model = new FooterModel($pdo);
    }

    // Link actions
    public function addLink($section, $label, $url, $sort_order = 0) {
        $label = trim($label);
        $url = trim($url);
        return $this->model->addLink($section, $label, $url, (int)$sort_order);
    }

    public function updateLink($id, $label, $url, $sort_order) {
        return $this->model->updateLink((int)$id, trim($label), trim($url), (int)$sort_order);
    }

    public function deleteLink($id) {
        return $this->model->deleteLink((int)$id);
    }

    // Expose link fetcher
    public function getLinksBySection($section) {
        return $this->model->getLinksBySection($section);
    }

    // About
    public function getAbout() { return $this->model->getAbout(); }
    public function updateAbout($title, $description) { return $this->model->updateAbout(trim($title), trim($description)); }

    // Social
    public function getSocial() { return $this->model->getSocial(); }
    public function addSocial($platform, $url, $sort_order = 0) { return $this->model->addSocial(trim($platform), trim($url), (int)$sort_order); }
    public function updateSocial($id, $platform, $url, $sort_order) { return $this->model->updateSocial((int)$id, trim($platform), trim($url), (int)$sort_order); }
    public function deleteSocial($id) { return $this->model->deleteSocial((int)$id); }

    // Copy
    public function getCopy() { return $this->model->getCopy(); }
    public function updateCopy($text) { return $this->model->updateCopy(trim($text)); }

    // Contact
    public function getContact() { return $this->model->getContact(); }
    public function updateContact($email, $phone, $address) { return $this->model->updateContact(trim($email), trim($phone), trim($address)); }
}

?>
