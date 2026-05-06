// =============================================
//  BAŞVURULARİM — basvurularim.js
// =============================================

// Filtre chip'leri
function filterTickets(status, el) {
  document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.ticket-card').forEach(card => {
    card.style.display = (status === 'tumu' || card.dataset.status === status) ? '' : 'none';
  });
}

// Modal aç
function openModal(id, title, status, cat, date) {
  document.getElementById('modalTitle').textContent = title;
  document.getElementById('mId').textContent    = '#' + id;
  document.getElementById('mStatus').textContent = status;
  document.getElementById('mCat').textContent    = cat;
  document.getElementById('mDate').textContent   = date;
  document.getElementById('modalOverlay').classList.add('open');
}

// Modal kapat (overlay tıklaması)
document.getElementById('modalOverlay').addEventListener('click', function (e) {
  if (e.target === this) closeModal();
});

// Modal kapat
function closeModal() {
  document.getElementById('modalOverlay').classList.remove('open');
}

// Chat mesaj gönder
function sendMsg() {
  const input = document.getElementById('chatInput');
  const text  = input.value.trim();
  if (!text) return;

  const box = document.getElementById('chatMessages');
  const now = new Date().toLocaleTimeString('tr-TR', { hour: '2-digit', minute: '2-digit' });

  box.innerHTML += `
    <div class="msg msg-user">
      <div class="msg-bubble">${text}</div>
      <div class="msg-meta">Siz · ${now}</div>
    </div>`;
  input.value = '';
  box.scrollTop = box.scrollHeight;

  setTimeout(() => {
    box.innerHTML += `
      <div class="msg msg-support">
        <div class="msg-bubble">Mesajınız alındı, ilgileniyoruz.</div>
        <div class="msg-meta">Destek Ekibi · ${now}</div>
      </div>`;
    box.scrollTop = box.scrollHeight;
  }, 1500);
}

// Enter tuşu ile mesaj gönder
document.getElementById('chatInput').addEventListener('keydown', function (e) {
  if (e.key === 'Enter') sendMsg();
});