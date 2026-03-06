<?php
class PlaceModel {
    private $db;
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getPlaceDetail($id, $lang) {
        $sql = "SELECT p.*, pt.name, pt.description, pt.address 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE p.id = :id AND pt.lang_code = :lang";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'lang' => $lang]);
        return $stmt->fetch();
    }

    public function getPlacesHome($lang) {
    $sql = "SELECT p.id, p.image_main, pt.name, pt.description 
            FROM places p 
            JOIN place_translations pt ON p.id = pt.place_id 
            WHERE pt.lang_code = :lang 
            ORDER BY p.id DESC LIMIT 6";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['lang' => $lang]);
    return $stmt->fetchAll();
  }
}