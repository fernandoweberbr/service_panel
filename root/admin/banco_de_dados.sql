CREATE TABLE usuarios(
usuario_id int(5) NOT NULL auto_increment,
nome varchar(50) NOT NULL default '',
sobrenome varchar(50) NOT NULL default '',
email varchar(100) NOT NULL default '',
usuario varchar(32) NOT NULL default '',
senha varchar(32) NOT NULL default '',
info text NOT NULL,
nivel_usuario enum('0','1','2') NOT NULL default '0',
data_cadastro datetime NOT NULL default '0000-00-00 00:00:00',
data_ultimo_login datetime NOT NULL default '0000-00-00 00:00:00',
ativado enum('0','1') NOT NULL default '0',
PRIMARY KEY (usuario_id)
) ENGINE = MYISAM CHARACTER SET latin1 COLLATE latin1_general_ci COMMENT = '';