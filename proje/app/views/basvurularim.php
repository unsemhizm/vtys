<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Başvurularım — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/basvurularim.css" />
  <link rel="stylesheet" href="css/index.css" />
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
          <a href="index.php?controller=kullanici&action=profil">👤 Profil Ayarlarım</a>
          <a href="index.php?controller=kullanici&action=basvurularim">📋 Başvurularım</a>
          <a href="index.php?controller=basvuru&action=yeniBasvuru">✏️ Yeni Başvuru</a>
          <a href="index.php?controller=auth&action=logout" style="border-top: 1px solid var(--border); color: #dc3545;">🚪 Çıkış Yap</a>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="back-button-container">
  <a href="index.php?controller=kullanici&action=ogrenciPaneli" class="back-button" onclick="if(history.length > 1){ history.back(); return false; }">← Önceki Sayfaya Dön</a>
</div>

<div class="layout">
  <aside>
    <nav>
      <a href="index.php?controller=kullanici&action=ogrenciPaneli"><span class="icon">🏠</span> Ana Sayfa</a>
      <a href="index.php?controller=kullanici&action=basvurularim" class="active"><span class="icon">📋</span> Başvurularım</a>
      <a href="index.php?controller=basvuru&action=yeniBasvuru"><span class="icon">✏️</span> Yeni Başvuru</a>  
    </nav>
  </aside>

  <div class="content">
    <div class="page-title">BAŞVURULARIM</div>

    <div class="ticket-list">
      <?php if(!empty($data['basvurular'])): ?>
        <?php foreach($data['basvurular'] as $basvuru): ?>
          <div class="ticket-card">
            <div class="ticket-info">
              <div class="ticket-top">
                <span class="ticket-id">#<?php echo $basvuru['BasvuruID']; ?></span>
                <span class="badge" style="background:<?php echo $basvuru['RenkKodu']; ?>;color:white;">
                    <?php echo $basvuru['DurumAdi']; ?>
                </span>
              </div>
              <div class="ticket-title"><?php echo $basvuru['Baslik']; ?></div>
              <div class="ticket-meta">
                <?php echo $basvuru['KategoriAdi']; ?> · <?php echo $basvuru['BirimAdi']; ?> · <?php echo date('d.m.Y', strtotime($basvuru['OlusturulmaTarihi'])); ?>
              </div>
            </div>
            <a href="index.php?controller=basvuru&action=detay&id=<?php echo $basvuru['BasvuruID']; ?>" class="btn-detail">Detay</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #6B7280;">Henüz bir başvurunuz bulunmamaktadır.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<div style="margin-bottom: 20px;">
    <a href="index.php?controller=kullanici&action=ogrenciPaneli" class="btn-sm" style="background: var(--primary-dark); text-decoration: none;">
        ← Panele Dön
    </a>
</div>
</body>
</html>