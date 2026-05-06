-- ====================================================================
-- PROJE ADI: Kampüs Çözüm Merkezi - Veritabanı Kurulum Scripti (7 Tablolu İleri Düzey Normalize Şema)
-- DERS: YMÜ232 Veritabanı Yönetim Sistemleri
-- AÇIKLAMA: Bu gelişmiş script, hocanın "Rolleri neden ENUM yaptın?" eleştirisini
--           tamamen çözen, 3NF normalizasyon standartlarına uygun olarak tasarlanmış
--           7 tablolu kurumsal sürümüdür.
-- ====================================================================

-- 1. Veritabanını Oluşturma ve Seçme
CREATE DATABASE IF NOT EXISTS kampus_cozum_merkezi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kampus_cozum_merkezi;

-- 2. İlişkisel Bütünlük için Mevcut Tabloları Doğru Sırayla Silme (Varsa)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Yanitlar;
DROP TABLE IF EXISTS Basvurular;
DROP TABLE IF EXISTS Kategoriler;
DROP TABLE IF EXISTS Kullanicilar;
DROP TABLE IF EXISTS Durumlar;
DROP TABLE IF EXISTS Roller;
DROP TABLE IF EXISTS Birimler;
SET FOREIGN_KEY_CHECKS = 1;

-- ====================================================================
-- TABLO OLUŞTURMA ADIMLARI (NORMALİZE MİMARİ)
-- ====================================================================

-- Tablo 1: Birimler (Bağımsız Tablo)
CREATE TABLE Birimler (
    BirimID INT AUTO_INCREMENT PRIMARY KEY,
    BirimAdi VARCHAR(100) NOT NULL,
    Konum VARCHAR(150) NULL,
    INDEX idx_birim_adi (BirimAdi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablo 2: Roller (Yeni - ENUM Yerine Bağımsız Tablo)
CREATE TABLE Roller (
    RolID INT AUTO_INCREMENT PRIMARY KEY,
    RolAdi VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablo 3: Durumlar (Yeni - ENUM Yerine Bağımsız Tablo ve UI Entegrasyonu)
CREATE TABLE Durumlar (
    DurumID INT AUTO_INCREMENT PRIMARY KEY,
    DurumAdi VARCHAR(50) NOT NULL UNIQUE,
    RenkKodu VARCHAR(7) NOT NULL DEFAULT '#6B7280' -- Frontend badge renkleri için HEX kodu (Örn: #10B981)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablo 4: Kullanicilar (Birimler ve Roller Tablolarına Bağımlı)
CREATE TABLE Kullanicilar (
    KullaniciID INT AUTO_INCREMENT PRIMARY KEY,
    AdSoyad VARCHAR(100) NOT NULL,
    Eposta VARCHAR(100) NOT NULL UNIQUE,
    Sifre VARCHAR(255) NOT NULL, -- PHP password_hash() için 255 karakter
    RolID INT NOT NULL, -- Roller tablosundaki RolID'ye bağlanır
    BirimID INT NULL, -- Öğrenciler için NULL, personel için ilgili BirimID
    FOREIGN KEY (RolID) REFERENCES Roller(RolID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (BirimID) REFERENCES Birimler(BirimID) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_kullanici_eposta (Eposta),
    INDEX idx_kullanici_rol (RolID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablo 5: Kategoriler (Bağımsız Tablo)
CREATE TABLE Kategoriler (
    KategoriID INT AUTO_INCREMENT PRIMARY KEY,
    KategoriAdi VARCHAR(100) NOT NULL,
    Oncelik ENUM('Düşük', 'Orta', 'Yüksek') NOT NULL DEFAULT 'Orta',
    INDEX idx_kategori_adi (KategoriAdi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablo 6: Basvurular (Kullanicilar, Kategoriler, Birimler ve Durumlar Tablolarına Bağımlı)
CREATE TABLE Basvurular (
    BasvuruID INT AUTO_INCREMENT PRIMARY KEY,
    KullaniciID INT NOT NULL,
    KategoriID INT NOT NULL,
    BirimID INT NOT NULL,
    DurumID INT NOT NULL, -- Durumlar tablosundaki DurumID'ye bağlanır
    Baslik VARCHAR(150) NOT NULL,
    Aciklama TEXT NOT NULL,
    OlusturulmaTarihi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (KullaniciID) REFERENCES Kullanicilar(KullaniciID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (KategoriID) REFERENCES Kategoriler(KategoriID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (BirimID) REFERENCES Birimler(BirimID) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (DurumID) REFERENCES Durumlar(DurumID) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_basvuru_durum (DurumID),
    INDEX idx_basvuru_tarih (OlusturulmaTarihi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tablo 7: Yanitlar (Basvurular ve Kullanicilar Tablolarına Bağımlı)
CREATE TABLE Yanitlar (
    YanitID INT AUTO_INCREMENT PRIMARY KEY,
    BasvuruID INT NOT NULL,
    YanitlayanID INT NOT NULL,
    Mesaj TEXT NOT NULL,
    EkYolu VARCHAR(255) NULL, -- Yüklenen dosya yolu
    GonderilmeTarihi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BasvuruID) REFERENCES Basvurular(BasvuruID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (YanitlayanID) REFERENCES Kullanicilar(KullaniciID) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_yanit_basvuru (BasvuruID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ====================================================================
-- TEST VE BAŞLANGIÇ VERİLERİ (SEED DATA)
-- ====================================================================

-- 1. Rollerin Eklenmesi
INSERT INTO Roller (RolID, RolAdi) VALUES
(1, 'Öğrenci'),
(2, 'Personel'),
(3, 'Admin');

-- 2. Durumların Eklenmesi (İnteraktif Arayüz için Renk Kodlarıyla Birlikte)
INSERT INTO Durumlar (DurumID, DurumAdi, RenkKodu) VALUES
(1, 'Açık', '#EF4444'),        -- Kırmızı (Bootstrap: text-danger / Tailwind: bg-red-500)
(2, 'İnceleniyor', '#F59E0B'), -- Turuncu (Bootstrap: text-warning / Tailwind: bg-amber-500)
(3, 'Çözüldü', '#10B981'),     -- Yeşil (Bootstrap: text-success / Tailwind: bg-emerald-500)
(4, 'Reddedildi', '#6B7280');  -- Gri (Bootstrap: text-secondary / Tailwind: bg-gray-500)

-- 3. Birimlerin Eklenmesi
INSERT INTO Birimler (BirimID, BirimAdi, Konum) VALUES
(1, 'Bilgi İşlem Daire Başkanlığı', 'Rektörlük Binası - 2. Kat'),
(2, 'Öğrenci İşleri Daire Başkanlığı', 'Rektörlük Binası - Giriş Katı'),
(3, 'Mühendislik Fakültesi Dekanlığı', 'Mühendislik Blokları - A Blok Zemin Kat'),
(4, 'Sağlık, Kültür ve Spor Daire Başkanlığı (SKS)', 'Merkez Yemekhane Binası - 1. Kat'),
(5, 'Kütüphane ve Dokümantasyon Daire Başkanlığı', 'Merkez Kütüphane Binası');

-- 4. Kategorilerin Eklenmesi
INSERT INTO Kategoriler (KategoriID, KategoriAdi, Oncelik) VALUES
(1, 'Altyapı ve İnternet Sorunları', 'Yüksek'),
(2, 'Ders Kayıtları ve Harç İşlemleri', 'Yüksek'),
(3, 'Yemekhane ve Beslenme Hizmetleri', 'Orta'),
(4, 'Kütüphane ve Çalışma Alanları', 'Düşük'),
(5, 'Kulüp Faaliyetleri ve Etkinlikler', 'Orta');

-- 5. Kullanıcıların Eklenmesi (RolID'ler bağlandı. Şifre: 'sifre123')
INSERT INTO Kullanicilar (KullaniciID, AdSoyad, Eposta, Sifre, RolID, BirimID) VALUES
(1, 'Sistem Yöneticisi Ahmet', 'admin@kampus.edu.tr', '$2y$10$C8bV78rQ05Blyy7DbeC3pOmr4Hk4K68q38T5v3ZByhL2I2z6xYj8G', 3, NULL),
(2, 'Mühendislik Sekreteri Elif', 'eng.sekreter@kampus.edu.tr', '$2y$10$C8bV78rQ05Blyy7DbeC3pOmr4Hk4K68q38T5v3ZByhL2I2z6xYj8G', 2, 3),
(3, 'Öğrenci İşleri Görevlisi Can', 'ogris.gorevli@kampus.edu.tr', '$2y$10$C8bV78rQ05Blyy7DbeC3pOmr4Hk4K68q38T5v3ZByhL2I2z6xYj8G', 2, 2),
(4, 'Kütüphane Görevlisi Merve', 'library.gorevli@kampus.edu.tr', '$2y$10$C8bV78rQ05Blyy7DbeC3pOmr4Hk4K68q38T5v3ZByhL2I2z6xYj8G', 2, 5),
(5, 'Yusuf Canlı', 'yusuf.can@ogrenci.kampus.edu.tr', '$2y$10$C8bV78rQ05Blyy7DbeC3pOmr4Hk4K68q38T5v3ZByhL2I2z6xYj8G', 1, NULL),
(6, 'Esra Yılmaz', 'esra.yilmaz@ogrenci.kampus.edu.tr', '$2y$10$C8bV78rQ05Blyy7DbeC3pOmr4Hk4K68q38T5v3ZByhL2I2z6xYj8G', 1, NULL);

-- 6. Başvuruların (DurumID'ler bağlandı) Eklenmesi
INSERT INTO Basvurular (BasvuruID, KullaniciID, KategoriID, BirimID, DurumID, Baslik, Aciklama, OlusturulmaTarihi) VALUES
(1, 5, 1, 1, 2, 'Mühendislik Blokları Wi-Fi Kopma Sorunu', 'A Blok 3. kattaki dersliklerde eduroam ağı sürekli kopuyor ve derslerde sunum yaparken internete erişemiyoruz.', '2026-05-01 10:15:00'),
(2, 6, 2, 2, 1, 'Yatay Geçiş Muafiyet Dilekçesi Onayı', 'Yatay geçiş yaptıktan sonra verdiğim ders muafiyeti dilekçem hala sisteme işlenmemiş gözüküyor.', '2026-05-03 14:30:00'),
(3, 5, 4, 5, 3, 'Kütüphane Çalışma Salonu Klima Arızası', 'Merkez kütüphane 2. kat sessiz çalışma salonundaki klima sıcak üflüyor, içerisi ders çalışılamayacak kadar sıcak oldu.', '2026-05-04 09:00:00');

-- 7. Yanıtların Eklenmesi
INSERT INTO Yanitlar (YanitID, BasvuruID, YanitlayanID, Mesaj, EkYolu, GonderilmeTarihi) VALUES
(1, 3, 4, 'Merhaba Yusuf Bey, kütüphanemizdeki klima teknik ekipler tarafından kontrol edilmiş olup arızalı parça değiştirilmiştir. Şu an aktif olarak soğutma yapmaktadır.', NULL, '2026-05-04 11:45:00'),
(2, 1, 1, 'Yusuf Bey merhaba, ilgili kattaki erişim noktasında bir donanımsal arıza tespit edilmiştir. Yeni cihaz siparişi verilmiş olup hafta içi değişim yapılacaktır.', NULL, '2026-05-02 16:20:00');
