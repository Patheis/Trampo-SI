use DB;
drop table usuarios;
CREATE TABLE `usuarios` (
  `id` SERIAL,
  `usuario` varchar(220) NOT NULL,
  `senha` varchar(220) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

SELECT * FROM usuarios;

DELETE FROM usuarios WHERE id = 5;

INSERT INTO usuarios (usuario, senha) 
VALUES ('admin', '123');

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);