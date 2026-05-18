<?php
// app/models/BasvuruModel.php

class BasvuruModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function ogrenciBasvurulariniGetir($kullanici_id) {
        $sql = "SELECT b.*, k.KategoriAdi, br.BirimAdi, d.DurumAdi, d.RenkKodu 
                FROM basvurular b
                INNER JOIN kategoriler k ON b.KategoriID = k.KategoriID
                INNER JOIN birimler br ON b.BirimID = br.BirimID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                WHERE b.KullaniciID = :kullanici_id
                ORDER BY b.OlusturulmaTarihi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':kullanici_id', $kullanici_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function basvuruEkle($kullanici_id, $kategori_id, $birim_id, $baslik, $aciklama) {
        $sql = "INSERT INTO basvurular (KullaniciID, KategoriID, BirimID, DurumID, Baslik, Aciklama) 
                VALUES (:kullanici_id, :kategori_id, :birim_id, 1, :baslik, :aciklama)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':kullanici_id' => $kullanici_id,
            ':kategori_id' => $kategori_id,
            ':birim_id' => $birim_id,
            ':baslik' => $baslik,
            ':aciklama' => $aciklama
        ]);
    }

    public function basvuruDetayGetir($basvuru_id) {
        $sql = "SELECT b.*, k.AdSoyad as OgrenciAdi, kat.KategoriAdi, bir.BirimAdi, d.DurumAdi, d.RenkKodu 
                FROM basvurular b
                INNER JOIN kullanicilar k ON b.KullaniciID = k.KullaniciID
                INNER JOIN kategoriler kat ON b.KategoriID = kat.KategoriID
                LEFT JOIN birimler bir ON b.BirimID = bir.BirimID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                WHERE b.BasvuruID = :basvuru_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':basvuru_id', $basvuru_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function birimBasvurulariniGetir($birim_id) {
        $sql = "SELECT b.*, k.AdSoyad, kat.KategoriAdi, d.DurumAdi, d.RenkKodu 
                FROM basvurular b
                INNER JOIN kullanicilar k ON b.KullaniciID = k.KullaniciID
                INNER JOIN kategoriler kat ON b.KategoriID = kat.KategoriID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                WHERE b.BirimID = :birim_id
                ORDER BY b.OlusturulmaTarihi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':birim_id', $birim_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function durumGuncelle($basvuru_id, $yeni_durum_id) {
        $sql = "UPDATE basvurular SET DurumID = :durum_id WHERE BasvuruID = :basvuru_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':durum_id', $yeni_durum_id);
        $stmt->bindParam(':basvuru_id', $basvuru_id);
        return $stmt->execute();
    }

    public function toplamBiletSayisi() {
        $sql = "SELECT COUNT(*) FROM basvurular";
        return $this->db->query($sql)->fetchColumn();
    }

    public function cozulenBiletSayisi() {
        $sql = "SELECT COUNT(*) FROM basvurular WHERE DurumID = 3";
        return $this->db->query($sql)->fetchColumn();
    }

    // --- YENİ GELİŞMİŞ İSTATİSTİK METOTLARI ---
    public function durumSayisiGetir($durum_id) {
        $sql = "SELECT COUNT(*) FROM basvurular WHERE DurumID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$durum_id]);
        return $stmt->fetchColumn();
    }

    public function sonAktiviteleriGetir() {
        $sql = "SELECT b.BasvuruID, b.Baslik, b.OlusturulmaTarihi, k.AdSoyad, d.DurumAdi, d.RenkKodu 
                FROM basvurular b
                INNER JOIN kullanicilar k ON b.KullaniciID = k.KullaniciID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                ORDER BY b.OlusturulmaTarihi DESC LIMIT 5";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tumBasvurulariGetir() {
        $sql = "SELECT b.*, k.AdSoyad, br.BirimAdi, d.DurumAdi, d.RenkKodu 
                FROM basvurular b
                INNER JOIN kullanicilar k ON b.KullaniciID = k.KullaniciID
                LEFT JOIN birimler br ON b.BirimID = br.BirimID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                ORDER BY b.OlusturulmaTarihi DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIstatistikler() {
        $total = $this->toplamBiletSayisi();
        if ($total == 0) return [];

        $sql = "SELECT d.DurumAdi, d.RenkKodu, COUNT(b.BasvuruID) as adet,
                ROUND((COUNT(b.BasvuruID) * 100.0 / $total), 1) as yuzde
                FROM durumlar d
                LEFT JOIN basvurular b ON d.DurumID = b.DurumID
                GROUP BY d.DurumID";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBirimAnalizi() {
        $sql = "SELECT br.BirimAdi, COUNT(b.BasvuruID) as adet 
                FROM birimler br 
                LEFT JOIN basvurular b ON b.BirimID = br.BirimID 
                GROUP BY br.BirimID";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tumKategorileriGetir() {
        $sql = "SELECT * FROM kategoriler ORDER BY KategoriAdi ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tumBirimleriGetir() {
        $sql = "SELECT * FROM birimler ORDER BY BirimAdi ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function aylikBasvuruTrendi() {
        $sql = "SELECT DATE_FORMAT(OlusturulmaTarihi, '%Y-%m') as Ay, COUNT(BasvuruID) as Adet 
                FROM basvurular 
                GROUP BY DATE_FORMAT(OlusturulmaTarihi, '%Y-%m') 
                ORDER BY Ay ASC LIMIT 6";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function basvuruSil($basvuru_id) {
        $sql = "DELETE FROM basvurular WHERE BasvuruID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $basvuru_id]);
    }

    // --- ÖĞRENCİ ANA SAYFASI İÇİN YENİ METOTLAR ---
    
    // Öğrencinin kendi istatistiklerini getirir
    public function ogrenciIstatistikleri($kullanici_id) {
        $sql = "SELECT 
                COUNT(BasvuruID) as Toplam,
                SUM(CASE WHEN DurumID = 1 OR DurumID = 2 THEN 1 ELSE 0 END) as DevamEden,
                SUM(CASE WHEN DurumID = 3 THEN 1 ELSE 0 END) as Cozuldu
                FROM basvurular WHERE KullaniciID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$kullanici_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Öğrencinin açtığı en son biletin durumunu getirir
    public function ogrenciSonBasvuru($kullanici_id) {
        $sql = "SELECT b.BasvuruID, b.Baslik, b.OlusturulmaTarihi, d.DurumAdi, d.RenkKodu 
                FROM basvurular b 
                INNER JOIN durumlar d ON b.DurumID = d.DurumID 
                WHERE b.KullaniciID = ? ORDER BY b.OlusturulmaTarihi DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$kullanici_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}