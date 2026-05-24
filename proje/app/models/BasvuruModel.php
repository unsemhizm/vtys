<?php
// app/models/BasvuruModel.php

class BasvuruModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function ogrenciBasvurulariniGetir($kullanici_id) {
        $sql = "SELECT b.*, k.KategoriAdi, br.BirimAdi, d.DurumAdi, d.RenkKodu,
                       (SELECT COUNT(*) FROM yanitlar y WHERE y.BasvuruID = b.BasvuruID AND y.Okundu = 0 AND y.YanitlayanID != :kullanici_id) as OkunmamisSayisi
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

    public function birimBasvurulariniGetir($birim_id, $kullanici_id = 0) {
        $sql = "SELECT b.*, k.AdSoyad, kat.KategoriAdi, d.DurumAdi, d.RenkKodu,
                       (SELECT COUNT(*) FROM yanitlar y WHERE y.BasvuruID = b.BasvuruID AND y.Okundu = 0 AND y.YanitlayanID != :kullanici_id) as OkunmamisSayisi
                FROM basvurular b
                INNER JOIN kullanicilar k ON b.KullaniciID = k.KullaniciID
                INNER JOIN kategoriler kat ON b.KategoriID = kat.KategoriID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                WHERE b.BirimID = :birim_id
                ORDER BY b.OlusturulmaTarihi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':birim_id', $birim_id);
        $stmt->bindParam(':kullanici_id', $kullanici_id);
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

    public function tumBasvurulariGetir($kullanici_id = 0) {
        $sql = "SELECT b.*, k.AdSoyad, br.BirimAdi, d.DurumAdi, d.RenkKodu,
                       (SELECT COUNT(*) FROM yanitlar y WHERE y.BasvuruID = b.BasvuruID AND y.Okundu = 0 AND y.YanitlayanID != :kullanici_id) as OkunmamisSayisi
                FROM basvurular b
                INNER JOIN kullanicilar k ON b.KullaniciID = k.KullaniciID
                LEFT JOIN birimler br ON b.BirimID = br.BirimID
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                ORDER BY b.OlusturulmaTarihi DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':kullanici_id' => $kullanici_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    // =====================================================
    // ÖĞRENCİ DETAYLI İSTATİSTİK METOTLARI
    // =====================================================

    // Öğrencinin reddedilen talep sayısı dahil tam istatistik
    public function ogrenciDetayliIstatistik($kullanici_id) {
        $sql = "SELECT 
                COUNT(BasvuruID) as Toplam,
                SUM(CASE WHEN DurumID = 1 THEN 1 ELSE 0 END) as Acik,
                SUM(CASE WHEN DurumID = 2 THEN 1 ELSE 0 END) as Inceleniyor,
                SUM(CASE WHEN DurumID = 3 THEN 1 ELSE 0 END) as Cozuldu,
                SUM(CASE WHEN DurumID = 4 THEN 1 ELSE 0 END) as Reddedildi
                FROM basvurular WHERE KullaniciID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$kullanici_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Öğrencinin en çok başvurduğu kategoriler
    public function ogrenciKategoriDagilimi($kullanici_id) {
        $sql = "SELECT k.KategoriAdi, COUNT(b.BasvuruID) as Adet
                FROM basvurular b
                INNER JOIN kategoriler k ON b.KategoriID = k.KategoriID
                WHERE b.KullaniciID = ?
                GROUP BY k.KategoriID
                ORDER BY Adet DESC LIMIT 5";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$kullanici_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Öğrencinin son 3 talebinin kısa özeti
    public function ogrenciSonTalepler($kullanici_id) {
        $sql = "SELECT b.BasvuruID, b.Baslik, b.OlusturulmaTarihi, d.DurumAdi, d.RenkKodu
                FROM basvurular b
                INNER JOIN durumlar d ON b.DurumID = d.DurumID
                WHERE b.KullaniciID = ?
                ORDER BY b.OlusturulmaTarihi DESC LIMIT 3";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$kullanici_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // PERSONEL DETAYLI İSTATİSTİK METOTLARI
    // =====================================================

    // Birimdeki tüm başvuruların durum bazlı sayımı
    public function personelIstatistikleri($birim_id) {
        $sql = "SELECT
                COUNT(BasvuruID) as Toplam,
                SUM(CASE WHEN DurumID = 1 THEN 1 ELSE 0 END) as Acik,
                SUM(CASE WHEN DurumID = 2 THEN 1 ELSE 0 END) as Inceleniyor,
                SUM(CASE WHEN DurumID = 3 THEN 1 ELSE 0 END) as Cozuldu,
                SUM(CASE WHEN DurumID = 4 THEN 1 ELSE 0 END) as Reddedildi,
                SUM(CASE WHEN OlusturulmaTarihi >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as BuHafta
                FROM basvurular WHERE BirimID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$birim_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Birimdeki en çok talep gelen kategoriler
    public function personelKategoriDagilimi($birim_id) {
        $sql = "SELECT k.KategoriAdi, COUNT(b.BasvuruID) as Adet,
                ROUND(COUNT(b.BasvuruID) * 100.0 / (SELECT COUNT(*) FROM basvurular WHERE BirimID = ?), 1) as Yuzde
                FROM basvurular b
                INNER JOIN kategoriler k ON b.KategoriID = k.KategoriID
                WHERE b.BirimID = ?
                GROUP BY k.KategoriID
                ORDER BY Adet DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$birim_id, $birim_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Birimdeki son 30 günlük günlük/haftalık talep trendi
    public function personelHaftalikTrend($birim_id) {
        $sql = "SELECT DATE_FORMAT(OlusturulmaTarihi, '%d %b') as Gun, COUNT(BasvuruID) as Adet
                FROM basvurular
                WHERE BirimID = ? AND OlusturulmaTarihi >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                GROUP BY DATE(OlusturulmaTarihi)
                ORDER BY OlusturulmaTarihi ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$birim_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // ADMİN GELİŞMİŞ İSTATİSTİK METOTLARI
    // =====================================================

    // Sistem geneli özet istatistik
    public function adminGenelOzet() {
        $sql = "SELECT
                COUNT(*) as ToplamBasvuru,
                SUM(CASE WHEN DurumID = 1 THEN 1 ELSE 0 END) as Acik,
                SUM(CASE WHEN DurumID = 2 THEN 1 ELSE 0 END) as Inceleniyor,
                SUM(CASE WHEN DurumID = 3 THEN 1 ELSE 0 END) as Cozuldu,
                SUM(CASE WHEN DurumID = 4 THEN 1 ELSE 0 END) as Reddedildi,
                SUM(CASE WHEN OlusturulmaTarihi >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as BuHafta,
                SUM(CASE WHEN OlusturulmaTarihi >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as BuAy
                FROM basvurular";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    // Birim bazlı performans karşılaştırması (Çözüm oranıyla)
    public function adminBirimPerformansi() {
        $sql = "SELECT br.BirimAdi,
                COUNT(b.BasvuruID) as Toplam,
                SUM(CASE WHEN b.DurumID = 3 THEN 1 ELSE 0 END) as Cozulen,
                SUM(CASE WHEN b.DurumID = 1 OR b.DurumID = 2 THEN 1 ELSE 0 END) as Bekleyen,
                CASE WHEN COUNT(b.BasvuruID) > 0 
                     THEN ROUND(SUM(CASE WHEN b.DurumID = 3 THEN 1 ELSE 0 END) * 100.0 / COUNT(b.BasvuruID), 1)
                     ELSE 0 END as CozumOrani
                FROM birimler br
                LEFT JOIN basvurular b ON b.BirimID = br.BirimID
                GROUP BY br.BirimID
                ORDER BY CozumOrani DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kategori bazlı yük analizi (Öncelik ile birlikte)
    public function adminKategoriYuku() {
        $sql = "SELECT k.KategoriAdi, k.Oncelik, COUNT(b.BasvuruID) as Toplam,
                SUM(CASE WHEN b.DurumID IN (1,2) THEN 1 ELSE 0 END) as Bekleyen
                FROM kategoriler k
                LEFT JOIN basvurular b ON b.KategoriID = k.KategoriID
                GROUP BY k.KategoriID
                ORDER BY Toplam DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Son 6 aydaki aylık başvuru trendi (Admin)
    public function adminAylikTrend() {
        $sql = "SELECT DATE_FORMAT(OlusturulmaTarihi, '%Y-%m') as Ay,
                DATE_FORMAT(OlusturulmaTarihi, '%b %Y') as AyLabel,
                COUNT(BasvuruID) as Toplam,
                SUM(CASE WHEN DurumID = 3 THEN 1 ELSE 0 END) as Cozulen
                FROM basvurular
                WHERE OlusturulmaTarihi >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(OlusturulmaTarihi, '%Y-%m')
                ORDER BY Ay ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kayıtlı kullanıcı ve aktif kullanıcı sayısı
    public function adminKullaniciOzeti() {
        $sql = "SELECT 
                COUNT(*) as ToplamKullanici,
                SUM(CASE WHEN r.RolAdi = 'Öğrenci' THEN 1 ELSE 0 END) as OgrenciSayisi,
                SUM(CASE WHEN r.RolAdi = 'Personel' THEN 1 ELSE 0 END) as PersonelSayisi,
                SUM(CASE WHEN r.RolAdi = 'Admin' THEN 1 ELSE 0 END) as AdminSayisi
                FROM kullanicilar k
                INNER JOIN roller r ON k.RolID = r.RolID";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
}