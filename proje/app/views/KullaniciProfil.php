<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Bilgilerim — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/index.css" />
  <style>
    .profile-card { background: white; border-radius: 12px; padding: 30px; max-width: 600px; margin: 30px auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .form-group { margin-bottom: 20px; display: flex; flex-direction: column; gap: 5px; }
    .form-group label { font-weight: 700; color: #333; }
    .form-input { padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-family: inherit; font-size: 0.95rem; }
    .btn-save { background: #1a3a6b; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-family: inherit; }
  </style>
</head>
<body>

<header>
  <div class="header-inner">
    <a href="index.php" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;">
      <span class="header-title">Kampüs Çözüm Merkezi</span>
    </a>
    <div class="header-user">
      👤 <?php echo $_SESSION['ad_soyad']; ?> [<?php echo $_SESSION['rol']; ?>]
    </div>
  </div>
</header>

<div class="layout" style="display:block; padding: 20px;">
  <div style="max-width: 600px; margin: 0 auto; margin-bottom: 10px;">
      <button onclick="window.history.back()" style="background:#6c757d; color:white; border:none; padding:8px 15px; border-radius:4px; cursor:pointer; font-weight:bold;">← Geri Dön</button>
  </div>

  <div class="profile-card">
    <h2 style="margin-top:0; color:#1a3a6b; border-bottom:2px solid #f0f0f0; padding-bottom:10px;">Profilimi Düzenle</h2>
    
    <?php echo $data['mesaj']; ?>

    <form action="index.php?controller=kullanici&action=profil" method="POST">
        <div class="form-group">
            <label>Adınız Soyadınız</label>
            <input type="text" name="ad_soyad" value="<?php echo htmlspecialchars($data['user']['AdSoyad']); ?>" required class="form-input">
        </div>

        <div class="form-group">
            <label>E-posta Adresiniz</label>
            <input type="email" name="eposta" value="<?php echo htmlspecialchars($data['user']['Eposta']); ?>" required class="form-input">
        </div>

        <div class="form-group">
            <label>Yeni Şifre</label>
            <input type="password" name="sifre" placeholder="Şifrenizi değiştirmek istemiyorsanız boş bırakın" class="form-input">
        </div>

        <div class="form-group" style="background:#f8f9fa; padding:15px; border-radius:6px; margin-top:20px;">
            <p style="margin:0; font-size:0.9rem; color:#666;"><strong>Sistem Rolü:</strong> <?php echo $data['user']['RolAdi']; ?></p>
            <?php if(!empty($data['user']['BirimAdi'])): ?>
                <p style="margin:5px 0 0 0; font-size:0.9rem; color:#666;"><strong>Atandığınız Birim:</strong> <?php echo $data['user']['BirimAdi']; ?></p>
            <?php endif; ?>
        </div>

        <div style="text-align:right; margin-top:20px;">
            <button type="submit" class="btn-save">Değişiklikleri Kaydet</button>
        </div>
    </form>
  </div>
</div>

</body>
</html>