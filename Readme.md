Таблицы для теста
CREATE TABLE 'tasks' ( 'id' INT(11) PRIMARY KEY AUTO_INCREMENT,
'username' VARCHAR(255) NOT NULL, 
'email' VARCHAR(255) NOT NULL, 
'description' TEXT NOT NULL, 
'ready' BOOL DEFAULT false, 
'edited' BOOL DEFAULT false);

CREATE TABLE 'users' ('id' INT(11) PRIMARY KEY AUTO_INCREMENT, 
'username' VARCHAR(255) NOT NULL, 'email' VARCHAR(255) NOT NULL, 
 'passwordHash VARCHAR(512) DEFAULT NULL,' isAdmin' BOOLEAN NOT NULL);

INSERT INTO users (username,email,passwordHash,isAdmin) VALUES
('admin','admin@email.test','$2y$10$qHgYVIPyX6BvaMGMqSiMKu3epWFtkRm6Pym6hecMCtmecGvKtpSJy',true);


Для установки Twig в директории lib/ необходимо выполнить команду ``composer require twig/twig``