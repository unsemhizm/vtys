<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personel Paneli — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/personel_paneli.css" />
  <style>
    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px; }
    .stat-card { background:#fff; border-radius:12px; padding:20px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.06); border-top:4px solid #ddd; }
    .stat-card .num { font-size:2.2rem; font-weight:800; margin:8px 0 4px; }
    .stat-card .label { font-size:0.82rem; color:#888; font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
    .section-card { background:#fff; border-radius:12px; padding:22px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:20px; }
    .section-card h3 { margin:0 0 16px; color:#1a3a6b; font-size:1rem; border-bottom:2px solid #f0f4f8; padding-bottom:10px; }
    .progress-bar-wrap { margin-bottom:12px; }
    .pb-label { display:flex; justify-content:space-between; font-size:0.83rem; margin-bottom:4px; color:#555; font-weight:600; }
    .progress-bar-bg { background:#f0f4f8; border-radius:6px; height:10px; overflow:hidden; }
    .progress-bar-fill { height:100%; border-radius:6px; transition:width 0.6s ease; }
    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .ticket-card { background:#fff; border-radius:10px; padding:18px; border:1px solid #eee; margin-bottom:12px; box-shadow:0 2px 5px rgba(0,0,0,0.04); }
    .ticket-card .ticket-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
    .status-badge { padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700; color:white; }
    .view-btn { display:inline-block; background:#1a3a6b; color:white; padding:7px 18px; border-radius:6px; text-decoration:none; font-size:0.85rem; font-weight:700; margin-top:10px; }
  </style>
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
          <div class="avatar" style="background:var(--primary);">P</div>
          <?php echo $_SESSION['ad_soyad']; ?> ▾
        </div>
        <div class="dropdown-content">
          <a href="index.php?controller=kullanici&action=profil">👤 Profil Ayarlarım</a>
          <a href="index.php?controller=auth&action=logout" style="color:#dc3545;">🚪 Güvenli Çıkış</a>
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
      <a href="index.php?controller=kullanici&action=profil"><span class="icon">👤</span> Profilim</a>
      <a href="index.php?controller=auth&action=logout"><span class="icon">🚪</span> Çıkış Yap</a>
    </nav>
  </aside>

  <div class="content">
    <div class="header-content">
      <h1>Hoş Geldin, <?php echo explode(' ', $_SESSION['ad_soyad'])[0]; ?> 👋</h1>
      <p>Biriminize ait talep istatistikleri ve güncel durum özetleri aşağıda yer almaktadır.</p>
    </div>

    <?php $ist = $data['istatistikler'] ?? []; ?>

    <!-- İSTATİSTİK KARTLARI -->
    <div class="stats-row">
      <div class="stat-card" style="border-color:#1a3a6b;">
        <div class="label">Toplam Talep</div>
        <div class="num" style="color:#1a3a6b;"><?php echo $ist['Toplam'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#ef4444;">
        <div class="label">Açık</div>
        <div class="num" style="color:#ef4444;"><?php echo $ist['Acik'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#f59e0b;">
        <div class="label">İnceleniyor</div>
        <div class="num" style="color:#f59e0b;"><?php echo $ist['Inceleniyor'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#10b981;">
        <div class="label">Çözülen</div>
        <div class="num" style="color:#10b981;"><?php echo $ist['Cozuldu'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#6b7280;">
        <div class="label">Reddedilen</div>
        <div class="num" style="color:#6b7280;"><?php echo $ist['Reddedildi'] ?? 0; ?></div>
      </div>
      <div class="stat-card" style="border-color:#8b5cf6;">
        <div class="label">Bu Hafta Gelen</div>
        <div class="num" style="color:#8b5cf6;"><?php echo $ist['BuHafta'] ?? 0; ?></div>
      </div>
    </div>

    <div class="two-col" style="margin-bottom:20px;">
      <!-- ÇÖZÜM ORANI -->
      <div class="section-card" style="display:flex;align-items:center;justify-content:space-between;">
        <div>
          <div style="font-size:0.85rem;color:#888;font-weight:600;text-transform:uppercase;">Birim Çözüm Oranı</div>
          <?php
            $oran = ($ist['Toplam'] ?? 0) > 0 ? round(($ist['Cozuldu'] / $ist['Toplam']) * 100, 1) : 0;
            $renk = $oran >= 70 ? '#10b981' : ($oran >= 40 ? '#f59e0b' : '#ef4444');
          ?>
          <div style="font-size:2.5rem;font-weight:800;color:<?php echo $renk; ?>;margin:8px 0;">%<?php echo $oran; ?></div>
          <div style="font-size:0.83rem;color:#aaa;"><?php echo $ist['Cozuldu'] ?? 0; ?> / <?php echo $ist['Toplam'] ?? 0; ?> talep çözüldü</div>
        </div>
        <div style="font-size:3.5rem;"><?php echo $oran >= 70 ? '✅' : ($oran >= 40 ? '⚠️' : '🔴'); ?></div>
      </div>

      <!-- KATEGORİ DAĞILIMI -->
      <div class="section-card">
        <h3>📊 Talep Kategorileri</h3>
        <?php if(!empty($data['kategori_dagilimi'])): ?>
          <?php foreach($data['kategori_dagilimi'] as $kat): ?>
            <div class="progress-bar-wrap">
              <div class="pb-label">
                <span><?php echo htmlspecialchars($kat['KategoriAdi']); ?></span>
                <span><?php echo $kat['Adet']; ?> (%<?php echo $kat['Yuzde'] ?? 0; ?>)</span>
              </div>
              <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width:<?php echo $kat['Yuzde'] ?? 0; ?>%;background:#1a3a6b;"></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="color:#aaa;font-style:italic;text-align:center;padding:15px 0;">Bu birime henüz talep gelmemiş.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- TALEP LİSTESİ -->
    <div class="section-card">
      <h3>📬 Biriminize Gelen Talepler</h3>
      <?php if(empty($data['basvurular'])): ?>
        <div style="text-align:center;padding:30px;color:#6b7280;">Henüz bekleyen bir başvuru bulunmuyor.</div>
      <?php else: ?>
        <?php foreach($data['basvurular'] as $b): ?>
          <div class="ticket-card">
            <div class="ticket-header">
              <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-weight:800;color:#1a3a6b;">#<?php echo $b['BasvuruID']; ?></span>
                <span class="status-badge" style="background:<?php echo $b['RenkKodu']; ?>"><?php echo $b['DurumAdi']; ?></span>
                <?php if(isset($b['OkunmamisSayisi']) && $b['OkunmamisSayisi'] > 0): ?>
                  <span class="status-badge" style="background:#ef4444;">🔴 <?php echo $b['OkunmamisSayisi']; ?> Yeni Cevap</span>
                <?php endif; ?>
              </div>
              <span style="font-size:0.82rem;color:#aaa;"><?php echo date('d.m.Y', strtotime($b['OlusturulmaTarihi'])); ?></span>
            </div>
            <div style="font-weight:700;color:#333;margin-bottom:5px;"><?php echo htmlspecialchars($b['Baslik']); ?></div>
            <div style="font-size:0.85rem;color:#888;">👤 <?php echo $b['AdSoyad']; ?> &nbsp;|&nbsp; 📂 <?php echo $b['KategoriAdi']; ?></div>
            <a href="index.php?controller=basvuru&action=detay&id=<?php echo $b['BasvuruID']; ?>" class="view-btn">Detayı Gör ve Yanıtla</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>