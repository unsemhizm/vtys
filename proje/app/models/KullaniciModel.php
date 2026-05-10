<?php
// app/models/KullaniciModel.php

class KullaniciModel {
    private $db;

    public function __construct() {
        // config.php'deki $db nesnesini kullanabilmek için global değişkeni çekiyoruz
        global $db;
        $this->db = $db;
    }

    // E-posta adresine göre kullanıcıyı (ve rolünü) getiren metod
    public function kullaniciGetirEposta($eposta) {
        $sql = "SELECT k.*, r.RolAdi 
                FROM Kullanicilar k 
                INNER JOIN Roller r ON k.RolID = r.RolID 
                WHERE k.Eposta = :eposta";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':eposta', $eposta);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Bulunan veriyi dizi olarak döndürür
    }
}