-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 24 May 2026, 16:12:18
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kampus_cozum_merkezi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `basvurular`
--

CREATE TABLE `basvurular` (
  `BasvuruID` int(11) NOT NULL,
  `KullaniciID` int(11) NOT NULL,
  `KategoriID` int(11) NOT NULL,
  `BirimID` int(11) DEFAULT NULL,
  `DurumID` int(11) NOT NULL,
  `Baslik` varchar(150) NOT NULL,
  `Aciklama` text NOT NULL,
  `OlusturulmaTarihi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `basvurular`
--

INSERT INTO `basvurular` (`BasvuruID`, `KullaniciID`, `KategoriID`, `BirimID`, `DurumID`, `Baslik`, `Aciklama`, `OlusturulmaTarihi`) VALUES
(1, 5, 1, 1, 2, 'Mühendislik Blokları Wi-Fi Kopma Sorunu', 'A Blok 3. kattaki dersliklerde eduroam ağı sürekli kopuyor ve derslerde sunum yaparken internete erişemiyoruz.', '2026-05-01 10:15:00'),
(2, 6, 2, 2, 1, 'Yatay Geçiş Muafiyet Dilekçesi Onayı', 'Yatay geçiş yaptıktan sonra verdiğim ders muafiyeti dilekçem hala sisteme işlenmemiş gözüküyor.', '2026-05-03 14:30:00'),
(3, 5, 4, 5, 3, 'Kütüphane Çalışma Salonu Klima Arızası', 'Merkez kütüphane 2. kat sessiz çalışma salonundaki klima sıcak üflüyor, içerisi ders çalışılamayacak kadar sıcak oldu.', '2026-05-04 09:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `birimler`
--

CREATE TABLE `birimler` (
  `BirimID` int(11) NOT NULL,
  `BirimAdi` varchar(100) NOT NULL,
  `Konum` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `birimler`
--

INSERT INTO `birimler` (`BirimID`, `BirimAdi`, `Konum`) VALUES
(1, 'Bilgi İşlem Daire Başkanlığı', 'Rektörlük Binası - 2. Kat'),
(2, 'Öğrenci İşleri Daire Başkanlığı', 'Rektörlük Binası - Giriş Katı'),
(3, 'Mühendislik Fakültesi Dekanlığı', 'Mühendislik Blokları - A Blok Zemin Kat'),
(4, 'Sağlık, Kültür ve Spor Daire Başkanlığı (SKS)', 'Merkez Yemekhane Binası - 1. Kat'),
(5, 'Kütüphane ve Dokümantasyon Daire Başkanlığı', 'Merkez Kütüphane Binası');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `durumlar`
--

CREATE TABLE `durumlar` (
  `DurumID` int(11) NOT NULL,
  `DurumAdi` varchar(50) NOT NULL,
  `RenkKodu` varchar(7) NOT NULL DEFAULT '#6B7280'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `durumlar`
--

INSERT INTO `durumlar` (`DurumID`, `DurumAdi`, `RenkKodu`) VALUES
(1, 'Açık', '#EF4444'),
(2, 'İnceleniyor', '#F59E0B'),
(3, 'Çözüldü', '#10B981'),
(4, 'Reddedildi', '#6B7280');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `KategoriID` int(11) NOT NULL,
  `KategoriAdi` varchar(100) NOT NULL,
  `Oncelik` enum('Düşük','Orta','Yüksek') NOT NULL DEFAULT 'Orta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`KategoriID`, `KategoriAdi`, `Oncelik`) VALUES
(1, 'Altyapı ve İnternet Sorunları', 'Yüksek'),
(2, 'Ders Kayıtları ve Harç İşlemleri', 'Yüksek'),
(3, 'Yemekhane ve Beslenme Hizmetleri', 'Orta'),
(4, 'Kütüphane ve Çalışma Alanları', 'Düşük'),
(5, 'Kulüp Faaliyetleri ve Etkinlikler', 'Orta');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `KullaniciID` int(11) NOT NULL,
  `AdSoyad` varchar(100) NOT NULL,
  `Eposta` varchar(100) NOT NULL,
  `Sifre` varchar(255) NOT NULL,
  `RolID` int(11) NOT NULL,
  `BirimID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`KullaniciID`, `AdSoyad`, `Eposta`, `Sifre`, `RolID`, `BirimID`) VALUES
(1, 'Sistem Yöneticisi Ahmet', 'admin@kampus.edu.tr', '$2y$10$Ggt/2uvt.N9cRo1Yb2AAJO/p6lE2rgVqYu9RugNH1fPtytDKGEiQG', 3, NULL),
(2, 'Mühendislik Sekreteri Elif', 'eng.sekreter@kampus.edu.tr', '$2y$10$Ggt/2uvt.N9cRo1Yb2AAJO/p6lE2rgVqYu9RugNH1fPtytDKGEiQG', 2, 3),
(3, 'Görevli Can', 'ogris.gorevli@kampus.edu.tr', '$2y$10$Ggt/2uvt.N9cRo1Yb2AAJO/p6lE2rgVqYu9RugNH1fPtytDKGEiQG', 2, 2),
(4, 'Kütüphane Görevlisi Merve', 'library.gorevli@kampus.edu.tr', '$2y$10$Ggt/2uvt.N9cRo1Yb2AAJO/p6lE2rgVqYu9RugNH1fPtytDKGEiQG', 2, 5),
(5, 'Yusuf Canlı', 'yusuf.can@ogrenci.kampus.edu.tr', '$2y$10$Ggt/2uvt.N9cRo1Yb2AAJO/p6lE2rgVqYu9RugNH1fPtytDKGEiQG', 1, NULL),
(6, 'Esra Yılmaz', 'esra.yilmaz@ogrenci.kampus.edu.tr', '$2y$10$Ggt/2uvt.N9cRo1Yb2AAJO/p6lE2rgVqYu9RugNH1fPtytDKGEiQG', 1, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roller`
--

CREATE TABLE `roller` (
  `RolID` int(11) NOT NULL,
  `RolAdi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `roller`
--

INSERT INTO `roller` (`RolID`, `RolAdi`) VALUES
(3, 'Admin'),
(1, 'Öğrenci'),
(2, 'Personel');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yanitlar`
--

CREATE TABLE `yanitlar` (
  `YanitID` int(11) NOT NULL,
  `BasvuruID` int(11) NOT NULL,
  `YanitlayanID` int(11) NOT NULL,
  `Mesaj` text NOT NULL,
  `EkYolu` varchar(255) DEFAULT NULL,
  `GonderilmeTarihi` datetime NOT NULL DEFAULT current_timestamp(),
  `Okundu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `yanitlar`
--

INSERT INTO `yanitlar` (`YanitID`, `BasvuruID`, `YanitlayanID`, `Mesaj`, `EkYolu`, `GonderilmeTarihi`) VALUES
(1, 3, 4, 'Merhaba Yusuf Bey, kütüphanemizdeki klima teknik ekipler tarafından kontrol edilmiş olup arızalı parça değiştirilmiştir. Şu an aktif olarak soğutma yapmaktadır.', NULL, '2026-05-04 11:45:00'),
(2, 1, 1, 'Yusuf Bey merhaba, ilgili kattaki erişim noktasında bir donanımsal arıza tespit edilmiştir. Yeni cihaz siparişi verilmiş olup hafta içi değişim yapılacaktır.', NULL, '2026-05-02 16:20:00');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `basvurular`
--
ALTER TABLE `basvurular`
  ADD PRIMARY KEY (`BasvuruID`),
  ADD KEY `KullaniciID` (`KullaniciID`),
  ADD KEY `KategoriID` (`KategoriID`),
  ADD KEY `BirimID` (`BirimID`),
  ADD KEY `idx_basvuru_durum` (`DurumID`),
  ADD KEY `idx_basvuru_tarih` (`OlusturulmaTarihi`);

--
-- Tablo için indeksler `birimler`
--
ALTER TABLE `birimler`
  ADD PRIMARY KEY (`BirimID`),
  ADD KEY `idx_birim_adi` (`BirimAdi`);

--
-- Tablo için indeksler `durumlar`
--
ALTER TABLE `durumlar`
  ADD PRIMARY KEY (`DurumID`),
  ADD UNIQUE KEY `DurumAdi` (`DurumAdi`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`KategoriID`),
  ADD KEY `idx_kategori_adi` (`KategoriAdi`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`KullaniciID`),
  ADD UNIQUE KEY `Eposta` (`Eposta`),
  ADD KEY `BirimID` (`BirimID`),
  ADD KEY `idx_kullanici_eposta` (`Eposta`),
  ADD KEY `idx_kullanici_rol` (`RolID`);

--
-- Tablo için indeksler `roller`
--
ALTER TABLE `roller`
  ADD PRIMARY KEY (`RolID`),
  ADD UNIQUE KEY `RolAdi` (`RolAdi`);

--
-- Tablo için indeksler `yanitlar`
--
ALTER TABLE `yanitlar`
  ADD PRIMARY KEY (`YanitID`),
  ADD KEY `YanitlayanID` (`YanitlayanID`),
  ADD KEY `idx_yanit_basvuru` (`BasvuruID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `basvurular`
--
ALTER TABLE `basvurular`
  MODIFY `BasvuruID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `birimler`
--
ALTER TABLE `birimler`
  MODIFY `BirimID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `durumlar`
--
ALTER TABLE `durumlar`
  MODIFY `DurumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `KategoriID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `KullaniciID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `roller`
--
ALTER TABLE `roller`
  MODIFY `RolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `yanitlar`
--
ALTER TABLE `yanitlar`
  MODIFY `YanitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `basvurular`
--
ALTER TABLE `basvurular`
  ADD CONSTRAINT `basvurular_ibfk_1` FOREIGN KEY (`KullaniciID`) REFERENCES `kullanicilar` (`KullaniciID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `basvurular_ibfk_2` FOREIGN KEY (`KategoriID`) REFERENCES `kategoriler` (`KategoriID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `basvurular_ibfk_3` FOREIGN KEY (`BirimID`) REFERENCES `birimler` (`BirimID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `basvurular_ibfk_4` FOREIGN KEY (`DurumID`) REFERENCES `durumlar` (`DurumID`) ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `kullanicilar_ibfk_1` FOREIGN KEY (`RolID`) REFERENCES `roller` (`RolID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kullanicilar_ibfk_2` FOREIGN KEY (`BirimID`) REFERENCES `birimler` (`BirimID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `yanitlar`
--
ALTER TABLE `yanitlar`
  ADD CONSTRAINT `yanitlar_ibfk_1` FOREIGN KEY (`BasvuruID`) REFERENCES `basvurular` (`BasvuruID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yanitlar_ibfk_2` FOREIGN KEY (`YanitlayanID`) REFERENCES `kullanicilar` (`KullaniciID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
