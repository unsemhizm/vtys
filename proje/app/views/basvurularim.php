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
    <a href="ogrenci_anasayfa.html" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;">
      <button class="hamburger">☰</button>
      <span class="header-title">Kampüs Çözüm Merkezi</span>
    </a>
    <div class="user-dropdown">
      <div class="header-user">
        <div class="avatar">AU</div>
        Ahmet Uzun ▾
      </div>
      <div class="dropdown-content">
        <a href="index.php?controller=kullanici&action=basvurularim">📋 Başvurularım</a>
        <a href="index.php?controller=kullanici&action=yeniBasvuru">✏️ Yeni Başvuru</a>
        <a href="index.php?controller=kullanici&action=profil">👤 Profilim</a>
        <a href="index.php?controller=auth&action=logout" style="border-top: 1px solid var(--border); color: #dc3545;">🚪 Çıkış Yap</a>
      </div>
    </div>
  </div>
</header>

<div class="layout">
  <aside>
    <a href="ogrenci_anasayfa.html" class="sidebar-logo" style="text-decoration: none;">
      <div class="logo-sm">FÜ</div>
      <span>Kampüs Çözüm<br/>Merkezi</span>
    </a>
    <nav>
      <a href="index.php?controller=kullanici&action=ogrenciPaneli">
        <span class="icon">🏠</span> Ana Sayfa
      </a>
      <a href="index.php?controller=kullanici&action=basvurularim" class="active">
        <span class="icon">📋</span> Başvurularım
      </a>
      <a href="index.php?controller=kullanici&action=yeniBasvuru">
        <span class="icon">✏️</span> Yeni Başvuru
      </a>  
    </nav>
  </aside>

  <div class="content">
    <div class="page-title">BAŞVURULARİM</div>

    <div class="filters">
      <button class="chip active" onclick="filterTickets('tumu', this)">Tümü</button>
      <button class="chip" onclick="filterTickets('acik', this)">Açık</button>
      <button class="chip" onclick="filterTickets('inceleniyor', this)">İnceleniyor</button>
      <button class="chip" onclick="filterTickets('cozuldu', this)">Çözüldü</button>
      <button class="chip" onclick="filterTickets('reddedildi', this)">Reddedildi</button>
    </div>

    <div class="ticket-list">

      <div class="ticket-list">
      <?php if(isset($data['basvurular']) && !empty($data['basvurular'])): ?>
        <?php foreach($data['basvurular'] as $basvuru): ?>
          <?php
            // JavaScript'in üstteki butonlarla (Tümü, Açık, Çözüldü vb.) filtreleme yapabilmesi için
            // DurumID'ye göre data-status class'ı belirliyoruz.
            $durum_class = '';
            switch($basvuru['DurumID']) {
                case 1: $durum_class = 'acik'; break;
                case 2: $durum_class = 'inceleniyor'; break;
                case 3: $durum_class = 'cozuldu'; break;
                case 4: $durum_class = 'reddedildi'; break;
            }
          ?>
          <div class="ticket-card <?php echo $durum_class; ?>" data-status="<?php echo $durum_class; ?>">
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
            <button class="btn-detail" onclick="window.location.href='index.php?controller=basvuru&action=detay&id=<?php echo $basvuru['BasvuruID']; ?>'">Detay</button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #6B7280; font-size: 1.1rem;">
          Henüz bir başvurunuz bulunmamaktadır.
        </div>
      <?php endif; ?>
    </div>

    </div>
  </div>
</div>

<!-- MODAL -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-header">
      <h3 id="modalTitle">Talep Detayı</h3>
      <button class="modal-close" onclick="closeModal()">✕</button>
    </div>
    <div class="detail-row"><span class="detail-label">Ticket ID:</span><span id="mId"></span></div>
    <div class="detail-row"><span class="detail-label">Durum:</span><span id="mStatus"></span></div>
    <div class="detail-row"><span class="detail-label">Kategori:</span><span id="mCat"></span></div>
    <div class="detail-row"><span class="detail-label">Tarih:</span><span id="mDate"></span></div>
    <div class="chat-box" id="chatMessages">
      <div class="msg msg-support">
        <div class="msg-bubble">Merhaba! Talebinizi aldık, en kısa sürede size dönüş yapacağız.</div>
        <div class="msg-meta">Destek Ekibi · 09:30</div>
      </div>
    </div>
    <div class="chat-input">
      <input type="text" id="chatInput" placeholder="Mesajınızı yazın..." />
      <button onclick="sendMsg()">Gönder</button>
    </div>
  </div>
</div>

<script src="js/basvurularim.js"></script>
</body>
</html>
