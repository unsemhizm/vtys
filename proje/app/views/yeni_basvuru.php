<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Yeni Başvuru — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/yeni_basvuru.css" />
</head>
<body>

<header>
  <div class="header-inner">
    <a href="index.php?controller=kullanici&action=ogrenciPaneli" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;">
      <span class="header-title">Kampüs Çözüm Merkezi</span>
    </a>
    <div class="header-right">
      <div class="user-dropdown">
        <div class="header-user">
          <div class="avatar">Ö</div>
          <?php echo $_SESSION['ad_soyad']; ?> ▾
        </div>
        <div class="dropdown-content">
          <a href="index.php?controller=kullanici&action=basvurularim">📋 Başvurularım</a>
          <a href="index.php?controller=kullanici&action=yeniBasvuru">✏️ Yeni Başvuru</a>
          <a href="index.php?controller=auth&action=logout" style="border-top: 1px solid var(--border); color: #dc3545;">🚪 Çıkış Yap</a>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="layout">
  <aside>
    <div class="sidebar-logo">
      <div class="logo-sm">FÜ</div>
      <span>Öğrenci<br/>Paneli</span>
    </div>
    <nav>
      <a href="index.php?controller=kullanici&action=ogrenciPaneli"><span class="icon">🏠</span> Ana Sayfa</a>
      <a href="index.php?controller=kullanici&action=basvurularim"><span class="icon">📋</span> Başvurularım</a>
      <a href="index.php?controller=kullanici&action=yeniBasvuru" class="active"><span class="icon">✏️</span> Yeni Başvuru</a>
    </nav>
  </aside>

  <div class="content">
    <div style="margin-bottom: 15px;">
        <a href="index.php?controller=kullanici&action=ogrenciPaneli" style="text-decoration: none; color: var(--primary); font-weight: bold;">
            <i class="fas fa-chevron-left"></i> Ana Sayfaya Dön
        </a>
    </div>

    <?php if(!isset($data) || !isset($data['kategoriler'])): ?>
        <div style="background:#ef4444; color:white; padding:15px; border-radius:8px; margin-bottom:20px; box-shadow:0 4px 6px rgba(0,0,0,0.1);">
            <strong>🚨 SİSTEM UYARISI (HATA TESPİT EDİLDİ):</strong><br>
            Şu anda bu sayfaya <u>yanlış bir linkten</u> (doğrudan .php dosyasına tıklayarak) giriyorsunuz. MVC yapısında dosyalar doğrudan açılamaz.<br><br>
            <strong>Çözüm:</strong> Lütfen adres çubuğuna şu linki yapıştırarak girin:<br>
            <code>http://localhost/vtys/proje/public/index.php?controller=kullanici&action=yeniBasvuru</code>
        </div>
    <?php endif; ?>
    <div class="page-title">YENİ DESTEK TALEBİ OLUŞTUR</div>

    <?php if(isset($data['mesaj'])): ?>
        <div style="background:<?php echo $data['tur'] == 'basari' ? '#10b981' : '#ef4444'; ?>; color:white; padding:15px; border-radius:8px; margin-bottom:20px; box-shadow:0 4px 6px rgba(0,0,0,0.1); font-weight:bold;">
            <?php echo $data['mesaj']; ?>
        </div>
    <?php endif; ?>

    <div class="card" style="max-width: 800px;">
      <h2 class="card-title">Başvuru Formu</h2>
      
      <form action="index.php?controller=basvuru&action=kaydet" method="POST">
        <div class="form-row">
          
          <div class="form-group">
            <label>Sorunun Kategorisi</label>
            <select name="kategori_id" required>
              <option value="">-- Kategori Seçiniz --</option>
              <?php 
              if(isset($data['kategoriler']) && count($data['kategoriler']) > 0) {
                  foreach($data['kategoriler'] as $kat) {
                      echo '<option value="'.$kat['KategoriID'].'">'.htmlspecialchars($kat['KategoriAdi']).'</option>';
                  }
              } elseif(isset($data['kategoriler'])) {
                  echo '<option value="" disabled>⚠️ DİKKAT: Veritabanında (kategoriler) tablosu BOŞ!</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>İlgili İdari Birim / Fakülte</label>
            <select name="birim_id" required>
              <option value="">-- Birim Seçiniz --</option>
              <?php 
              if(isset($data['birimler']) && count($data['birimler']) > 0) {
                  foreach($data['birimler'] as $birim) {
                      echo '<option value="'.$birim['BirimID'].'">'.htmlspecialchars($birim['BirimAdi']).'</option>';
                  }
              } elseif(isset($data['birimler'])) {
                  echo '<option value="" disabled>⚠️ DİKKAT: Veritabanında (birimler) tablosu BOŞ!</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group full">
            <label>Konu / Başlık</label>
            <input type="text" name="baslik" placeholder="Sorununuzu veya talebinizi birkaç kelime ile özetleyin..." required />
          </div>

          <div class="form-group full">
            <label>Detaylı Açıklama</label>
            <textarea name="aciklama" placeholder="Lütfen sorununuzu tüm detaylarıyla ve anlaşılır bir dille anlatın..." required style="min-height:150px;"></textarea>
          </div>
        </div>

        <div style="margin-top: 1.5rem; text-align: right;">
          <button type="submit" class="btn-primary" style="padding: 10px 25px; font-size: 1rem; cursor:pointer;">Talebi Gönder</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>