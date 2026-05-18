<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personel Paneli — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/personel_paneli.css" />
</head>
<body>

<header>
  <div class="header-inner">
    <div style="display:flex;align-items:center;gap:10px;">
      <span class="header-title">Kampüs Çözüm Merkezi — Personel Paneli</span>
    </div>
    <div class="header-right">
      <div class="user-dropdown">
        <div class="header-user">
          <div class="avatar" style="background: var(--primary);">P</div>
          <?php echo $_SESSION['ad_soyad']; ?> ▾
        </div>
        <div class="dropdown-content">
          <a href="index.php?controller=kullanici&action=profil">👤 Profil Ayarlarım</a>
          <a href="index.php?controller=auth&action=logout" style="color: #dc3545;">🚪 Güvenli Çıkış</a>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="layout">
  <aside>
    <div class="sidebar-logo">
      <div class="logo-sm">FÜ</div>
      <span>Personel<br/>Paneli</span>
    </div>
    <nav>
      <a href="index.php?controller=kullanici&action=personelPaneli" class="active"><span class="icon">🏠</span> Ana Sayfa</a>
      <a href="index.php?controller=auth&action=logout"><span class="icon">🚪</span> Çıkış Yap</a>
    </nav>
  </aside>

  <div class="content">
    <div class="header-content">
      <h1>Hoş Geldin, <?php echo $_SESSION['ad_soyad']; ?></h1>
      <p>Biriminize gelen son talepler aşağıdadır.</p>
    </div>

    <div class="ticket-list">
      <?php if(empty($data['basvurular'])): ?>
          <div class="card" style="text-align:center; padding:20px;">Henüz bekleyen bir başvuru bulunmuyor.</div>
      <?php else: ?>
          <?php foreach($data['basvurular'] as $b): ?>
          <div class="ticket-card">
            <div class="ticket-header">
              <span class="ticket-id">#<?php echo $b['BasvuruID']; ?></span>
              <span class="status-badge" style="background: <?php echo $b['RenkKodu']; ?>; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;">
                  <?php echo $b['DurumAdi']; ?>
              </span>
            </div>
            <h3 class="ticket-title"><?php echo $b['Baslik']; ?></h3>
            <div class="ticket-info">
              <span>👤 <?php echo $b['AdSoyad']; ?></span>
              <span>📅 <?php echo date('d.m.Y', strtotime($b['OlusturulmaTarihi'])); ?></span>
              <span>📂 <?php echo $b['KategoriAdi']; ?></span>
            </div>
            <a href="index.php?controller=basvuru&action=detay&id=<?php echo $b['BasvuruID']; ?>" class="view-btn">Detayı Gör ve Yanıtla</a>
          </div>
          <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>