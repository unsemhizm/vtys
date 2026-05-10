<?php
// Bu sınıf diğer tüm controllerlar için temel (base) sınıftır.
class Controller {
    
    // Model dosyasını yükler ve nesnesini döndürür
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    // View (Görünüm) dosyasını yükler ve verileri (data) aktarır
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("Hata: View dosyası bulunamadı: " . $view);
        }
    }
}