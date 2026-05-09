<?php
// Sayfanın en üstünde veritabanı bağlantımızı çağırıyoruz
require_once '../config/config.php';

// 1. İstatistikler için sorgular
$toplamBiletSorgusu = $db->query("SELECT COUNT(*) FROM Basvurular")->fetchColumn();
$cozulenBiletSorgusu = $db->query("SELECT COUNT(*) FROM Basvurular WHERE DurumID = 3")->fetchColumn();
$cozulmeOrani = ($toplamBiletSorgusu > 0) ? round(($cozulenBiletSorgusu / $toplamBiletSorgusu) * 100) : 0;

// En çok bilet açılan kategori (Opsiyonel Gelişmiş Sorgu)
$enCokKategoriSorgusu = $db->query("
    SELECT k.KategoriAdi, COUNT(b.BasvuruID) as Adet 
    FROM Basvurular b 
    JOIN Kategoriler k ON b.KategoriID = k.KategoriID 
    GROUP BY b.KategoriID 
    ORDER BY Adet DESC 
    LIMIT 1
")->fetch(PDO::FETCH_ASSOC);
$enCokKategoriAd = $enCokKategoriSorgusu ? $enCokKategoriSorgusu['KategoriAdi'] : 'Veri Yok';

// 2. Kullanıcıları çekme (Rolleri ve Birimleri birleştirerek)
$kullanicilarSorgusu = $db->query("
    SELECT k.KullaniciID, k.AdSoyad, k.Eposta, r.RolAdi, b.BirimAdi 
    FROM Kullanicilar k 
    LEFT JOIN Roller r ON k.RolID = r.RolID 
    LEFT JOIN Birimler b ON k.BirimID = b.BirimID
")->fetchAll(PDO::FETCH_ASSOC);

// 3. Departmanları çekme
$departmanlarSorgusu = $db->query("SELECT * FROM Birimler")->fetchAll(PDO::FETCH_ASSOC);

// 4. Mesajları / Başvuruları Çekme
$basvurularSorgusu = $db->query("
    SELECT b.BasvuruID, k.AdSoyad, b.Baslik, br.BirimAdi, d.DurumAdi, d.RenkKodu, b.OlusturulmaTarihi 
    FROM Basvurular b
    JOIN Kullanicilar k ON b.KullaniciID = k.KullaniciID
    JOIN Birimler br ON b.BirimID = br.BirimID
    JOIN Durumlar d ON b.DurumID = d.DurumID
    ORDER BY b.OlusturulmaTarihi DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard — Kampüs Çözüm Merkezi</title>
  <link rel="stylesheet" href="css/admin.css" />
</head>
<body>

  <!-- Top Header -->
  <header class="admin-header">
    <div class="header-left">
      <div class="header-logo">FÜ</div>
      <div class="header-titles">
        <h1>Kampüs Çözüm Merkezi</h1>
        <span>HTML, CSS, Basic JavaScript, PHP & MySQL</span>
      </div>
    </div>
    <div class="header-right">
      <span class="header-user-name">Sistem Yöneticisi</span>
      <div class="header-avatar" style="background:var(--admin-accent);">SA</div>
    </div>
  </header>

  <!-- Sidebar -->
  <aside class="admin-sidebar">
    <nav class="sidebar-nav">
      <a href="#sec-istatistik" class="nav-item">
        <span>📊</span> İstatistikler
      </a>
      <a href="#sec-kullanici" class="nav-item">
        <span>👤</span> Kullanıcı Yönetimi
      </a>
      <a href="#sec-departman" class="nav-item">
        <span>🏢</span> Departmanlar
      </a>
      <a href="#sec-mesajlar" class="nav-item">
        <span>💬</span> Tüm Başvurular
      </a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="admin-main">
    
    <!-- SECTION 1: İstatistikler -->
    <section id="sec-istatistik" class="admin-section" style="margin-bottom: 3rem;">
      <h2 class="section-title">GENEL İSTATİSTİKLER</h2>
      <div class="stats-grid">
        <div class="stat-card">
          <h3>TOPLAM BİLET</h3>
          <div class="stat-chart-placeholder" style="font-size: 2.5rem; font-weight: 800; color: var(--admin-primary); border: none;">
            <?= $toplamBiletSorgusu ?>
          </div>
        </div>
        <div class="stat-card">
          <h3>ÇÖZÜLME ORANI</h3>
          <div class="stat-chart-placeholder" style="font-size: 2.5rem; font-weight: 800; color: #10B981; border: none;">
            %<?= $cozulmeOrani ?>
          </div>
        </div>
        <div class="stat-card">
          <h3>EN ÇOK BİLET AÇILAN KATEGORİ</h3>
          <div class="stat-chart-placeholder" style="font-size: 1rem; color: #a0aec0; border: none; text-align: center; padding: 1rem;">
            <?= htmlspecialchars($enCokKategoriAd) ?>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2: Kullanıcı Yönetimi -->
    <section id="sec-kullanici" class="admin-section" style="margin-bottom: 3rem;">
      <div class="table-header-row">
        <h2 class="section-title" style="margin: 0;">KULLANICI YÖNETİMİ</h2>
        <button class="btn-primary">Yeni Kullanıcı Ekle</button>
      </div>
      <div class="admin-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Ad Soyad</th>
              <th>E-posta</th>
              <th>Rol</th>
              <th>Birim</th>
              <th>İşlem</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($kullanicilarSorgusu as $kullanici): ?>
            <tr>
              <td><?= $kullanici['KullaniciID'] ?></td>
              <td><?= htmlspecialchars($kullanici['AdSoyad']) ?></td>
              <td><?= htmlspecialchars($kullanici['Eposta']) ?></td>
              <td>
                <span class="badge" style="background:#122a52;color:white;padding:2px 6px;border-radius:4px;font-size:0.8rem;">
                  <?= htmlspecialchars($kullanici['RolAdi']) ?>
                </span>
              </td>
              <td><?= $kullanici['BirimAdi'] ? htmlspecialchars($kullanici['BirimAdi']) : '-' ?></td>
              <td>
                <button class="btn-action btn-edit">Düzenle</button>
                <button class="btn-action btn-delete">Sil</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- SECTION 3: Departmanlar (Birimler) -->
    <section id="sec-departman" class="admin-section" style="margin-bottom: 3rem;">
      <div class="table-header-row">
        <h2 class="section-title" style="margin: 0;">BİRİMLER / DEPARTMANLAR</h2>
        <button class="btn-primary">Yeni Birim Ekle</button>
      </div>
      <div class="admin-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Birim ID</th>
              <th>Birim Adı</th>
              <th>Konum</th>
              <th>İşlem</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($departmanlarSorgusu as $departman): ?>
            <tr>
              <td><?= $departman['BirimID'] ?></td>
              <td><?= htmlspecialchars($departman['BirimAdi']) ?></td>
              <td><?= htmlspecialchars($departman['Konum']) ?></td>
              <td>
                <button class="btn-action btn-edit">Düzenle</button>
                <button class="btn-action btn-delete">Sil</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- SECTION 4: Mesajlar (Tüm Başvurular / Yanıtlar) -->
    <section id="sec-mesajlar" class="admin-section" style="margin-bottom: 3rem;">
      <div class="table-header-row">
        <h2 class="section-title" style="margin: 0;">SİSTEMDEKİ TÜM BAŞVURULAR</h2>
      </div>
      <div class="admin-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Başvuru ID</th>
              <th>Başvuran</th>
              <th>Başlık</th>
              <th>Birim</th>
              <th>Durum</th>
              <th>Tarih</th>
              <th>İşlem</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($basvurularSorgusu as $basvuru): ?>
            <tr>
              <td><?= $basvuru['BasvuruID'] ?></td>
              <td><?= htmlspecialchars($basvuru['AdSoyad']) ?></td>
              <td><?= htmlspecialchars($basvuru['Baslik']) ?></td>
              <td><?= htmlspecialchars($basvuru['BirimAdi']) ?></td>
              <td>
                <span style="color:<?= $basvuru['RenkKodu'] ?>;font-weight:700;">
                  <?= htmlspecialchars($basvuru['DurumAdi']) ?>
                </span>
              </td>
              <td><?= date('d.m.Y', strtotime($basvuru['OlusturulmaTarihi'])) ?></td>
              <td>
                <button class="btn-action btn-edit">Görüntüle</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

  </main>

  <script>
    document.querySelectorAll('.sidebar-nav .nav-item').forEach(item => {
      item.addEventListener('click', function() {
        document.querySelectorAll('.sidebar-nav .nav-item').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');
      });
    });
  </script>

</body>
</html>
