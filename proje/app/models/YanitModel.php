<?php
// app/models/YanitModel.php

class YanitModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function yanitlariGetir($basvuru_id) {
        $sql = "SELECT y.*, k.AdSoyad, r.RolAdi 
                FROM Yanitlar y
                INNER JOIN Kullanicilar k ON y.YanitlayanID = k.KullaniciID
                INNER JOIN Roller r ON k.RolID = r.RolID
                WHERE y.BasvuruID = :basvuru_id
                ORDER BY y.GonderilmeTarihi ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':basvuru_id', $basvuru_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // HATAYI DÜZELTEN METOD:
    public function yanitEkle($basvuru_id, $yanitlayan_id, $icerik) {
        // Veritabanı şemana göre sütun adı 'Mesaj'dır
        $sql = "INSERT INTO Yanitlar (BasvuruID, YanitlayanID, Mesaj) 
                VALUES (:basvuru_id, :yanitlayan_id, :icerik)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':basvuru_id', $basvuru_id);
        $stmt->bindParam(':yanitlayan_id', $yanitlayan_id);
        $stmt->bindParam(':icerik', $icerik);
        return $stmt->execute();
    }
}