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
      <button class="hamburger">☰</button>
      <span class="header-title">Kampüs Çözüm Merkezi</span>
    </a>
    <div class="header-right">
      <div class="user-dropdown">
        <div class="header-user">
          <div class="avatar">KV</div>
          <?php echo $_SESSION['ad_soyad']; ?> ▾
        </div>
        <div class="dropdown-content">
          <a href="index.php?controller=kullanici&action=basvurularim">📋 Başvurularım</a>
          <a href="index.php?controller=kullanici&action=yeniBasvuru">✏️ Yeni Başvuru</a>
          <a href="index.php?controller=kullanici&action=profil">👤 Profilim</a>
          <a href="index.php?controller=auth&action=logout" style="border-top: 1px solid var(--border); color: #dc3545;">🚪 Çıkış Yap</a>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="layout">
  <aside>
    <a href="index.php?controller=kullanici&action=ogrenciPaneli" class="sidebar-logo" style="text-decoration: none;">
      <div class="logo-sm">FÜ</div>
      <span>Kampüs Çözüm<br/>Merkezi</span>
    </a>
    <nav>
      <a href="index.php?controller=kullanici&action=ogrenciPaneli">
        <span class="icon">🏠</span> Ana Sayfa
      </a>
      <a href="index.php?controller=kullanici&action=basvurularim">
        <span class="icon">📋</span> Başvurularım
      </a>
      <a href="index.php?controller=kullanici&action=yeniBasvuru" class="active">
        <span class="icon">✏️</span> Yeni Başvuru
      </a>
    </nav>
  </aside>

  <div class="content">
    <div class="page-title">YENİ BAŞVURU</div>

    <div class="card">
      <form id="basvuruForm" method="POST" action="index.php?controller=basvuru&action=kaydet">
        
        <?php if(isset($data['mesaj'])): ?>
            <div style="padding: 12px; margin-bottom: 15px; border-radius: 5px; color: white; font-weight: bold; background-color: <?php echo $data['tur'] == 'basari' ? '#10B981' : '#EF4444'; ?>">
                <?php echo $data['mesaj']; ?>
            </div>
        <?php endif; ?>

        <div class="form-group full" style="margin-bottom:1.2rem;">
          <label>Başlık (Baslik)</label>
          <input type="text" name="baslik" id="title" placeholder="Talebinizin başlığını yazın..." required />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Kategori (KategoriID)</label>
            <select name="kategori_id" id="category" required>
              <option value="">Kategori Seçiniz</option>
              <option value="1">Altyapı ve İnternet Sorunları</option>
              <option value="2">Ders Kayıtları ve Harç İşlemleri</option>
              <option value="3">Yemekhane ve Beslenme Hizmetleri</option>
              <option value="4">Kütüphane ve Çalışma Alanları</option>
              <option value="5">Kulüp Faaliyetleri ve Etkinlikler</option>
            </select>
          </div>
          <div class="form-group">
            <label>İlgili Birim (BirimID)</label>
            <select name="birim_id" id="department" required>
              <option value="">Birim Seçiniz</option>
              <option value="1">Bilgi İşlem Daire Başkanlığı</option>
              <option value="2">Öğrenci İşleri Daire Başkanlığı</option>
              <option value="3">Mühendislik Fakültesi Dekanlığı</option>
              <option value="4">Sağlık, Kültür ve Spor Daire Bşk. (SKS)</option>
              <option value="5">Kütüphane ve Dokümantasyon Daire Bşk.</option>
            </select>
          </div>
        </div>
        <div class="form-group full" style="margin-bottom:1.2rem;">
          <label>Açıklama (Aciklama)</label>
          <textarea name="aciklama" id="description" placeholder="Sorununuzu detaylı açıklayın..." required></textarea>
        </div>
        <button type="submit" class="submit-btn">BAŞVURUYU GÖNDER</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>