<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Admin Paneli — Kampüs Çözüm Merkezi</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/admin.css">
  <style>
    body { font-family: 'Nunito', sans-serif; background: #f4f7f6; margin: 0; }
    .admin-header { position: fixed; top: 0; left: 0; right: 0; height: 70px; z-index: 1000; box-sizing: border-box; }
    .admin-main { padding: 30px; max-width: 1200px; margin: 80px auto 0 auto; }
    .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 25px; }
    .btn-sm { padding: 5px 10px; border-radius: 4px; text-decoration: none; color: white; background: #1a3a6b; font-size: 0.85rem; }
    .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:2000; }
    .modal-content { background:#fff; width:400px; margin:100px auto; padding:30px; border-radius:12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    .form-input { width:100%; box-sizing:border-box; margin:10px 0; padding:10px; border:1px solid #ccc; border-radius:6px; font-family:inherit; }
    .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 25px; }
    .stat-mini { background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.03); border-top: 4px solid #1a3a6b; }
  </style>
</head>
<body>
  
  <header class="admin-header" style="display:flex; justify-content:space-between; align-items:center; padding:0 30px; background:#122a52; color:white;">
    <div class="header-left" style="display:flex; align-items:center; gap:15px;">
      <div class="header-logo" style="background:white; color:#122a52; padding:5px 10px; border-radius:50%; font-weight:bold;">FÜ</div>
      <h1 style="margin:0; font-size:1.2rem;">Admin Kontrol Paneli</h1>
    </div>
    <div class="header-right">
      <span>Hoş Geldin, <?php echo $_SESSION['ad_soyad']; ?></span>
      <a href="index.php?controller=kullanici&action=profil" style="margin-left:15px; color:#fff; text-decoration:none;">👤 Profilim</a>
      <a href="index.php?controller=auth&action=logout" style="margin-left:20px; color:#ff6b6b; text-decoration:none; font-weight:bold;">🚪 Çıkış Yap</a>
    </div>
  </header>

  <div class="admin-main">
    
    <div class="stats-grid">
      <div class="stat-mini" style="border-color: #1a3a6b;">
        <h4 style="margin:0; color:#666;">Toplam</h4>
        <p style="font-size:1.8rem; font-weight:800; margin:5px 0 0 0; color:#1a3a6b;"><?php echo $data['topham_bilet'] ?? $data['toplam_bilet']; ?></p>
      </div>
      <div class="stat-mini" style="border-color: #ef4444;">
        <h4 style="margin:0; color:#666;">Açık</h4>
        <p style="font-size:1.8rem; font-weight:800; margin:5px 0 0 0; color:#ef4444;"><?php echo $data['acik_bilet']; ?></p>
      </div>
      <div class="stat-mini" style="border-color: #f59e0b;">
        <h4 style="margin:0; color:#666;">İnceleniyor</h4>
        <p style="font-size:1.8rem; font-weight:800; margin:5px 0 0 0; color:#f59e0b;"><?php echo $data['incelenen_bilet']; ?></p>
      </div>
      <div class="stat-mini" style="border-color: #10b981;">
        <h4 style="margin:0; color:#666;">Çözülen</h4>
        <p style="font-size:1.8rem; font-weight:800; margin:5px 0 0 0; color:#10b981;"><?php echo $data['cozulen_bilet']; ?></p>
      </div>
      <div class="stat-mini" style="border-color: #6b7280;">
        <h4 style="margin:0; color:#666;">Reddedilen</h4>
        <p style="font-size:1.8rem; font-weight:800; margin:5px 0 0 0; color:#6b7280;"><?php echo $data['red_bilet']; ?></p>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px;">
        <div class="card">
            <h3 style="border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-top:0;">Başvuru Çözüm Oranları</h3>
            <?php foreach($data['istatistikler'] as $stat): ?>
                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span><?php echo $stat['DurumAdi']; ?></span>
                        <strong>%<?php echo $stat['yuzde']; ?> (<?php echo $stat['adet']; ?>)</strong>
                    </div>
                    <div style="background: #e9ecef; height: 12px; border-radius: 6px; overflow: hidden;">
                        <div style="background: <?php echo $stat['RenkKodu']; ?>; width: <?php echo $stat['yuzde']; ?>%; height: 100%;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="card">
            <h3 style="border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-top:0;">Birim Bazlı Dağılım</h3>
            <ul style="list-style: none; padding: 0; margin-top: 10px; max-height:200px; overflow-y:auto;">
                <?php foreach($data['birim_analizi'] as $birim): ?>
                    <li style="padding: 8px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between;">
                        <span style="font-size:0.9rem;"><?php echo $birim['BirimAdi'] ? $birim['BirimAdi'] : 'Atanmamış'; ?></span>
                        <span style="background: #1a3a6b; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 11px; height:18px;">
                            <?php echo $birim['adet']; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top:0; border-bottom: 2px solid #f0f0f0; padding-bottom:10px;">Canlı Sistem Akışı (Son 5 Aktivite)</h3>
        <ul style="padding:0; list-style:none; margin:0;">
            <?php foreach($data['son_aktiviteler'] as $akt): ?>
                <li style="padding:12px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong>#<?php echo $akt['BasvuruID']; ?> - <?php echo htmlspecialchars($akt['Baslik']); ?></strong>
                        <br><span style="font-size:0.85rem; color:#666;">Başvuran: <?php echo $akt['AdSoyad']; ?> | Tarih: <?php echo date('d.m.Y H:i', strtotime($akt['OlusturulmaTarihi'])); ?></span>
                    </div>
                    <span style="background:<?php echo $akt['RenkKodu']; ?>; color:white; padding:4px 10px; border-radius:20px; font-size:0.8rem; font-weight:bold;">
                        <?php echo $akt['DurumAdi']; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin:0;">Kullanıcı Yönetimi</h2>
            <button onclick="document.getElementById('addUserModal').style.display='block'" style="background:#28a745; color:white; border:none; padding:10px 15px; border-radius:4px; cursor:pointer; font-weight:bold; font-family:inherit;">
                + Yeni Kullanıcı Ekle
            </button>
        </div>
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Ad Soyad</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">E-posta</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Rol</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Birim</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['kullanicilar'] as $user): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;"><?php echo $user['AdSoyad']; ?></td>
                        <td style="padding: 12px;"><?php echo $user['Eposta']; ?></td>
                        <td style="padding: 12px;"><strong style="color:#1a3a6b;"><?php echo $user['RolAdi']; ?></strong></td>
                        <td style="padding: 12px;"><?php echo $user['BirimAdi'] ?? '-'; ?></td>
                        <td style="padding: 12px;">
                            <button onclick="openEditModal(<?php echo $user['KullaniciID']; ?>, '<?php echo htmlspecialchars($user['AdSoyad'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($user['Eposta'], ENT_QUOTES); ?>', <?php echo $user['RolID']; ?>, '<?php echo $user['BirimID']; ?>')" style="color: #ffc107; border: none; background: none; cursor: pointer; font-weight:bold; font-family:inherit; padding:0;">Düzenle</button>
                            <a href="index.php?controller=admin&action=kullaniciSil&id=<?php echo $user['KullaniciID']; ?>" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')" style="color: #dc3545; font-weight:bold; margin-left: 10px; text-decoration:none;">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
      <h2 style="margin-top:0; margin-bottom:20px;">Talep Yönetim Merkezi</h2>
      <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead style="background:#f8f9fa;">
          <tr>
            <th style="padding:12px; border-bottom:2px solid #dee2e6;">ID</th>
            <th style="padding:12px; border-bottom:2px solid #dee2e6;">Başvuran</th>
            <th style="padding:12px; border-bottom:2px solid #dee2e6;">Başlık</th>
            <th style="padding:12px; border-bottom:2px solid #dee2e6;">Birim</th>
            <th style="padding:12px; border-bottom:2px solid #dee2e6;">Hızlı Durum</th>
            <th style="padding:12px; border-bottom:2px solid #dee2e6;">İşlem</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['basvurular'] as $b): ?>
          <tr style="border-bottom: 1px solid #eee;">
            <td style="padding:12px; font-weight:bold;">#<?php echo $b['BasvuruID']; ?></td>
            <td style="padding:12px;"><?php echo $b['AdSoyad']; ?></td>
            <td style="padding:12px;"><?php echo htmlspecialchars(substr($b['Baslik'], 0, 40)); ?>...</td>
            <td style="padding:12px;"><?php echo $b['BirimAdi'] ?? '-'; ?></td>
            <td style="padding:12px;">
                <form action="index.php?controller=admin&action=hizliDurumGuncelle" method="POST">
                    <input type="hidden" name="basvuru_id" value="<?php echo $b['BasvuruID']; ?>">
                    <select name="durum_id" onchange="this.form.submit()" style="padding:4px; border-radius:4px; font-weight:bold; color:<?php echo $b['RenkKodu']; ?>; border:1px solid <?php echo $b['RenkKodu']; ?>;">
                        <option value="1" <?php echo $b['DurumID'] == 1 ? 'selected' : ''; ?>>Açık</option>
                        <option value="2" <?php echo $b['DurumID'] == 2 ? 'selected' : ''; ?>>İnceleniyor</option>
                        <option value="3" <?php echo $b['DurumID'] == 3 ? 'selected' : ''; ?>>Çözüldü</option>
                        <option value="4" <?php echo $b['DurumID'] == 4 ? 'selected' : ''; ?>>Reddedildi</option>
                    </select>
                </form>
            </td>
            <td style="padding:12px;">
                <a href="index.php?controller=basvuru&action=detay&id=<?php echo $b['BasvuruID']; ?>" style="color:#1a3a6b; font-weight:bold; text-decoration:none;">İncele</a> | 
                <a href="index.php?controller=admin&action=basvuruSil&id=<?php echo $b['BasvuruID']; ?>" onclick="return confirm('Bu talebi silmek istediğinize emin misiniz?')" style="color:#dc3545; font-weight:bold; text-decoration:none;">Sil</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div id="addUserModal" class="modal-overlay">
      <div class="modal-content">
          <h3 style="margin-top:0;">Sisteme Yeni Kullanıcı Tanımla</h3>
          <form action="index.php?controller=admin&action=kullaniciKaydet" method="POST">
              <input type="text" name="ad_soyad" placeholder="Ad Soyad" required class="form-input">
              <input type="email" name="eposta" placeholder="E-posta Adresi" required class="form-input">
              <input type="password" name="sifre" placeholder="Geçici Şifre" required class="form-input">
              <select name="rol_id" class="form-input">
                  <option value="1">Öğrenci</option>
                  <option value="2">Personel</option>
                  <option value="3">Admin</option>
              </select>
              <input type="text" name="birim_id" placeholder="Birim ID (Yoksa Boş)" class="form-input">
              <div style="display:flex; gap:10px; margin-top:20px;">
                  <button type="submit" style="flex:1; background:#28a745; color:#fff; border:none; padding:10px; border-radius:6px; cursor:pointer;">Kaydet</button>
                  <button type="button" onclick="document.getElementById('addUserModal').style.display='none'" style="flex:1; background:#6c757d; color:#fff; border:none; padding:10px; border-radius:6px; cursor:pointer;">İptal</button>
              </div>
          </form>
      </div>
  </div>

  <div id="editUserModal" class="modal-overlay">
      <div class="modal-content">
          <h3>Kullanıcı Düzenle</h3>
          <form action="index.php?controller=admin&action=kullaniciGuncelle" method="POST">
              <input type="hidden" name="kullanici_id" id="edit_kullanici_id">
              <input type="text" name="ad_soyad" id="edit_ad_soyad" class="form-input">
              <input type="email" name="eposta" id="edit_eposta" class="form-input">
              <input type="password" name="sifre" placeholder="Şifreyi Değiştirmek İstemiyorsanız Boş Bırakın" class="form-input">
              <select name="rol_id" id="edit_rol_id" class="form-input">
                  <option value="1">Öğrenci</option>
                  <option value="2">Personel</option>
                  <option value="3">Admin</option>
              </select>
              <input type="text" name="birim_id" id="edit_birim_id" class="form-input">
              <div style="display:flex; gap:10px; margin-top:20px;">
                  <button type="submit" style="flex:1; background:#ffc107; color:black; border:none; padding:10px; border-radius:6px;">Güncelle</button>
                  <button type="button" onclick="document.getElementById('editUserModal').style.display='none'" style="flex:1; background:#6c757d; color:white; border:none; padding:10px; border-radius:6px;">İptal</button>
              </div>
          </form>
      </div>
  </div>

  <script>
    function openEditModal(id, adSoyad, eposta, rolId, birimId) {
        document.getElementById('edit_kullanici_id').value = id;
        document.getElementById('edit_ad_soyad').value = adSoyad;
        document.getElementById('edit_eposta').value = eposta;
        document.getElementById('edit_rol_id').value = rolId;
        document.getElementById('edit_birim_id').value = birimId === 'null' || birimId === undefined ? '' : birimId;
        document.getElementById('editUserModal').style.display = 'block';
    }
  </script>
</body>
</html>