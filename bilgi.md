# Kampüs Çözüm Merkezi - Veritabanı Projesi Bilgileri

## 1. Proje Hakkında
**Kampüs Çözüm Merkezi**, üniversite bünyesindeki öğrenci taleplerini dijitalleştirerek bürokrasiyi azaltmayı hedefleyen, ilişkisel veritabanı mimarisiyle kurgulanmış bir kurumsal otomasyon projesidir. Öğrencilerin şikayet ve önerilerini doğrudan ilgili dekanlık veya daire başkanlıklarına iletmelerine, süreçleri ise şeffaf bir biletleme (ticketing) mekanizmasıyla takip etmelerine olanak tanır. Rol tabanlı erişim kontrolü sayesinde admin, personel ve öğrenci panelleri arasında güvenli bir hiyerarşi kurar.

## 2. Ders ve Proje Gereksinimleri (PDF Özeti - YMÜ232)
* **Veritabanı Yapısı:** İlişkisel olarak tasarlanmış (veya NoSQL tercih edilebilir) olmalı ve **en az beş tablodan** oluşmalıdır.
* **Mimari:** Backend ve Frontend içermelidir. Kullanıcının erişemediği bir **admin panel** ve etkileşimli bir **frontend arabirim** bulunmalıdır.
* **Proje Grupları:** En fazla 3 kişilik gruplar halinde yapılabilir. Her bir modülün hangi grup üyesi tarafından yapılacağı belirtilmelidir.
* **Teslim Dokümanı:** Proje en son teslim edilirken veritabanından kullanıcı arabirimine kadar tüm otomasyonun anlatıldığı bir **Word dokümanı** teslim edilecektir. Dokümansız projeler doğrudan sıfır alacaktır.
* **Teknoloji:** Programlama dilleri, web teknolojileri ve veritabanı yönetim sistemi serbesttir. Ancak yazılan kodlara ve mimariye tam hakimiyet şarttır.

## 3. Seçilen Teknoloji Yığını (Tech Stack)
* **Backend:** PHP
* **Veritabanı:** MySQL
* **Mimari Yaklaşım:** PHP ile MySQL veritabanına bağlanılarak CRUD işlemleri (Ekleme, Okuma, Güncelleme, Silme) yapılacak ve ön yüzle (Frontend) iletişim kurulacaktır.

## 4. Veritabanı İlişki Şeması (ER Şeması)

Sistem, işleyişini 5 temel tablo üzerinden gerçekleştirmektedir. Tablolar, alanları ve veri tipleri aşağıda listelenmiştir. Kağıda çizim yaparken bu yapıyı kullanabilirsiniz.

### Tablo 1: Kullanıcılar (Users)
Sisteme giriş yapacak herkesi (Öğrenci, Personel, Admin) tutan ana tablodur.
* `UserID` : Integer **(Primary Key)** - Benzersiz kullanıcı kimliği.
* `FullName` : Varchar - Kullanıcının Adı ve Soyadı.
* `Email` : Varchar - Giriş için kullanılacak e-posta adresi.
* `Password` : Varchar - Şifrelenmiş parola.
* `Role` : Enum ('Ogrenci', 'Personel', 'Admin') - Kullanıcı rollerini belirler.
* `DepartmentID` : Integer **(Foreign Key)** - Personelin hangi birime ait olduğunu belirtir. (Öğrenciler için boş kalabilir).

### Tablo 2: Birimler / Fakülteler (Departments)
Taleplerin yönlendirileceği idari birimleri (Mühendislik Fakültesi, Öğrenci İşleri vb.) tanımlar.
* `DepartmentID` : Integer **(Primary Key)** - Benzersiz birim kimliği.
* `DeptName` : Varchar - Birim adı.
* `Location` : Varchar - Birimin kampüsteki yeri (Opsiyonel).

### Tablo 3: Kategoriler (Categories)
Başvuruların konusuna göre (Yemekhane, Altyapı, Sınavlar vb.) sınıflandırılmasını sağlar.
* `CategoryID` : Integer **(Primary Key)** - Benzersiz kategori kimliği.
* `CategoryName` : Varchar - Kategori adı.
* `Priority` : Enum ('Düşük', 'Orta', 'Yüksek') - Kategorinin varsayılan öncelik durumu.

### Tablo 4: Başvurular / Biletler (Tickets)
Öğrenciler tarafından oluşturulan taleplerin tutulduğu tablodur.
* `TicketID` : Integer **(Primary Key)** - Benzersiz başvuru numarası.
* `UserID` : Integer **(Foreign Key)** - Başvuruyu yapan öğrencinin ID'si.
* `CategoryID` : Integer **(Foreign Key)** - Talebin kategorisi.
* `DepartmentID` : Integer **(Foreign Key)** - Talebin iletildiği birim.
* `Title` : Varchar - Başvuru başlığı.
* `Description` : Text - Sorunun veya önerinin detaylı içeriği.
* `Status` : Enum ('Açık', 'İnceleniyor', 'Çözüldü', 'Reddedildi') - Başvuru durumu.
* `CreatedAt` : DateTime - Başvurunun yapıldığı tarih ve saat.

### Tablo 5: Mesajlar / Yanıtlar (Responses)
İdari kadronun öğrenciye verdiği cevapları ve eklenen belgeleri tutar.
* `ResponseID` : Integer **(Primary Key)** - Benzersiz yanıt kimliği.
* `TicketID` : Integer **(Foreign Key)** - Yanıtın hangi bilete ait olduğu.
* `ReplierID` : Integer **(Foreign Key)** - Yanıtlayan personelin / adminin ID'si (Users tablosuna bağlanır).
* `Message` : Text - Yanıtın içeriği.
* `AttachmentPath` : Varchar - Eklenen belgenin yolu.
* `SentAt` : DateTime - Yanıtın gönderildiği tarih ve saat.

## 5. Tablolar Arası İlişkiler (Bağlantılar)
Kağıda şemayı çizerken tablolar arasında oklarla göstermeniz gereken ilişkiler (Foreign Key -> Primary Key) şunlardır:

1. **`Users`** tablosundaki `DepartmentID` alanı ---> **`Departments`** tablosundaki `DepartmentID` alanına bağlanır. (Bir kullanıcı bir birime ait olabilir).
2. **`Tickets`** tablosundaki `UserID` alanı ---> **`Users`** tablosundaki `UserID` alanına bağlanır. (Bir bileti bir kullanıcı oluşturur).
3. **`Tickets`** tablosundaki `CategoryID` alanı ---> **`Categories`** tablosundaki `CategoryID` alanına bağlanır. (Bir bilet bir kategoriye aittir).
4. **`Tickets`** tablosundaki `DepartmentID` alanı ---> **`Departments`** tablosundaki `DepartmentID` alanına bağlanır. (Bir bilet bir birime atanır).
5. **`Responses`** tablosundaki `TicketID` alanı ---> **`Tickets`** tablosundaki `TicketID` alanına bağlanır. (Bir yanıt bir bilete verilir).
6. **`Responses`** tablosundaki `ReplierID` alanı ---> **`Users`** tablosundaki `UserID` alanına bağlanır. (Bir yanıtı bir kullanıcı yazar).
