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

function openModal(id, title, status, cat, date) {
  // 1. Üst bilgileri doldur
  document.getElementById('modalTitle').textContent = title;
  document.getElementById('mId').textContent    = '#' + id;
  document.getElementById('mStatus').textContent = status;
  document.getElementById('mCat').textContent    = cat;
  document.getElementById('mDate').textContent   = date;
  
  const chatBox = document.getElementById('chatMessages');
  
  // 2. Önceki statik mesajları temizle ve yükleniyor yazısı koy
  chatBox.innerHTML = '<div style="text-align:center; padding:10px; color:#666;">Mesajlar yükleniyor...</div>';
  
  // Modalı ekranda göster
  document.getElementById('modalOverlay').classList.add('open');

  // 3. PHP (Backend) tarafına bu bilet ID'sini gönderip o biletin yanıtlarını çekiyoruz
  fetch(`index.php?controller=bilet&action=mesajlariGetir&id=${id}`)
    .then(response => response.json()) // PHP'den JSON formatında veri bekliyoruz
    .then(data => {
      chatBox.innerHTML = ''; // Yükleniyor yazısını kaldır
      
      // Eğer veritabanında bu bilet için hiç mesaj yoksa:
      if (!data || data.length === 0) {
        chatBox.innerHTML = '<div style="text-align:center; padding:10px; color:#666;">Henüz mesaj yok.</div>';
        return;
      }

      // Veritabanından gelen mesajları döngüyle senin tasarımına uygun (msg-user / msg-support) ekrana basıyoruz
      data.forEach(mesaj => {
        // gonderenTuru 'ogrenci' ise sağa, 'personel' ise sola yasla
        const msgClass = mesaj.gonderenTuru === 'ogrenci' ? 'msg-user' : 'msg-support';
        const senderName = mesaj.gonderenTuru === 'ogrenci' ? 'Siz' : 'Destek Ekibi';
        
        chatBox.innerHTML += `
          <div class="msg ${msgClass}">
            <div class="msg-bubble">${mesaj.metin}</div>
            <div class="msg-meta">${senderName} · ${mesaj.tarih}</div>
          </div>`;
      });
      
      // Kaydırma çubuğunu en alta indir
      chatBox.scrollTop = chatBox.scrollHeight;
    })
    .catch(err => {
      console.error("Mesajlar çekilemedi: ", err);
      chatBox.innerHTML = '<div style="text-align:center; color:red;">Mesajlar yüklenirken bir hata oluştu. Henüz backend bağlanmamış olabilir.</div>';
    });
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