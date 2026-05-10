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
      <button class="hamburger">☰</button>
      <span class="header-title">Kampüs Çözüm Merkezi — Personel Paneli</span>
    </div>
    <div class="header-right">
      <div class="user-dropdown">
        <div class="header-user">
          <div class="avatar" style="background: var(--primary);">HD</div>
          Hakan Demir ▾
        </div>
        <div class="dropdown-content">
          <a href="../../public/index.php" style="color: #dc3545;">🚪 Güvenli Çıkış</a>
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
      <a href="index.php?controller=kullanici&action=personelPaneli" class="active">
        <span class="icon">📋</span> Talepler
      </a>
      <a href="index.php?controller=auth&action=logout">
        <span class="icon">🚪</span> Çıkış Yap
      </a>
    </nav>
  </aside>

  <div class="content">
    <div class="header-content">
      <h1>Hoş Geldin, <?php echo $_SESSION['ad_soyad']; ?></h1>
      <p>Biriminize gelen son talepler aşağıdadır.</p>
    </div>

    <div class="ticket-list">
      <?php if(empty($data['basvurular'])): ?>
          <div class="card" style="text-align:center; padding:20px;">Henüz bir başvuru bulunmuyor.</div>
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

<div class="modal-overlay" id="modalOverlay">
  <div class="modal">

    <!-- Ticket list for staff -->
    <div class="ticket-list" id="ticketList">
      
      <div class="ticket-row beklemede" data-id="127" data-status="Beklemede">
        <div class="ticket-info-group">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="badge badge-yellow">⏳ Beklemede</span>
            <span style="font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">#127</span>
          </div>
          <span class="ticket-title-text">Yatay Geçiş Muafiyet Dilekçesi Onayı</span>
          <span class="ticket-sub-meta">Gönderen: Esra Yılmaz · Kategori: Ders Kayıtları · 03.05.2026</span>
        </div>
        <button class="btn-action" onclick="openReviewModal(148, 'Yatay Geçiş Muafiyet Dilekçesi Onayı', 'Esra Yılmaz', 'Açık', 'Yatay geçiş yaptıktan sonra verdiğim ders muafiyeti dilekçem hala sisteme işlenmemiş gözüküyor.')">İncele</button>
      </div>

      <div class="ticket-row inceleniyor" data-id="147" data-status="İnceleniyor">
        <div class="ticket-info-group">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="badge" style="background:#F59E0B;color:white;">İnceleniyor</span>
            <span style="font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">#147</span>
          </div>
          <span class="ticket-title-text">Mühendislik Blokları Wi-Fi Kopma Sorunu</span>
          <span class="ticket-sub-meta">Gönderen: Yusuf Canlı · Kategori: Altyapı · 01.05.2026</span>
        </div>
        <button class="btn-action" onclick="openReviewModal(147, 'Mühendislik Blokları Wi-Fi Kopma Sorunu', 'Yusuf Canlı', 'İnceleniyor', 'A Blok 3. kattaki dersliklerde eduroam ağı sürekli kopuyor ve derslerde sunum yaparken internete erişemiyoruz.')">İncele</button>
      </div>

      <div class="ticket-row cozuldu" data-id="149" data-status="Çözüldü">
        <div class="ticket-info-group">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="badge" style="background:#10B981;color:white;">Çözüldü</span>
            <span style="font-size: 0.8rem; font-weight: bold; color: var(--text-muted);">#149</span>
          </div>
          <span class="ticket-title-text">Kütüphane Çalışma Salonu Klima Arızası</span>
          <span class="ticket-sub-meta">Gönderen: Yusuf Canlı · Kategori: Kütüphane · 04.05.2026</span>
        </div>
        <button class="btn-action" onclick="openReviewModal(149, 'Kütüphane Çalışma Salonu Klima Arızası', 'Yusuf Canlı', 'Çözüldü', 'Merkez kütüphane 2. kat sessiz çalışma salonundaki klima sıcak üflüyor, içerisi ders çalışılamayacak kadar sıcak oldu.')">İncele</button>
      </div>

    </div>
  </div>
</div>

<!-- STAFF MODAL -->
<div class="modal-overlay" id="reviewModalOverlay">
  <div class="modal">
    <div class="modal-header">
      <h3 id="mTitle">Talep İnceleme</h3>
      <button class="modal-close" onclick="closeReviewModal()">✕</button>
    </div>
    
    <div class="detail-row"><span class="detail-label">Talep ID:</span><span class="detail-val" id="mIdVal">#127</span></div>
    <div class="detail-row"><span class="detail-label">Başvuran:</span><span class="detail-val" id="mUserVal">Ahmet Uzun</span></div>
    <div class="detail-row" style="margin-bottom: 1rem;"><span class="detail-label">Açıklama:</span><span class="detail-val" id="mDescVal" style="font-weight: 500; font-style: italic;">Açıklama yükleniyor...</span></div>

    <!-- Message list -->
    <div class="chat-box" id="reviewChatBox">
      <!-- Default Student message -->
    </div>

    <!-- Reply input -->
    <div class="chat-input">
      <input type="text" id="replyInput" class="form-group" style="padding: 0.6rem 0.9rem; border: 1.5px solid var(--border); border-radius: 8px;" placeholder="Öğrenciye yanıt yazın..." />
      <button onclick="sendStaffReply()">Yanıtla</button>
    </div>

    <!-- Status updater -->
    <div class="status-select-group">
      <label style="font-size: 0.88rem; font-weight: 700; color: var(--primary);">Durum Güncelle:</label>
      <select id="statusSelect" style="padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600;">
        <option value="Açık">🔴 Açık</option>
        <option value="İnceleniyor">🟠 İnceleniyor</option>
        <option value="Çözüldü">🟢 Çözüldü</option>
        <option value="Reddedildi">⚫ Reddedildi</option>
      </select>
      <button class="btn-sm" style="padding: 6px 14px;" onclick="updateTicketStatus()">Kaydet</button>
    </div>
  </div>
</div>

<script>
  let activeTicketId = null;

  function openReviewModal(id, title, user, status, description) {
    activeTicketId = id;
    document.getElementById('mTitle').textContent = title;
    document.getElementById('mIdVal').textContent = '#' + id;
    document.getElementById('mUserVal').textContent = user;
    document.getElementById('mDescVal').textContent = description;
    document.getElementById('statusSelect').value = status;

    // Reset Chat Box with student's original message and initial response
    const chatBox = document.getElementById('reviewChatBox');
    chatBox.innerHTML = `
      <div class="msg msg-user">
        <div class="msg-bubble">${description}</div>
        <div class="msg-meta">${user} · Başvuru Mesajı</div>
      </div>
    `;

    document.getElementById('reviewModalOverlay').classList.add('open');
  }

  function closeReviewModal() {
    document.getElementById('reviewModalOverlay').classList.remove('open');
    activeTicketId = null;
  }

  // Modal overlay click to close
  document.getElementById('reviewModalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeReviewModal();
  });

  function sendStaffReply() {
    const input = document.getElementById('replyInput');
    const text = input.value.trim();
    if (!text) return;

    const chatBox = document.getElementById('reviewChatBox');
    const now = new Date().toLocaleTimeString('tr-TR', { hour: '2-digit', minute: '2-digit' });

    chatBox.innerHTML += `
      <div class="msg msg-support">
        <div class="msg-bubble">${text}</div>
        <div class="msg-meta">Siz (Personel) · ${now}</div>
      </div>
    `;
    input.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  // Handle Enter to reply
  document.getElementById('replyInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') sendStaffReply();
  });

  function updateTicketStatus() {
    if (!activeTicketId) return;
    const newStatus = document.getElementById('statusSelect').value;
    
    // Find matching ticket card in UI and update it
    const ticketRow = document.querySelector(`.ticket-row[data-id="${activeTicketId}"]`);
    if (ticketRow) {
      ticketRow.setAttribute('data-status', newStatus);
      
      // Update badge in UI
      const badgeContainer = ticketRow.querySelector('.badge');
      if (newStatus === 'Açık') {
        badgeContainer.style = 'background:#EF4444;color:white;';
        badgeContainer.textContent = 'Açık';
        ticketRow.className = 'ticket-row acik';
      } else if (newStatus === 'İnceleniyor') {
        badgeContainer.style = 'background:#F59E0B;color:white;';
        badgeContainer.textContent = 'İnceleniyor';
        ticketRow.className = 'ticket-row inceleniyor';
      } else if (newStatus === 'Çözüldü') {
        badgeContainer.style = 'background:#10B981;color:white;';
        badgeContainer.textContent = 'Çözüldü';
        ticketRow.className = 'ticket-row cozuldu';
      } else if (newStatus === 'Reddedildi') {
        badgeContainer.style = 'background:#6B7280;color:white;';
        badgeContainer.textContent = 'Reddedildi';
        ticketRow.className = 'ticket-row reddedildi';
      }
    }

    recalculateStats();
    closeReviewModal();
    alert('Başvuru durumu başarıyla güncellendi.');
  }

  function recalculateStats() {
    const tickets = document.querySelectorAll('.ticket-row');
    let total = tickets.length;
    let pending = 0;
    let solved = 0;

    tickets.forEach(ticket => {
      const status = ticket.getAttribute('data-status');
      if (status === 'Açık' || status === 'İnceleniyor') {
        pending++;
      } else if (status === 'Çözüldü') {
        solved++;
      }
    });

    document.getElementById('totalCount').textContent = total;
    document.getElementById('pendingCount').textContent = pending;
    document.getElementById('solvedCount').textContent = solved;
  }
</script>

</body>
</html>
