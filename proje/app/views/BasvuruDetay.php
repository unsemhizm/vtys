<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Başvuru Detayı — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/basvurularim.css" />
  <link rel="stylesheet" href="css/index.css" />
  <style>
    .detail-card { background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .chat-container { display: flex; flex-direction: column; gap: 15px; margin-top: 20px; }
    .msg-bubble { max-width: 80%; padding: 12px 18px; border-radius: 15px; position: relative; font-size: 0.95rem; }
    .msg-student { align-self: flex-end; background: var(--accent); color: white; border-bottom-right-radius: 2px; }
    .msg-staff { align-self: flex-start; background: #f0f2f5; color: var(--primary-dark); border-bottom-left-radius: 2px; }
    .msg-meta { font-size: 0.75rem; margin-top: 5px; opacity: 0.8; display: block; }
    .reply-area { margin-top: 30px; border-top: 1px solid var(--border); padding-top: 20px; }
    .reply-area textarea { width: 100%; border: 1px solid var(--border); border-radius: 8px; padding: 15px; font-family: inherit; resize: vertical; margin-bottom: 10px; }
  </style>
</head>
<body>

<header>
  <div class="header-inner">
    <a href="index.php?controller=kullanici&action=ogrenciPaneli" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;">
      <span class="header-title">Kampüs Çözüm Merkezi</span>
    </a>
    <div class="user-dropdown">
      <div class="header-user">
        <?php echo $_SESSION['ad_soyad']; ?> ▾
      </div>
    </div>
  </div>
</header>

<div class="layout">
  <aside>
    <nav>
      <a href="index.php?controller=kullanici&action=ogrenciPaneli"><span class="icon">🏠</span> Ana Sayfa</a>
      <a href="index.php?controller=kullanici&action=basvurularim" class="active"><span class="icon">📋</span> Başvurularım</a>
      <a href="index.php?controller=kullanici&action=yeniBasvuru"><span class="icon">✏️</span> Yeni Başvuru</a>
    </nav>
  </aside>

  <div class="content">
    <?php $b = $data['basvuru']; ?>
    <div class="page-title">BAŞVURU DETAYI #<?php echo $b['BasvuruID']; ?></div>

    <div class="detail-card">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h2 style="color:var(--primary-dark); margin:0;"><?php echo $b['Baslik']; ?></h2>
        <span class="badge" style="background:<?php echo $b['RenkKodu']; ?>; color:white; padding:6px 12px; border-radius:20px; font-weight:bold;">
          <?php echo $b['DurumAdi']; ?>
        </span>
      </div>
      <div style="color:var(--text-muted); font-size:0.9rem; margin-bottom:15px;">
        <strong>Kategori:</strong> <?php echo $b['KategoriAdi']; ?> | <strong>Birim:</strong> <?php echo $b['BirimAdi']; ?> | <strong>Tarih:</strong> <?php echo date('d.m.Y', strtotime($b['OlusturulmaTarihi'])); ?>
      </div>
      <div style="background:#f9fafb; padding:15px; border-radius:8px; line-height:1.6;">
        <?php echo nl2br($b['Aciklama']); ?>
      </div>
    </div>

    <div class="detail-card">
      <?php if($_SESSION['rol'] == 'Personel'): ?>
        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ccc;">
          <form action="index.php?controller=basvuru&action=durumDegistir" method="POST" style="display:flex; align-items:center; gap:10px;">
            <input type="hidden" name="basvuru_id" value="<?php echo $b['BasvuruID']; ?>">
            <label><strong>Durumu Güncelle:</strong></label>
            <select name="durum_id" style="padding:5px; border-radius:5px;">
              <option value="1" <?php echo $b['DurumID'] == 1 ? 'selected' : ''; ?>>Açık</option>
              <option value="2" <?php echo $b['DurumID'] == 2 ? 'selected' : ''; ?>>İnceleniyor</option>
              <option value="3" <?php echo $b['DurumID'] == 3 ? 'selected' : ''; ?>>Çözüldü</option>
              <option value="4" <?php echo $b['DurumID'] == 4 ? 'selected' : ''; ?>>Reddedildi</option>
            </select>
            <button type="submit" class="btn-primary" style="padding:5px 15px; font-size:0.8rem;">GÜNCELLE</button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>