<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Öğrenci Paneli — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/index.css" />
  <style>
    .dashboard-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-top: 20px; }
    .dash-card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .stat-row { display: flex; gap: 15px; margin-top: 15px; }
    .stat-box { flex: 1; padding: 15px; border-radius: 8px; text-align: center; border-bottom: 4px solid #ddd; background: #f8f9fa; }
    .stat-box h4 { margin: 0; color: #666; font-size: 0.9rem; }
    .stat-box p { margin: 5px 0 0 0; font-size: 1.5rem; font-weight: 800; color: #1a3a6b; }
    .last-ticket { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #1a3a6b; margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }
  </style>
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
          <a href="index.php?controller=kullanici&action=profil">👤 Profilim</a>
          <a href="index.php?controller=kullanici&action=basvurularim">📋 Başvurularım</a>
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
      <a href="index.php?controller=kullanici&action=ogrenciPaneli" class="active"><span class="icon">🏠</span> Ana Sayfa</a>
      <a href="index.php?controller=kullanici&action=basvurularim"><span class="icon">📋</span> Başvurularım</a>
      <a href="index.php?controller=kullanici&action=yeniBasvuru"><span class="icon">✏️</span> Yeni Başvuru</a>
      <a href="index.php?controller=kullanici&action=profil"><span class="icon">👤</span> Profilim</a>
    </nav>
  </aside>

  <div class="content">
    <div class="header-content" style="margin-bottom: 10px;">
      <h1>Hoş Geldin, <?php echo explode(' ', $_SESSION['ad_soyad'])[0]; ?> 👋</h1>
      <p>Kampüs Çözüm Merkezi'ne hoş geldin. Buradan taleplerini yönetebilir ve durumlarını takip edebilirsin.</p>
    </div>

    <div class="dashboard-grid">
        
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="dash-card" style="text-align:center;">
                <div style="width:70px; height:70px; background:#1a3a6b; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:bold; margin:0 auto 15px auto;">
                    <?php echo mb_substr($_SESSION['ad_soyad'], 0, 1); ?>
                </div>
                <h3 style="margin:0; color:#333;"><?php echo $_SESSION['ad_soyad']; ?></h3>
                <p style="color:#666; font-size:0.9rem; margin-top:5px;">Öğrenci Hesabı</p>
                <a href="index.php?controller=kullanici&action=profil" style="display:inline-block; margin-top:10px; background:#f0f0f0; color:#333; padding:8px 15px; border-radius:20px; text-decoration:none; font-size:0.85rem; font-weight:bold;">Profili Düzenle</a>
            </div>

            <a href="index.php?controller=kullanici&action=yeniBasvuru" style="background:#10b981; color:white; text-align:center; padding:20px; border-radius:12px; text-decoration:none; font-weight:bold; font-size:1.1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition:transform 0.2s;">
                + YENİ DESTEK TALEBİ AÇ
            </a>
        </div>

        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="dash-card">
                <h3 style="margin-top:0; border-bottom:2px solid #f0f0f0; padding-bottom:10px;">Taleplerimin Özeti</h3>
                <div class="stat-row">
                    <div class="stat-box" style="border-color:#1a3a6b;">
                        <h4>Toplam Talep</h4>
                        <p><?php echo $data['istatistik']['Toplam'] ?? 0; ?></p>
                    </div>
                    <div class="stat-box" style="border-color:#f59e0b;">
                        <h4>Devam Eden</h4>
                        <p style="color:#f59e0b;"><?php echo $data['istatistik']['DevamEden'] ?? 0; ?></p>
                    </div>
                    <div class="stat-box" style="border-color:#10b981;">
                        <h4>Çözülen</h4>
                        <p style="color:#10b981;"><?php echo $data['istatistik']['Cozuldu'] ?? 0; ?></p>
                    </div>
                </div>
            </div>

            <div class="dash-card">
                <h3 style="margin-top:0; border-bottom:2px solid #f0f0f0; padding-bottom:10px;">Son Aktivitem</h3>
                <?php if(!empty($data['son_basvuru'])): ?>
                    <div class="last-ticket" style="border-left-color: <?php echo $data['son_basvuru']['RenkKodu']; ?>;">
                        <div>
                            <strong style="color:#333;">#<?php echo $data['son_basvuru']['BasvuruID']; ?> - <?php echo htmlspecialchars($data['son_basvuru']['Baslik']); ?></strong>
                            <div style="font-size:0.85rem; color:#666; margin-top:5px;">Oluşturulma: <?php echo date('d.m.Y', strtotime($data['son_basvuru']['OlusturulmaTarihi'])); ?></div>
                        </div>
                        <div style="text-align:right;">
                            <span style="background:<?php echo $data['son_basvuru']['RenkKodu']; ?>; color:white; padding:5px 12px; border-radius:20px; font-size:0.85rem; font-weight:bold;">
                                <?php echo $data['son_basvuru']['DurumAdi']; ?>
                            </span>
                            <br>
                            <a href="index.php?controller=basvuru&action=detay&id=<?php echo $data['son_basvuru']['BasvuruID']; ?>" style="display:inline-block; margin-top:8px; font-size:0.85rem; color:#1a3a6b; font-weight:bold; text-decoration:none;">İncele ➔</a>
                        </div>
                    </div>
                <?php else: ?>
                    <p style="color:#666; font-style:italic;">Henüz oluşturulmuş bir destek talebiniz bulunmuyor.</p>
                <?php endif; ?>
                <div style="text-align:right; margin-top:15px;">
                    <a href="index.php?controller=kullanici&action=basvurularim" style="color:#1a3a6b; font-weight:bold; text-decoration:none;">Tüm Taleplerimi Gör</a>
                </div>
            </div>
        </div>

    </div>
  </div>
</div>
</body>
</html>