<?php
// app/controllers/KullaniciController.php

class KullaniciController extends Controller {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['kullanici_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    public function ogrenciPaneli() {
        if ($_SESSION['rol'] != 'Öğrenci') {
            header("Location: index.php?controller=kullanici&action=personelPaneli");
            exit();
        }
        
        $basvuruModel = $this->model('BasvuruModel');
        $id = $_SESSION['kullanici_id'];
        
        $data = [
            'istatistik'         => $basvuruModel->ogrenciIstatistikleri($id),
            'detayli_istatistik' => $basvuruModel->ogrenciDetayliIstatistik($id),
            'kategori_dagilimi'  => $basvuruModel->ogrenciKategoriDagilimi($id),
            'son_talepler'       => $basvuruModel->ogrenciSonTalepler($id),
            'son_basvuru'        => $basvuruModel->ogrenciSonBasvuru($id),
        ];
        
        $this->view('ogrenci_anasayfa', $data);
    }

    public function personelPaneli() {
        if ($_SESSION['rol'] != 'Personel') {
            header("Location: index.php?controller=kullanici&action=ogrenciPaneli");
            exit();
        }
        $birim_id = $_SESSION['birim_id']; 
        $basvuruModel = $this->model('BasvuruModel');

        $data = [
            'basvurular'       => $basvuruModel->birimBasvurulariniGetir($birim_id, $_SESSION['kullanici_id']),
            'istatistikler'    => $basvuruModel->personelIstatistikleri($birim_id),
            'kategori_dagilimi'=> $basvuruModel->personelKategoriDagilimi($birim_id),
        ];

        $this->view('personel_paneli', $data);
    }

    public function basvurularim() {
        $kullanici_id = $_SESSION['kullanici_id'];
        $basvuruModel = $this->model('BasvuruModel');
        $basvurular = $basvuruModel->ogrenciBasvurulariniGetir($kullanici_id);

        $this->view('basvurularim', ['basvurular' => $basvurular]);
    }

    public function yeniBasvuru() {
        if ($_SESSION['rol'] != 'Öğrenci') {
            die("Sadece öğrenciler başvuru oluşturabilir.");
        }
        $basvuruModel = $this->model('BasvuruModel');
        $data = [
            'kategoriler' => $basvuruModel->tumKategorileriGetir(),
            'birimler'    => $basvuruModel->tumBirimleriGetir()
        ];
        $this->view('yeni_basvuru', $data);
    }

    // --- YENİ KULLANICI PROFİL ÖZELLİĞİ ---
    public function profil() {
        $kullaniciModel = $this->model('KullaniciModel');
        $mesaj = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $updateData = [
                'kullanici_id' => $_SESSION['kullanici_id'],
                'ad_soyad'     => trim($_POST['ad_soyad']),
                'eposta'       => trim($_POST['eposta']),
                'sifre'        => !empty($_POST['sifre']) ? $_POST['sifre'] : '',
                'rol_id'       => $_SESSION['rol'] == 'Öğrenci' ? 1 : ($_SESSION['rol'] == 'Personel' ? 2 : 3),
                'birim_id'     => isset($_SESSION['birim_id']) ? $_SESSION['birim_id'] : null
            ];

            if ($kullaniciModel->kullaniciGuncelle($updateData)) {
                $_SESSION['ad_soyad'] = $updateData['ad_soyad'];
                $mesaj = '<div style="background:#10b981; color:white; padding:10px; border-radius:6px; margin-bottom:15px;">Profiliniz başarıyla güncellendi!</div>';
            } else {
                $mesaj = '<div style="background:#ef4444; color:white; padding:10px; border-radius:6px; margin-bottom:15px;">Güncelleme sırasında bir hata oluştu.</div>';
            }
        }

        $user = $kullaniciModel->kullaniciGetirId($_SESSION['kullanici_id']);
        $this->view('KullaniciProfil', ['user' => $user, 'mesaj' => $mesaj]);
    }
}