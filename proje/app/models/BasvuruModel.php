<?php
// app/models/BasvuruModel.php

class BasvuruModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    // Belirli bir öğrencinin tüm başvurularını getiren metod
    public function ogrenciBasvurulariniGetir($kullanici_id) {
        $sql = "SELECT b.*, k.KategoriAdi, br.BirimAdi, d.DurumAdi, d.RenkKodu 
                FROM Basvurular b
                INNER JOIN Kategoriler k ON b.KategoriID = k.KategoriID
                INNER JOIN Birimler br ON b.BirimID = br.BirimID
                INNER JOIN Durumlar d ON b.DurumID = d.DurumID
                WHERE b.KullaniciID = :kullanici_id
                ORDER BY b.OlusturulmaTarihi DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':kullanici_id', $kullanici_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Tüm kayıtları dizi olarak döndür
    }

    // Yeni başvuru ekleyen metod
    public function basvuruEkle($kullanici_id, $kategori_id, $birim_id, $baslik, $aciklama) {
        // DurumID her zaman 1 (Açık) olarak başlar.
        // OlusturulmaTarihi veritabanı tarafından otomatik (CURRENT_TIMESTAMP) atanır.
        $sql = "INSERT INTO Basvurular (KullaniciID, KategoriID, BirimID, DurumID, Baslik, Aciklama) 
                VALUES (:kullanici_id, :kategori_id, :birim_id, 1, :baslik, :aciklama)";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':kullanici_id', $kullanici_id);
        $stmt->bindParam(':kategori_id', $kategori_id);
        $stmt->bindParam(':birim_id', $birim_id);
        $stmt->bindParam(':baslik', $baslik);
        $stmt->bindParam(':aciklama', $aciklama);
        
        return $stmt->execute();
    }

    // Başvuru detaylarını getiren metod
    public function basvuruDetayGetir($basvuru_id) {
        $sql = "SELECT b.*, k.AdSoyad as OgrenciAdi, kat.KategoriAdi, bir.BirimAdi, d.DurumAdi, d.RenkKodu 
                FROM Basvurular b
                INNER JOIN Kullanicilar k ON b.KullaniciID = k.KullaniciID
                INNER JOIN Kategoriler kat ON b.KategoriID = kat.KategoriID
                INNER JOIN Birimler bir ON b.BirimID = bir.BirimID
                INNER JOIN Durumlar d ON b.DurumID = d.DurumID
                WHERE b.BasvuruID = :basvuru_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':basvuru_id', $basvuru_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Personelin kendi birimine ait tüm başvuruları getiren metod
    public function birimBasvurulariniGetir($birim_id) {
        $sql = "SELECT b.*, k.AdSoyad, kat.KategoriAdi, d.DurumAdi, d.RenkKodu 
                FROM Basvurular b
                INNER JOIN Kullanicilar k ON b.KullaniciID = k.KullaniciID
                INNER JOIN Kategoriler kat ON b.KategoriID = kat.KategoriID
                INNER JOIN Durumlar d ON b.DurumID = d.DurumID
                WHERE b.BirimID = :birim_id
                ORDER BY b.OlusturulmaTarihi DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':birim_id', $birim_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Başvurunun durumunu güncelleyen metod
    public function durumGuncelle($basvuru_id, $yeni_durum_id) {
        $sql = "UPDATE Basvurular SET DurumID = :durum_id WHERE BasvuruID = :basvuru_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':durum_id', $yeni_durum_id);
        $stmt->bindParam(':basvuru_id', $basvuru_id);
        return $stmt->execute();
    }
}