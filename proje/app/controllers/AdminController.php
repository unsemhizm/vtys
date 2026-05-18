<?php
// app/controllers/AdminController.php

class AdminController extends Controller {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['kullanici_id']) || $_SESSION['rol'] != 'Admin') {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }

    public function index() {
        $basvuruModel = $this->model('BasvuruModel');
        $kullaniciModel = $this->model('KullaniciModel');

        $data = [
            'toplam_bilet'    => $basvuruModel->toplamBiletSayisi(),
            'cozulen_bilet'   => $basvuruModel->cozulenBiletSayisi(),
            'acik_bilet'      => $basvuruModel->durumSayisiGetir(1),
            'incelenen_bilet' => $basvuruModel->durumSayisiGetir(2),
            'red_bilet'       => $basvuruModel->durumSayisiGetir(4),
            'son_aktiviteler' => $basvuruModel->sonAktiviteleriGetir(),
            'istatistikler'   => $basvuruModel->getIstatistikler(),
            'birim_analizi'   => $basvuruModel->getBirimAnalizi(),
            'aylik_trend'     => $basvuruModel->aylikBasvuruTrendi(),
            'kullanicilar'    => $kullaniciModel->tumKullanicilariGetir(),
            'basvurular'      => $basvuruModel->tumBasvurulariGetir()
        ];

        $this->view('AdminPanel', $data);
    }

    public function kullaniciKaydet() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model('KullaniciModel')->kullaniciEkle($_POST);
            header("Location: index.php?controller=admin&action=index");
            exit();
        }
    }

    public function kullaniciGuncelle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model('KullaniciModel')->kullaniciGuncelle($_POST);
            header("Location: index.php?controller=admin&action=index");
            exit();
        }
    }

    public function kullaniciSil() {
        if (isset($_GET['id'])) {
            $this->model('KullaniciModel')->kullaniciSil($_GET['id']);
        }
        header("Location: index.php?controller=admin&action=index");
        exit();
    }

    public function basvuruSil() {
        if (isset($_GET['id'])) {
            $this->model('BasvuruModel')->basvuruSil($_GET['id']);
        }
        header("Location: index.php?controller=admin&action=index");
        exit();
    }

    public function hizliDurumGuncelle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model('BasvuruModel')->durumGuncelle($_POST['basvuru_id'], $_POST['durum_id']);
            header("Location: index.php?controller=admin&action=index");
            exit();
        }
    }
}