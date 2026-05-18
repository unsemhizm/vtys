<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Başvuru Detayı — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/basvurularim.css" />
  <style>
    .detail-card { background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .chat-container { display: flex; flex-direction: column; gap: 15px; margin-top: 20px; }
    .msg-bubble { max-width: 80%; padding: 12px 18px; border-radius: 15px; font-size: 0.95rem; }
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
    <a href="index.php?controller=kullanici&action=<?php echo $_SESSION['rol'] == 'Öğrenci' ? 'ogrenciPaneli' : 'personelPaneli'; ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;">
      <span class="header-title">Kampüs Çözüm Merkezi</span>
    </a>
    <div class="header-user">
      <?php echo $_SESSION['ad_soyad']; ?> [<?php echo $_SESSION['rol']; ?>]
    </div>
  </div>
</header>

<div class="back-button-container">
  <a href="index.php?controller=kullanici&action=<?php echo $_SESSION['rol'] == 'Öğrenci' ? 'basvurularim' : 'personelPaneli'; ?>" class="back-button" onclick="if(history.length > 1){ history.back(); return false; }">← Önceki Sayfaya Dön</a>
</div>

<div class="layout" style="max-width: 1000px; margin: 20px auto; display: block;">
  <?php $b = $data['basvuru']; ?>
  <div class="page-title">BAŞVURU DETAYI #<?php echo $b['BasvuruID']; ?></div>

  <div class="detail-card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <h2 style="color:var(--primary-dark); margin:0;"><?php echo $b['Baslik']; ?></h2>
      <span class="badge" style="background:<?php echo $b['RenkKodu']; ?>; color:white; padding:6px 12px; border-radius:20px;">
        <?php echo $b['DurumAdi']; ?>
      </span>
    </div>
    <hr style="margin:15px 0; border:0; border-top:1px solid #eee;">
    <p><strong>Açıklama:</strong><br><?php echo nl2br(htmlspecialchars($b['Aciklama'])); ?></p>
    
    <?php if($_SESSION['rol'] == 'Personel'): ?>
      <form action="index.php?controller=basvuru&action=durumDegistir" method="POST" style="margin-top:20px; padding:15px; background:#f9fafb; border-radius:8px;">
        <input type="hidden" name="basvuru_id" value="<?php echo $b['BasvuruID']; ?>">
        <label><strong>Durumu Güncelle:</strong></label>
        <select name="durum_id" style="padding:5px; margin:0 10px;">
          <option value="1" <?php echo $b['DurumID'] == 1 ? 'selected' : ''; ?>>Açık</option>
          <option value="2" <?php echo $b['DurumID'] == 2 ? 'selected' : ''; ?>>İnceleniyor</option>
          <option value="3" <?php echo $b['DurumID'] == 3 ? 'selected' : ''; ?>>Çözüldü</option>
        </select>
        <button type="submit" class="btn-primary" style="padding:5px 15px;">Güncelle</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="detail-card">
    <h3>Mesajlar</h3>
    <div class="chat-container">
      <?php foreach($data['yanitlar'] as $y): ?>
        <div class="msg-bubble <?php echo $y['RolAdi'] == 'Öğrenci' ? 'msg-student' : 'msg-staff'; ?>">
          <strong><?php echo $y['AdSoyad']; ?>:</strong><br>
          <?php echo nl2br(htmlspecialchars($y['Mesaj'])); ?>
          <span class="msg-meta"><?php echo date('H:i - d.m.Y', strtotime($y['GonderilmeTarihi'])); ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="reply-area">
      <form action="index.php?controller=basvuru&action=yanitGonder" method="POST">
        <input type="hidden" name="basvuru_id" value="<?php echo $b['BasvuruID']; ?>">
        <textarea name="icerik" placeholder="Mesajınızı buraya yazın..." rows="3" required></textarea>
        <button type="submit" class="btn-primary">GÖNDER</button>
      </form>
    </div>
  </div>
</div>
<div style="margin-bottom: 20px;">
    <?php if($_SESSION['rol'] == 'Öğrenci'): ?>
        <a href="index.php?controller=kullanici&action=basvurularim" class="btn-sm" style="text-decoration: none; background: #6c757d;">
            <i class="fas fa-arrow-left"></i> Başvurularıma Dön
        </a>
    <?php else: ?>
        <a href="index.php?controller=kullanici&action=personelPaneli" class="btn-sm" style="text-decoration: none; background: #6c757d;">
            <i class="fas fa-arrow-left"></i> Taleplere Dön
        </a>
    <?php endif; ?>
</div>
</body>
</html>