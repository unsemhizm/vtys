// =============================================
//  YENİ BAŞVURU — yeni_basvuru.js
// =============================================

let ticketCounter = 130;

// Dosya adı göster
document.getElementById('fileInput').addEventListener('change', function () {
  const name = this.files[0] ? this.files[0].name : '';
  document.getElementById('fileName').textContent = name ? '📄 ' + name : '';
});

// Form submit
document.getElementById('basvuruForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const title    = document.getElementById('title').value;
  const category = document.getElementById('category').value;

  // Tabloya ekle
  const tbody = document.getElementById('ticketBody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>${ticketCounter++}</td>
    <td>${title}</td>
    <td>${category}</td>
    <td><span class="badge badge-open">Açık</span></td>
    <td><a href="basvurularim.html" class="btn-sm">Detay</a></td>
  `;
  tbody.prepend(tr);

  // Toast göster
  showToast('✅ Başvurunuz başarıyla gönderildi!');

  // Formu temizle
  this.reset();
  document.getElementById('fileName').textContent = '';
});

// Toast yardımcı fonksiyon
function showToast(msg) {
  const toast = document.getElementById('toast');
  toast.textContent = msg;
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3000);
}