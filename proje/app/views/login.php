<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fırat Üniversitesi Kampüs Çözüm Merkezi</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>

<!-- LANDING NAVIGATION -->
<header class="landing-header">
  <div class="header-inner">
    <div class="header-logo">
      <div class="logo-circle">FÜ</div>
      <div>
        <h1 style="color: #fff;">Kampüs Çözüm Merkezi</h1>
        <span>Fırat Üniversitesi</span>
      </div>
    </div>
    <div class="header-right" style="display: flex; gap: 10px;">
      <button id="secretAdminBtn" class="btn-primary" style="display: none; padding: 0.5rem 1.4rem; font-size: 0.85rem; border-radius: 20px; background: #dc3545;" onclick="openAdminModal()">Admin Girişi</button>
      <button class="btn-primary" style="padding: 0.5rem 1.4rem; font-size: 0.85rem; border-radius: 20px; background: var(--accent);" onclick="openLoginModal()">Giriş Yap</button>
    </div>
  </div>
</header>

<!-- HERO SECTION -->
<section class="landing-hero">
  <h1>Fırat Üniversitesi<br/>Kampüs Çözüm Merkezi</h1>
  <p>Üniversitemiz bünyesindeki taleplerinizi, şikayetlerinizi ve önerilerinizi dijitalleştirerek bürokrasiyi ortadan kaldırıyoruz. Sorunlarınızı doğrudan ilgili birimlere iletin ve süreçleri anlık olarak takip edin.</p>
  <div>
    <button class="btn-landing-primary" onclick="openLoginModal()">Sisteme Giriş Yap</button>
    <a href="#features" class="btn-landing-secondary">Daha Fazla Bilgi</a>
  </div>
</section>

<!-- MAIN CONTENT / FEATURES -->
<main class="section-padding" id="features" style="padding-top: 3rem;">
  <div class="section-header">
    <h2>Neden Kampüs Çözüm Merkezi?</h2>
    <p>Akademik ve idari tüm süreçleri daha şeffaf, daha hızlı ve daha etkili yönetmek için tasarlanan kurumsal otomasyon sistemi.</p>
  </div>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon-wrapper">⚡</div>
      <h3>Hızlı Çözüm</h3>
      <p>Oluşturduğunuz talepler, aracı bürokratik aşamalar olmadan doğrudan ilgili dekanlık veya daire başkanlığına anında iletilir.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon-wrapper">👥</div>
      <h3>Rol Tabanlı Erişim</h3>
      <p>Öğrenci, Personel ve Yönetici (Admin) rolleri için özelleştirilmiş gelişmiş arabirimler ile güvenli ve hiyerarşik iş akışları.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon-wrapper">📋</div>
      <h3>Şeffaf Takip</h3>
      <p>Başvurularınızın durumunu (Beklemede, İnceleniyor, Çözüldü, Reddedildi) anlık olarak bilet sistemi üzerinden izleyin.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon-wrapper">💬</div>
      <h3>Çift Yönlü Mesajlaşma</h3>
      <p>Taleplerinizin detay sayfasında birim personelleriyle anlık mesajlaşarak eksik belgeleri veya ek bilgileri kolayca paylaşın.</p>
    </div>
  </div>

  <!-- STATS PREVIEW -->
  <div class="cta-stats" style="margin-top: 4rem; padding: 2rem 3rem;">
    <div>
      <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--primary-dark); margin-bottom: 0.5rem;">Üniversitemiz İçin Hep Daha İyisine</h3>
      <p style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600; max-width: 600px; margin: 0;">Fırat Üniversitesi Kampüs Çözüm Merkezi ile bugüne kadar binlerce talebe başarıyla cevap verdik, süreçleri şeffaflaştırdık.</p>
    </div>
    <div class="stats">
      <div class="stat">
        <div class="stat-num green">1540+</div>
        <div class="stat-label">Çözülen Başvuru</div>
      </div>
      <div class="stat">
        <div class="stat-num">121</div>
        <div class="stat-label">Aktif İnceleme</div>
      </div>
    </div>
  </div>
</main>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-col">
      <h4>📍 Fırat Üniversitesi</h4>
      <p>0424.300.1666<br />0424.219.376<br />email.firat@gmail.com</p>
    </div>
    <div class="footer-col">
      <h4>📍 Lojent</h4>
      <p>Fırat Üniversitesi<br />Fırat Üniversitesi</p>
    </div>
    <div class="footer-col">
      <h4>📍 Loonmate</h4>
      <p>Kampüs Çözüm Merkezi<br />Camino: 73225001</p>
    </div>
  </div>
  <div class="footer-bottom">© 2024 Kampüs Çözüm Merkezi — HTML, CSS, JavaScript</div>
</footer>

<!-- INTERACTIVE LOGIN MODAL OVERLAY -->
<div class="login-modal-overlay" id="loginModal">
  <div class="login-container">
    <button class="modal-close-btn" onclick="closeLoginModal()">✕</button>
    
    <div class="login-brand">
      <div class="brand-logo">FÜ</div>
      <h2 class="brand-name">Kampüs Çözüm Merkezi</h2>
      <p class="brand-subtitle">Fırat Üniversitesi Portal Girişi</p>
    </div>

    <div class="login-tabs">
      <button class="tab-btn active" id="tab-student" onclick="switchTab('student')">
        <span>🎓</span> Öğrenci Girişi
      </button>
      <button class="tab-btn" id="tab-staff" onclick="switchTab('staff')">
        <span>👤</span> Personel Girişi
      </button>
      <button class="tab-btn" id="tab-admin" style="display: none;" onclick="switchTab('admin')">
        <span>🔑</span> Yönetici
      </button>
    </div>

    <?php if(isset($data['hata']) && !empty($data['hata'])): ?>
        <div id="errorBox" class="error-msg" style="display:block;"><?php echo $data['hata']; ?></div>
    <?php else: ?>
        <div id="errorBox" class="error-msg" style="display:none;"></div>
    <?php endif; ?>

    <div class="login-form-wrapper">
      <div class="login-form-wrapper">
      <form id="studentForm" class="login-form active" method="POST" action="index.php?controller=auth&action=login">
        <input type="hidden" name="rol" value="student">
        
        <div class="input-group">
          <label>Öğrenci E-postası</label>
          <div class="input-wrapper">
            <span class="input-icon">📧</span>
            <input type="email" name="eposta" id="studentEmail" placeholder="yusuf.can@ogrenci.kampus.edu.tr" required />
          </div>
        </div>
        
        <div class="input-group">
          <label>Şifre</label>
          <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" name="sifre" id="studentPass" placeholder="••••••••" required />
          </div>
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" checked /> Beni Hatırla
          </label>
          <a href="#" class="forgot-pass">Şifremi Unuttum</a>
        </div>

        <button type="submit" class="btn-login">Giriş Yap</button>
      </form>

      <form id="staffForm" class="login-form" method="POST" action="index.php?controller=auth&action=login">
        <input type="hidden" name="rol" value="staff">
        
        <div class="input-group">
          <label>Personel E-postası</label>
          <div class="input-wrapper">
            <span class="input-icon">📧</span>
            <input type="email" name="eposta" id="staffEmail" placeholder="ogris.gorevli@kampus.edu.tr" required />
          </div>
        </div>
        
        <div class="input-group">
          <label>Şifre</label>
          <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" name="sifre" id="staffPass" placeholder="••••••••" required />
          </div>
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" checked /> Beni Hatırla
          </label>
          <a href="#" class="forgot-pass">Şifremi Unuttum</a>
        </div>

        <button type="submit" class="btn-login">Giriş Yap</button>
      </form>

      <form id="adminForm" class="login-form" method="POST" action="index.php?controller=auth&action=login">
        <input type="hidden" name="rol" value="admin">
        
        <div class="input-group">
          <label>Yönetici E-postası</label>
          <div class="input-wrapper">
            <span class="input-icon">📧</span>
            <input type="email" name="eposta" id="adminEmail" placeholder="admin@kampus.edu.tr" required />
          </div>
        </div>
        
        <div class="input-group">
          <label>Şifre</label>
          <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" name="sifre" id="adminPass" placeholder="••••••••" required />
          </div>
        </div>

        <button type="submit" class="btn-login" style="background: #dc3545; box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4); margin-top: 1rem;">Sistem Yöneticisi Girişi</button>
      </form>
    </div>
    </div>

    <div class="demo-info">
      <p>💡 Kolay Test Giriş Bilgileri:</p>
      <ul id="credentialsList">
        <li><strong>Öğrenci:</strong> yusuf.can@ogrenci.kampus.edu.tr (Şifre: sifre123)</li>
        <li><strong>Personel:</strong> ogris.gorevli@kampus.edu.tr (Şifre: sifre123)</li>
        <li id="demoAdminItem" style="display: none; color: #dc3545;"><strong>Admin:</strong> admin@kampus.edu.tr (Şifre: sifre123)</li>
      </ul>
    </div>
  </div>
</div>

<script>
  // Modal toggle mechanisms
  function openLoginModal() {
    // Sadece standart butonla açıldığında admin sekmesini gizle ve öğrenciye dön
    document.getElementById('tab-admin').style.display = 'none';
    document.getElementById('demoAdminItem').style.display = 'none';
    switchTab('student');
    
    document.getElementById('loginModal').classList.add('open');
    document.body.style.overflow = 'hidden'; // prevent background scrolling
  }

  function openAdminModal() {
    // Özel admin butonu ile açıldığında admin sekmesini göster ve seç
    document.getElementById('tab-admin').style.display = 'flex';
    document.getElementById('demoAdminItem').style.display = 'block';
    
    document.getElementById('loginModal').classList.add('open');
    document.body.style.overflow = 'hidden';
    switchTab('admin');
  }

  function closeLoginModal() {
    document.getElementById('loginModal').classList.remove('open');
    document.body.style.overflow = '';
  }

  // Close modal when clicking outside the modal box
  document.getElementById('loginModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeLoginModal();
    }
  });

  function switchTab(role) {
    const tabStudent = document.getElementById('tab-student');
    const tabStaff = document.getElementById('tab-staff');
    const tabAdmin = document.getElementById('tab-admin');
    const studentForm = document.getElementById('studentForm');
    const staffForm = document.getElementById('staffForm');
    const adminForm = document.getElementById('adminForm');
    const errorBox = document.getElementById('errorBox');
    
    errorBox.style.display = 'none';

    // Reset all tabs
    tabStudent.classList.remove('active');
    tabStaff.classList.remove('active');
    tabAdmin.classList.remove('active');
    studentForm.classList.remove('active');
    staffForm.classList.remove('active');
    adminForm.classList.remove('active');

    if (role === 'student') {
      tabStudent.classList.add('active');
      studentForm.classList.add('active');
    } else if (role === 'staff') {
      tabStaff.classList.add('active');
      staffForm.classList.add('active');
    } else if (role === 'admin') {
      tabAdmin.classList.add('active');
      adminForm.classList.add('active');
    }
  }


  function showError(msg) {
    const errorBox = document.getElementById('errorBox');
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
  }

  // Secret Key Combination (Easter Egg)
  let secretCode = "admin";
  let inputSequence = "";
  let adminBtnTimer = null;

  document.addEventListener('keydown', function(e) {
    // Ignore if typing in input fields
    if (e.target.tagName.toLowerCase() === 'input' || e.target.tagName.toLowerCase() === 'textarea') return;

    inputSequence += e.key.toLowerCase();
    
    // Keep sequence length same as secret code
    if (inputSequence.length > secretCode.length) {
      inputSequence = inputSequence.substring(1);
    }

    if (inputSequence === secretCode) {
      const adminBtn = document.getElementById('secretAdminBtn');
      adminBtn.style.display = 'block'; // Show button
      
      // Clear sequence to prevent multiple triggers
      inputSequence = "";

      // Clear existing timer if triggered again
      if (adminBtnTimer) clearTimeout(adminBtnTimer);

      // Hide after 10 seconds
      adminBtnTimer = setTimeout(() => {
        adminBtn.style.display = 'none';
      }, 10000);
    }
  });
</script>
<?php if(isset($data['hata']) && !empty($data['hata'])): ?>
    <script>
        // Eğer PHP'den bir hata geldiyse, sayfa yüklenir yüklenmez modalı OTOMATİK AÇ!
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('loginModal').classList.add('open');
            document.body.style.overflow = 'hidden';
            
            // Formları aktif edelim
            document.getElementById('tab-student').classList.add('active');
            document.getElementById('studentForm').classList.add('active');
            
            // Hatayı ekrana basıp görünür yapalım (eski JS'nin gizlemesini eziyoruz)
            const errorBox = document.getElementById('errorBox');
            errorBox.innerHTML = "<strong>Hata:</strong> <?php echo $data['hata']; ?>";
            errorBox.style.display = 'block';
        });
    </script>
    <?php endif; ?>
</body>
</html>