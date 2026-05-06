# YMÜ-232 Veritabanı Yönetim Sistemleri: Kampüs Çözüm Merkezi Yol Haritası

Bu doküman, Kampüs Çözüm Merkezi projesinin "basit" görünümden kurtulup, dersin gereksinimlerini karşılayan, normalize edilmiş, modüler ve kurumsal bir otomasyon sistemine dönüştürülmesi için hazırlanmış adım adım eylem planıdır.

---

## 1. Veritabanı Revizyonu (Normalizasyon - İlk Adım)
Hocanın "Rolleri neden ENUM yaptın?" eleştirisini çözmek ve sistemi esnekleştirmek için veritabanı şeması güncellenecektir. Veritabanı en az 5 tablodan oluşma kuralını fazlasıyla karşılayacak şekilde 7 ana tabloya çıkarılmıştır.

**Yapılacak Güncellemeler:**
* **`Roles` Tablosu Eklenecek:** Öğrenci, Personel, Admin rolleri sabit `ENUM` yerine `RoleID` ve `RoleName` olarak ayrı bir tabloya alınacak. `Users` tablosu bu tabloya Foreign Key ile bağlanacak.
* **`Statuses` Tablosu Eklenecek:** Bilet durumları (Açık, Çözüldü vb.) ayrı tabloya taşınacak ve arayüz için `ColorCode` kolonu eklenecek.
* **İlişkiler (Foreign Keys):** `Tickets` tablosu merkeze alınarak; `UserID`, `CategoryID`, `DepartmentID` ve `StatusID` ile tam bağlantılı hale getirilecek.
* **Dosya Yönetimi:** `Responses` tablosundaki `AttachmentPath` alanına ek olarak, arka planda dosya boyutu ve uzantı (PDF, JPG) kontrolleri yazılacak.

---

## 2. Yazılım Mimarisi ve Klasör Yapısı (MVC)
Frontend tarafı saf HTML, CSS ve JavaScript ile yazılacağı için, PHP backend'i spagetti koddan kurtarıp profesyonel bir yapıya oturtmak şarttır.

**Klasör Ağacı Hedefi:**
* `/app/controllers`: İş mantığının döndüğü yer (BiletController.php, AuthController.php).
* `/app/models`: Veritabanı SQL sorgularının (`SELECT`, `INSERT`) bulunduğu dosyalar.
* `/app/views`: HTML dosyalarının çağrıldığı alan (Frontend ekibinin çalışacağı yer).
* `/public`: CSS, JS, Resimler ve yönlendirici `index.php`.

---

## 3. Sistem Modülleri (Hocanın Beklentisi)
Projede yer alan iş parçacıkları (modüller) şu şekilde tanımlanacak ve paylaşılacaktır:

### A. Kimlik Doğrulama ve Rol Modülü
* Kullanıcıların e-posta ve şifre ile giriş yapması.
* Giriş yapan kişinin `RoleID`'sine göre yetkilendirme yapılarak Admin, Personel veya Öğrenci paneline yönlendirilmesi.

### B. Bilet (Ticket) Yönetim Modülü
* **Öğrenci:** Yeni talep oluşturma (Kategori ve Birim seçerek), kendi taleplerini listeleme.
* **Personel:** Sadece kendi `DepartmentID`'sine düşen talepleri görebilme, talebin `StatusID`'sini güncelleyebilme.

### C. İletişim ve Mesajlaşma Modülü
* Biletlerin içine `Responses` tablosu üzerinden yanıt yazılabilmesi.
* *Teknik Karar:* Proje yerelde çalışacağı ve frontend basit tutulacağı için, ilk etapta **AJAX Long Polling** (belirli saniyelerde bir veritabanını JavaScript ile sorgulama) kullanılarak anlık mesajlaşma simüle edilecek. Vakit kalırsa WebSocket entegrasyonu denenecek.

### D. Admin Paneli ve Raporlama Modülü
Sistemin kurumsallığını gösterecek en önemli kısımdır. Kullanıcının erişemeyeceği kapalı bir panel olacaktır.
* **Kullanıcı Yönetimi:** Sisteme yeni personel/öğrenci ekleme, silme, güncelleme.
* **Sistem Yönetimi:** Yeni Departman ve Kategori ekleme/çıkarma yetkisi.
* **İstatistik Dashboard:** SQL `COUNT` ve `GROUP BY` sorguları kullanılarak; toplam bilet sayısı, çözülme oranı, en çok şikayet alan kategori/birim grafiklerinin gösterilmesi.

---

## 4. Ekip İçi Görev Dağılımı ve Çalışma Planı
3 kişilik bir grup olmanın avantajı eşzamanlı ilerleyebilmektir.

* **Üye 1 (Veritabanı & Backend Lideri):** Normalizasyonlu SQL tablolarını kurmak. Veritabanı bağlantılarını (PDO) ve Model (`/app/models`) sınıflarını yazmak. 
* **Üye 2 (Frontend & Arayüz):** Ana sayfa tasarımı (İstatistikler, arama, kategoriler), HTML/CSS/JS ile Admin, Personel ve Öğrenci panellerinin şablonlarını oturtmak.
* **Üye 3 (Controller & Entegrasyon):** Backend'den gelen verileri Frontend'e bağlamak (`/app/controllers` inşası). AJAX isteklerini yazmak ve bilet içi mesajlaşma modülünü çalışır hale getirmek.

---

## 5. Teslim ve Dokümantasyon (Kritik)
Word dokümanı teslim edilmezse proje doğrudan sıfır sayılacağı için süreç içinde şu diyagramlar hazırlanacaktır:

1.  **Use Case Diyagramı:** Öğrenci, Personel ve Admin'in sistemdeki eylemlerini (bilet açma, yanıt verme, istatistik görme) gösteren şema.
2.  **Akış Diyagramı (Flowchart):** Bir talebin sisteme girip, personele ulaşıp, cevaplanıp, çözüldü statüsüne geçmesine kadar olan adım adım yolculuğu.
3.  **ER Diyagramı:** Normalizasyonu tamamlanmış, tüm PK ve FK bağlantılarının oklarla gösterildiği final veritabanı şeması.
4.  **Word Raporu:** Kullanılan mimarinin (MVC), yazılan özel modüllerin (AJAX tabanlı mesajlaşma) ve grup içi görev dağılımının detaylı anlatımı.