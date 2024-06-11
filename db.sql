USE DB;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(220) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,  -- Aumentamos o tamanho para armazenar o hash
  tipo ENUM('administrador', 'Usuario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE usuarios MODIFY tipo ENUM('administrador', 'gerente', 'usuario'); 

CREATE TABLE IF NOT EXISTS historico_login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    endereco_ip VARCHAR(45),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE session (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    valor TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE USER 'admin'@'localhost' IDENTIFIED BY '$2y$10$cwqHRaQaRfE7pdDsfJydtezzTHhRshmsRnM7s8cGQ/p9wqLDCuwd.';
GRANT ALL PRIVILEGES ON DB.* TO 'admin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

SELECT user, host FROM mysql.user WHERE user = 'admin' AND host = 'localhost';

CREATE USER 'gerente'@'localhost' IDENTIFIED BY '$2y$10$VPt6.t5pxC2ma/6ukvNoJOD44t91hmQoQDFWIPcc0bYGaPoAC.ofu';
GRANT SELECT, INSERT, UPDATE, DELETE ON DB.* TO 'gerente'@'localhost'; 
FLUSH PRIVILEGES;

SELECT user, host FROM mysql.user WHERE user = 'gerente' AND host = 'localhost';

CREATE USER 'usuario'@'localhost' IDENTIFIED BY '$2y$10$g0vVEfbtJfO8q.mFYRM4zOajX9Tat59m.hzevjDeLpvdNyauD0Q3i';
GRANT SELECT, INSERT ON DB.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;

CREATE USER 'usuario'@'localhost' IDENTIFIED BY '$2y$10$8VWtXsfAu/ikPeQltNYBO.x3HbapoYVWhpklHplSWeuwGGMYBy5oC';
GRANT SELECT, INSERT ON DB.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;

CREATE USER 'usuario'@'localhost' IDENTIFIED BY '$2y$10$Eig99/lwCXIXoDhLzaNmSuGR6y9pCMY0Q93rqKtfuTr80dR52ZflG';
GRANT SELECT, INSERT ON DB.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;

SELECT user, host FROM mysql.user WHERE user = 'usuario' AND host = 'localhost';

DROP FUNCTION IF EXISTS hash_password;

DELIMITER //

CREATE FUNCTION hash_password(pwd VARCHAR(255))
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    RETURN SHA2(pwd, 256);
END //

DELIMITER ;

DROP TRIGGER IF EXISTS tr_historico_login_insert;

DELIMITER //

CREATE TRIGGER tr_historico_login_insert
AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    -- Acessando a variável de sessão do IP
    SET @ip_cliente = (SELECT valor FROM session WHERE name = 'ip_cliente');

    INSERT INTO historico_login (usuario_id, endereco_ip) VALUES (NEW.id, @ip_cliente);
END //

DELIMITER ;

UPDATE usuarios SET tipo = 'administrador' WHERE id = 1;
UPDATE usuarios SET tipo = 'usuario' WHERE id != 1;
UPDATE usuarios SET tipo = 'gerente' WHERE id = 3;

select * from usuarios;
select * from historico_login;