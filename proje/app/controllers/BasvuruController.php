<?php
// app/controllers/BasvuruController.php

class BasvuruController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['kullanici_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    // Formdan gelen verileri alıp veritabanına kaydeden metod
    public function kaydet() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $baslik = trim($_POST['baslik']);
            $kategori_id = $_POST['kategori_id'];
            $birim_id = $_POST['birim_id'];
            $aciklama = trim($_POST['aciklama']);
            $kullanici_id = $_SESSION['kullanici_id'];

            if(empty($baslik) || empty($kategori_id) || empty($birim_id) || empty($aciklama)) {
                $this->view('yeni_basvuru', ['mesaj' => 'Lütfen tüm alanları doldurun.', 'tur' => 'hata']);
                return;
            }

            $basvuruModel = $this->model('BasvuruModel');
            
            if ($basvuruModel->basvuruEkle($kullanici_id, $kategori_id, $birim_id, $baslik, $aciklama)) {
                $this->view('yeni_basvuru', ['mesaj' => 'Başvurunuz başarıyla oluşturuldu! Başvurularım sekmesinden takip edebilirsiniz.', 'tur' => 'basari']);
            } else {
                $this->view('yeni_basvuru', ['mesaj' => 'Kayıt sırasında bir hata oluştu.', 'tur' => 'hata']);
            }
        }
    }

    // Yeni Başvuru Sayfasını Yükleyen Metod
    public function yeniBasvuru() {
        // Formda olası hata/başarı mesajları için boş bir dizi gönderiyoruz
        $this->view('yeni_basvuru');
    }

    // Başvuru detaylarını ve mesajları gösteren metod
    public function detay() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=kullanici&action=basvurularim");
            exit();
        }

        $basvuru_id = $_GET['id'];
        $basvuruModel = $this->model('BasvuruModel');
        $yanitModel = $this->model('YanitModel');

        // Başvuru bilgilerini çek (Önceki yazdığımız metodun tekli versiyonu gibi düşünebilirsin)
        // Not: BasvuruModel'e tekli çekme metodu eklememiz gerekecek.
        $basvuru = $basvuruModel->basvuruDetayGetir($basvuru_id);
        $yanitlar = $yanitModel->yanitlariGetir($basvuru_id);

        $this->view('BasvuruDetay', [
            'basvuru' => $basvuru,
            'yanitlar' => $yanitlar
        ]);
    }

    // Mesaj gönderme metodu
    public function yanitGonder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $basvuru_id = $_POST['basvuru_id'];
            $icerik = trim($_POST['icerik']);
            $yanitlayan_id = $_SESSION['kullanici_id'];

            if (!empty($icerik)) {
                $yanitModel = $this->model('YanitModel');
                $yanitModel->yanitEkle($basvuru_id, $yanitlayan_id, $icerik);
            }
            
            header("Location: index.php?controller=basvuru&action=detay&id=" . $basvuru_id);
        }
    }

    public function durumDegistir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['rol'] == 'Personel') {
            $basvuru_id = $_POST['basvuru_id'];
            $yeni_durum_id = $_POST['durum_id'];

            $basvuruModel = $this->model('BasvuruModel');
            $basvuruModel->durumGuncelle($basvuru_id, $yeni_durum_id);

            // İşlem bitince tekrar detay sayfasına dön
            header("Location: index.php?controller=basvuru&action=detay&id=" . $basvuru_id);
            exit();
        }
    }
}