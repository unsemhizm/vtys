<?php
// app/models/KullaniciModel.php

class KullaniciModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function kullaniciGetirEposta($eposta) {
        $sql = "SELECT k.*, r.RolAdi 
                FROM kullanicilar k 
                INNER JOIN roller r ON k.RolID = r.RolID 
                WHERE k.Eposta = :eposta";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':eposta', $eposta);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function kullaniciGetirId($id) {
        $sql = "SELECT k.*, r.RolAdi, b.BirimAdi 
                FROM kullanicilar k 
                LEFT JOIN roller r ON k.RolID = r.RolID 
                LEFT JOIN birimler b ON k.BirimID = b.BirimID 
                WHERE k.KullaniciID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tumKullanicilariGetir() {
        $sql = "SELECT k.*, r.RolAdi, b.BirimAdi 
                FROM kullanicilar k 
                LEFT JOIN roller r ON k.RolID = r.RolID 
                LEFT JOIN birimler b ON k.BirimID = b.BirimID";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function kullaniciEkle($data) {
        $sql = "INSERT INTO kullanicilar (AdSoyad, Eposta, Sifre, RolID, BirimID) VALUES (?, ?, ?, ?, ?)";
        $sifreHash = password_hash($data['sifre'], PASSWORD_DEFAULT);
        return $this->db->prepare($sql)->execute([
            $data['ad_soyad'], $data['eposta'], $sifreHash, $data['rol_id'], !empty($data['birim_id']) ? $data['birim_id'] : null
        ]);
    }

    public function kullaniciGuncelle($data) {
        if (!empty($data['sifre'])) {
            $sql = "UPDATE kullanicilar SET AdSoyad = ?, Eposta = ?, Sifre = ?, RolID = ?, BirimID = ? WHERE KullaniciID = ?";
            $sifreHash = password_hash($data['sifre'], PASSWORD_DEFAULT);
            return $this->db->prepare($sql)->execute([
                $data['ad_soyad'], $data['eposta'], $sifreHash, $data['rol_id'], !empty($data['birim_id']) ? $data['birim_id'] : null, $data['kullanici_id']
            ]);
        } else {
            $sql = "UPDATE kullanicilar SET AdSoyad = ?, Eposta = ?, RolID = ?, BirimID = ? WHERE KullaniciID = ?";
            return $this->db->prepare($sql)->execute([
                $data['ad_soyad'], $data['eposta'], $data['rol_id'], !empty($data['birim_id']) ? $data['birim_id'] : null, $data['kullanici_id']
            ]);
        }
    }

    public function kullaniciSil($id) {
        $sql = "DELETE FROM kullanicilar WHERE KullaniciID = ?";
        return $this->db->prepare($sql)->execute([$id]);
    }
}