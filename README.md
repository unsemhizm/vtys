# 🎓 Kampüs Çözüm Merkezi (VTYS Projesi)

**Kampüs Çözüm Merkezi**, üniversite kampüsündeki öğrencilerin, idari/akademik personelin ve sistem yöneticilerinin (admin) etkileşimde bulunabileceği, kampüs içi sorunların ve taleplerin hızlıca iletilip çözüme kavuşturulduğu kapsamlı bir bilet (ticket) yönetim sistemidir. 

Bu proje, **Veritabanı Yönetim Sistemleri (VTYS)** dersi kapsamında geliştirilmiştir.

---

## 🏗️ Proje Mimarisi (MVC)
Proje, kod okunabilirliğini artırmak, bakımı kolaylaştırmak ve güvenlik açıklarını en aza indirmek amacıyla modern bir **MVC (Model-View-Controller)** mimarisi kullanılarak sıfırdan PHP ile geliştirilmiştir.

- **Model (`app/models`):** Veritabanı sorgularının (SQL) yapıldığı, verilerin işlendiği katman. PDO (PHP Data Objects) ile SQL Injection saldırılarına karşı güvenli hale getirilmiştir.
- **View (`app/views`):** Kullanıcıların gördüğü arayüz (HTML/CSS) dosyalarının bulunduğu katman.
- **Controller (`app/controllers`):** Kullanıcıdan gelen isteklerin (URL ve Form postları) alındığı, Model ile View arasında köprü görevi gören, oturum (session) ve yetki kontrollerinin yapıldığı beyin katmanıdır.

---

## 🚀 Teknolojiler ve Araçlar
- **Backend:** PHP (Nesne Yönelimli - OOP)
- **Veritabanı:** MySQL (İlişkisel Veritabanı Tasarımı - RDBMS)
- **Frontend:** HTML5, CSS3 (Custom CSS, Flexbox/Grid), Vanilla JavaScript
- **Veritabanı Bağlantısı:** PDO (Prepared Statements kullanılmıştır)

---

## ✨ Temel Özellikler

### 1. Rol Bazlı Yetkilendirme (RBAC)
Sistemde 3 farklı kullanıcı rolü bulunmaktadır:
- **Öğrenci:** Yeni talep (bilet) oluşturabilir, durumunu takip edebilir ve çözümlenen taleplerine verilen yanıtları görebilir.
- **Personel:** Kendi birimine (Örn: Bilgi İşlem, Öğrenci İşleri) atanan biletleri görür, incelemeye alır, yanıtlar ve çözer.
- **Admin (Sistem Yöneticisi):** Sistemin tamamına hakimdir. Yeni kullanıcı/birim ekleyebilir, biletleri silebilir veya hızlı durum güncellemesi yapabilir. Tüm sistemin istatistiksel özetini görür.

### 2. Gelişmiş İstatistikler ve Raporlama (Admin Panel)
- Çözüm oranları hesaplaması.
- Kategori yük analizleri (En çok talep gelen alanlar).
- Birim bazlı performans ölçümleri (Hangi birim ne kadar bilet çözmüş).
- Dönemsel trendler (Son 7 gün, son 30 günlük bilet yoğunluğu).

### 3. İlişkisel Veritabanı Özellikleri
- Veritabanı 7 adet birbiriyle ilişkili tablodan (`basvurular`, `birimler`, `kategoriler`, `kullanicilar`, `roller`, `durumlar`, `yanitlar`) oluşmaktadır.
- Tablolar arası **Foreign Key** kısıtlamaları uygulanmıştır.
- `ON DELETE CASCADE` ile çöp verilerin (silinen kullanıcının başvurusunun kalması vb.) önüne geçilmiştir.

---

## 🛠️ Kurulum Adımları

Projeyi kendi bilgisayarınızda (localhost) çalıştırmak için aşağıdaki adımları izleyin:

1. **XAMPP / WAMPP Kurulumu:** 
   Bilgisayarınızda XAMPP veya benzeri bir yerel sunucu yüklü olmalıdır. Apache ve MySQL servislerini başlatın.

2. **Dosyaları Dizine Çıkarma:**
   Proje dosyalarını `C:\xampp\htdocs\vtys` dizini içerisine kopyalayın.

3. **Veritabanı İçeri Aktarımı (Import):**
   - Tarayıcınızdan `http://localhost/phpmyadmin` adresine gidin.
   - `kampus_cozum_merkezi` adında **UTF-8 (utf8mb4_unicode_ci)** karakter setine sahip yeni bir veritabanı oluşturun.
   - İçe Aktar (Import) sekmesinden proje klasöründeki (`proje/kampus_cozum_merkezi.sql`) dosyasını seçip içeri aktarın. (Eğer SQL dosyasında CREATE DATABASE komutu varsa direkt import da yapabilirsiniz).

4. **Bağlantı Ayarları:**
   Eğer MySQL şifreniz `root` ve şifresiz değilse, `proje/config/config.php` dosyasını açıp `$password` ve `$username` kısımlarını kendi sisteminize göre düzenleyin.

5. **Çalıştırma:**
   Tarayıcınıza `http://localhost/vtys/proje` veya `http://localhost/vtys/proje/public` yazarak projeye giriş yapabilirsiniz.

---

## 🔐 Örnek Giriş Bilgileri (Test İçin)

Veritabanı içeri aktarıldığında bazı test kullanıcıları da gelecektir. (Şifrelerin tümü: **123456**)

| Kullanıcı Rolü | E-Posta |
| :--- | :--- |
| **Admin** | admin@kampus.edu.tr |
| **Öğrenci** | yusuf.can@ogrenci.kampus.edu.tr |
| **Personel** | eng.sekreter@kampus.edu.tr |

---
*Bu proje, ilişkisel veritabanı teorilerinin web programlama ile nasıl entegre edileceğini göstermek amacıyla hazırlanmıştır.*