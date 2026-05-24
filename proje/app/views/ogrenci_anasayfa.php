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
    .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; }
    .stat-card { background:#fff; border-radius:12px; padding:20px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.06); border-top:4px solid #ddd; }
    .stat-card .num { font-size:2rem; font-weight:800; margin:8px 0 4px; }
    .stat-card .label { font-size:0.82rem; color:#888; font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
    .section-card { background:#fff; border-radius:12px; padding:22px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:20px; }
    .section-card h3 { margin:0 0 16px; color:#1a3a6b; font-size:1rem; border-bottom:2px solid #f0f4f8; padding-bottom:10px; }
    .ticket-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f0f4f8; }
    .ticket-row:last-child { border-bottom:none; }
    .ticket-row .t-title { font-weight:600; color:#333; font-size:0.9rem; }
    .ticket-row .t-date { font-size:0.8rem; color:#aaa; margin-top:3px; }
    .badge-sm { padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700; color:white; white-space:nowrap; }
    .progress-bar-wrap { margin-bottom:12px; }
    .progress-bar-wrap .pb-label { display:flex; justify-content:space-between; font-size:0.83rem; margin-bottom:4px; color:#555; font-weight:600; }
    .progress-bar-bg { background:#f0f4f8; border-radius:6px; height:10px; overflow:hidden; }
    .progress-bar-fill { height:100%; border-radius:6px; background:#1a3a6b; transition:width 0.6s ease; }
    .cta-btn { display:block; background:linear-gradient(135deg,#10b981,#059669); color:white; text-align:center; padding:18px; border-radius:12px; text-decoration:none; font-weight:800; font-size:1rem; box-shadow:0 4px 15px rgba(16,185,129,0.3); transition:transform 0.2s, box-shadow 0.2s; }
    .cta-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(16,185,129,0.4); }
    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
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
          <a href="index.php?controller=auth&action=logout" style="border-top:1px solid var(--border);color:#dc3545;">🚪 Çıkış Yap</a>
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
    <div class="header-content" style="margin-bottom:20px;">
      <h1>Hoş Geldin, <?php echo explode(' ', $_SESSION['ad_soyad'])[0]; ?> 👋</h1>
      <p>Aşağıda tüm destek taleplerinizin özeti ve istatistikleri yer almaktadır.</p>
    </div>

    <?php $ist = $data['detayli_istatistik'] ?? []; ?>

    <!-- İSTATİSTİK KARTLARI -->
    <div class="stats-row">
      <div class="stat-card" style="border-color:#1a3a6b;">
        <div class="label">Toplam Talep</div>
        <div class="num" style="color:#1a3a6b;"><?php echo $ist['Toplam'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#f59e0b;">
        <div class="label">Açık</div>
        <div class="num" style="color:#f59e0b;"><?php echo $ist['Acik'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#3b82f6;">
        <div class="label">İnceleniyor</div>
        <div class="num" style="color:#3b82f6;"><?php echo $ist['Inceleniyor'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#10b981;">
        <div class="label">Çözülen</div>
        <div class="num" style="color:#10b981;"><?php echo $ist['Cozuldu'] ?? 0; ?></div>
      </div>
    </div>

    <div class="two-col">
      <!-- SON TALEPLERİM -->
      <div class="section-card">
        <h3>📋 Son Taleplerim</h3>
        <?php if(!empty($data['son_talepler'])): ?>
          <?php foreach($data['son_talepler'] as $t): ?>
            <div class="ticket-row">
              <div>
                <div class="t-title"><?php echo htmlspecialchars(mb_substr($t['Baslik'],0,40)); ?>...</div>
                <div class="t-date"><?php echo date('d.m.Y', strtotime($t['OlusturulmaTarihi'])); ?></div>
              </div>
              <div style="display:flex;align-items:center;gap:8px;">
                <span class="badge-sm" style="background:<?php echo $t['RenkKodu']; ?>;"><?php echo $t['DurumAdi']; ?></span>
                <a href="index.php?controller=basvuru&action=detay&id=<?php echo $t['BasvuruID']; ?>" style="font-size:0.8rem;color:#1a3a6b;font-weight:bold;text-decoration:none;">İncele →</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="color:#aaa;font-style:italic;text-align:center;padding:20px 0;">Henüz talebiniz bulunmuyor.</p>
        <?php endif; ?>
        <div style="text-align:right;margin-top:12px;">
          <a href="index.php?controller=kullanici&action=basvurularim" style="color:#1a3a6b;font-weight:bold;font-size:0.88rem;text-decoration:none;">Tümünü Gör →</a>
        </div>
      </div>

      <!-- KATEGORİ DAĞILIMI -->
      <div class="section-card">
        <h3>📊 Başvurduğum Kategoriler</h3>
        <?php 
          $toplam = $ist['Toplam'] ?? 0;
          if(!empty($data['kategori_dagilimi']) && $toplam > 0):
            foreach($data['kategori_dagilimi'] as $kat):
              $yuzde = round(($kat['Adet'] / $toplam) * 100, 1);
        ?>
          <div class="progress-bar-wrap">
            <div class="pb-label">
              <span><?php echo htmlspecialchars($kat['KategoriAdi']); ?></span>
              <span><?php echo $kat['Adet']; ?> talep (%<?php echo $yuzde; ?>)</span>
            </div>
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width:<?php echo $yuzde; ?>%;"></div>
            </div>
          </div>
        <?php endforeach; else: ?>
          <p style="color:#aaa;font-style:italic;text-align:center;padding:20px 0;">Henüz kategori verisi yok.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- ÇÖZÜM ORANI & YENİ TALEP -->
    <div class="two-col">
      <div class="section-card" style="display:flex;align-items:center;justify-content:space-between;">
        <div>
          <div style="font-size:0.85rem;color:#888;font-weight:600;text-transform:uppercase;">Çözüm Oranınız</div>
          <?php 
            $oran = ($ist['Toplam'] ?? 0) > 0 ? round(($ist['Cozuldu'] / $ist['Toplam']) * 100, 1) : 0;
          ?>
          <div style="font-size:2.5rem;font-weight:800;color:#10b981;margin:8px 0;">%<?php echo $oran; ?></div>
          <div style="font-size:0.83rem;color:#aaa;"><?php echo $ist['Cozuldu'] ?? 0; ?> / <?php echo $ist['Toplam'] ?? 0; ?> talep çözüldü</div>
        </div>
        <div style="font-size:3.5rem;">🏆</div>
      </div>

      <a href="index.php?controller=kullanici&action=yeniBasvuru" class="cta-btn">
        <div style="font-size:2rem;margin-bottom:8px;">✏️</div>
        YENİ DESTEK TALEBİ AÇ
        <div style="font-size:0.82rem;font-weight:400;margin-top:5px;opacity:0.85;">Sorunlarınızı ilgili birime doğrudan iletin</div>
      </a>
    </div>

  </div>
</div>
</body>
</html>