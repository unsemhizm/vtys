// =============================================
//  PROFİL — profil.js
// =============================================

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3000);
}

function saveProfile() {
  showToast('✅ Kişisel bilgileriniz güncellendi!');
}

function changePass() {
  const p1 = document.getElementById('newPass').value;
  const p2 = document.getElementById('newPass2').value;
  if (!p1)       return showToast('⚠️ Yeni şifre boş olamaz!');
  if (p1 !== p2) return showToast('❌ Şifreler eşleşmiyor!');
  showToast('✅ Şifreniz başarıyla güncellendi!');
}

function deleteAccount() {
  alert('Bu işlem admin onayı gerektirir.');
}