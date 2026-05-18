<?php
// public/index.php

// Oturum (Session) işlemlerini başlatıyoruz
session_start();

// Gerekli çekirdek dosyaları dahil edelim
require_once '../config/config.php';
require_once '../app/core/Controller.php';

// URL'den gelen controller ve action değerlerini alıyoruz.
$controllerParam = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'login';

// Controller sınıfı ismini oluştur (Örn: auth -> AuthController)
$controllerName = ucfirst($controllerParam) . 'Controller';

// Controller dosyasının yolu
$controllerFile = '../app/controllers/' . $controllerName . '.php';

// Controller dosyası var mı diye kontrol et
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    $controller = new $controllerName();
    
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        die("Hata: <b>{$actionName}</b> metodu <b>{$controllerName}</b> içinde bulunamadı.");
    }
} else {
    die("Hata: <b>{$controllerName}</b> dosyası bulunamadı.");
}