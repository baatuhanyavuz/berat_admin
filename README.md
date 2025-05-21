# berat_adminuser tablosunu olusturmak icin bu scripti calistir,

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

admin tablosu icin bu script calistir,

CREATE TABLE  admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);


db baglantisi icin db.php dosyasinindaki configi kendine gore ayarla, ben db adini admin_db yaptim


ilk giriste admin eklemek icin bu sorguyu calistirmalisin;
INSERT INTO admin (username, password) VALUES ('berat', '123')

(hoca nasil ister bilmiyorum, seed.php olusturursan ve ilk olarak seed.php sayfasini baslatirsann, her seyi otomatik de yapar. db tablolarini olusturur, admin kullanicisi ekler)

anlamadigin bi yer olursa sorarsin :*