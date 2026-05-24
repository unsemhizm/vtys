<?php
class YanitModel {
    private $db;
    public function __construct() { global $db; $this->db = $db; }

    public function yanitlariGetir($basvuru_id) {
        $sql = "SELECT y.*, k.AdSoyad, r.RolAdi 
                FROM yanitlar y
                INNER JOIN kullanicilar k ON y.YanitlayanID = k.KullaniciID
                INNER JOIN roller r ON k.RolID = r.RolID
                WHERE y.BasvuruID = :id ORDER BY y.GonderilmeTarihi ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $basvuru_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function yanitEkle($basvuru_id, $yanitlayan_id, $mesaj) {
        $sql = "INSERT INTO yanitlar (BasvuruID, YanitlayanID, Mesaj) VALUES (:bid, :yid, :msg)";
        return $this->db->prepare($sql)->execute([
            ':bid' => $basvuru_id, ':yid' => $yanitlayan_id, ':msg' => $mesaj
        ]);
    }

    public function mesajlariOkunduYap($basvuru_id, $kullanici_id) {
        $sql = "UPDATE yanitlar SET Okundu = 1 WHERE BasvuruID = :basvuru_id AND YanitlayanID != :kullanici_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':basvuru_id' => $basvuru_id,
            ':kullanici_id' => $kullanici_id
        ]);
    }
}