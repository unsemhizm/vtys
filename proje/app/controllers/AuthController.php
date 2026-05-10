<?php
// app/controllers/AuthController.php

class AuthController extends Controller {
    
    public function login() {
        // Eğer formdan POST isteği geldiyse (Giriş Yap butonuna basıldıysa)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Formdan gelen verileri al ve temizle
            $eposta = trim($_POST['eposta']);
            $sifre = trim($_POST['sifre']);
            $beklenen_rol = $_POST['rol']; // 'student', 'staff' veya 'admin'

            // Hata mesajlarını tutacağımız değişken
            $hata = "";

            // Boş alan kontrolü
            if (empty($eposta) || empty($sifre)) {
                $hata = "Lütfen e-posta ve şifrenizi giriniz.";
            } else {
                // Modeli yükle
                $kullaniciModel = $this->model('KullaniciModel');
                
                // Veritabanında bu e-postaya sahip kullanıcıyı bul
                $kullanici = $kullaniciModel->kullaniciGetirEposta($eposta);

                if ($kullanici) {
                    // Kullanıcı bulundu, şifreyi doğrula
                    // Veritabanı scriptindeki şifreler "sifre123" olarak hashlenmiş
                    if (password_verify($sifre, $kullanici['Sifre'])) {
                        
                        // Formdan seçilen sekmeyle veritabanındaki rol uyuşuyor mu?
                        $rol_uyusuyor_mu = false;
                        if ($beklenen_rol == 'student' && $kullanici['RolAdi'] == 'Öğrenci') $rol_uyusuyor_mu = true;
                        if ($beklenen_rol == 'staff' && $kullanici['RolAdi'] == 'Personel') $rol_uyusuyor_mu = true;
                        if ($beklenen_rol == 'admin' && $kullanici['RolAdi'] == 'Admin') $rol_uyusuyor_mu = true;

                        if ($rol_uyusuyor_mu) {
                            // Şifre ve rol doğru, oturumu (SESSION) başlat
                            $_SESSION['kullanici_id'] = $kullanici['KullaniciID'];
                            $_SESSION['ad_soyad'] = $kullanici['AdSoyad'];
                            $_SESSION['rol'] = $kullanici['RolAdi'];
                            $_SESSION['birim_id'] = $kullanici['BirimID'];

                            // Rolüne göre ilgili paneline yönlendir
                            if ($kullanici['RolAdi'] == 'Öğrenci') {
                                header("Location: index.php?controller=kullanici&action=ogrenciPaneli");
                            } elseif ($kullanici['RolAdi'] == 'Personel') {
                                header("Location: index.php?controller=kullanici&action=personelPaneli");
                            } elseif ($kullanici['RolAdi'] == 'Admin') {
                                header("Location: index.php?controller=admin&action=index");
                            }
                            exit();
                        } else {
                            $hata = "Bu sekmeye giriş yetkiniz yok. Lütfen doğru rol sekmesini seçin.";
                        }
                    } else {
                        $hata = "Hatalı şifre girdiniz.";
                    }
                } else {
                    $hata = "Bu e-posta adresiyle kayıtlı bir kullanıcı bulunamadı.";
                }
            }

            // Hata varsa view'a gönder
            $this->view('login', ['hata' => $hata]);
            return;
        }

        // Eğer POST isteği yoksa (sayfa ilk defa açıldıysa) sadece login ekranını göster
        $this->view('login');
    }

    // Çıkış yapma işlemi
    public function logout() {
        session_destroy();
        // Çıkış yaptıktan sonra logine geri dönmeli:
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
}