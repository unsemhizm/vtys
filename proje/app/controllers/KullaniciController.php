<?php
// app/controllers/KullaniciController.php

class KullaniciController extends Controller {

    // Kurucu metod: Bu controller'a gelen herkesin giriş yapmış olması lazım!
    public function __construct() {
        if (!isset($_SESSION['kullanici_id'])) {
            // Giriş yapmamışsa logine geri gönder
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    // Öğrenci Anasayfasını Yükleyen Metod
    public function ogrenciPaneli() {
        // Güvenlik: Sadece rolü "Öğrenci" olanlar girebilir
        if ($_SESSION['rol'] != 'Öğrenci') {
            die("Hata: Bu sayfaya erişim yetkiniz yok.");
        }

        // View'ı çağır
        $this->view('ogrenci_anasayfa');
    }

    // Personel Anasayfasını Yükleyen Metod
    public function personelPaneli() {
        // Güvenlik: Sadece rolü "Personel" olanlar girebilir
        if ($_SESSION['rol'] != 'Personel') {
            die("Hata: Bu sayfaya erişim yetkiniz yok.");
        }

        // View'ı çağır
        $this->view('personel_paneli');
    }

    // Başvurularım Sayfasını Yükleyen Metod (EKSİK OLAN KISIM)
    public function basvurularim() {
        $kullanici_id = $_SESSION['kullanici_id'];

        // Modeli yükle ve verileri çek
        $basvuruModel = $this->model('BasvuruModel');
        $basvurular = $basvuruModel->ogrenciBasvurulariniGetir($kullanici_id);

        // Verileri view (görünüm) dosyasına gönder
        $this->view('basvurularim', ['basvurular' => $basvurular]);
    }

    // Yeni Başvuru Sayfasını Yükleyen Metod
    public function yeniBasvuru() {
        $this->view('yeni_basvuru');
    }
}