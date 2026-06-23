# 📝 PHP & MySQL To-Do List Application

Modern, hafif ve kullanıcı dostu bir Yapılacaklar Listesi (To-Do List) web uygulaması. PHP ve MySQL (PDO) kullanılarak geliştirilmiş olup, kullanıcı deneyimini artırmak için satır içi düzenleme (inline editing) ve SweetAlert2 animasyonları ile desteklenmiştir.

## ✨ Özellikler

- **Satır İçi Düzenleme (Inline Editing):** Sayfa yenilenmeden, doğrudan liste üzerinden görev güncelleyebilme.
- **Akıllı Zaman Takibi:** Görevlerin eklenme ve (eğer değiştirildiyse) güncellenme tarihlerini dinamik olarak gösterme.
- **Modern Bildirimler:** İşlem sonuçlarını (başarılı ekleme, silme, güncelleme) bildiren şık **SweetAlert2** popup animasyonları.
- **Güvenli Altyapı:** SQL Injection saldırılarına karşı PDO (PHP Data Objects) ve Prepared Statements kullanımı. XSS koruması için veri filtreleme.
- **Tamamlanmış Görevler:** Biten görevlerin üstünü çizme ve bitiş zamanını kaydetme.

## 🛠️ Kullanılan Teknolojiler

- **Backend:** PHP 8+
- **Veritabanı:** MySQL / SQLite (PDO)
- **Kütüphaneler:** [SweetAlert2](https://sweetalert2.github.io/) (Animasyonlu Popup'lar için)

## SQL
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    is_completed TINYINT(1) DEFAULT 0,
    tarih DATETIME DEFAULT CURRENT_TIMESTAMP,
    bitirme_tarihi DATETIME DEFAULT NULL,
    guncelleme_tarihi DATETIME DEFAULT NULL
);
