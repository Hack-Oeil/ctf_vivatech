CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL,
  `admin`  boolean DEFAULT false,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `note` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `read`  boolean DEFAULT false,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


insert into user (id, firstname, lastname, username, password, admin) values (1, 'John', 'Doe', 'guest', '35675e68f4b5af7b995d9205ad0fc43842f16450', false);
insert into user (id, firstname, lastname, username, password, admin) values (2, 'Aliboron', 'Oscar', 'aliboron', 'a79957efd1357875fbe8dee7fc2c495923643483', true);
insert into user (id, firstname, lastname, username, password, admin) values (3, 'Michek', 'Dupont', 'm.dupont@boutik.com', '143b94a7c161e61dcb500ec956b38618239239c8', false);
insert into user (id, firstname, lastname, username, password, admin) values (4, 'Molly', 'Lourens', 'mlourens3@nih.gov', 'efdb5edcbe17a1fb22219cf6d7a6ba87cfcd3e88', false);
insert into user (id, firstname, lastname, username, password, admin) values (5, 'Jeanine', 'Carpmile', 'jcarpmile4@github.io', '4cf8c6b848fb1b96e2450d2004a1911d6ef324e6', false);
insert into user (id, firstname, lastname, username, password, admin) values (6, 'Ekaterina', 'Penhearow', 'epenhearow5@dropbox.com', 'e9b1d15933e96d13849accea1a06483294cd2c6c', false);
insert into user (id, firstname, lastname, username, password, admin) values (7, 'Wini', 'Gonnelly', 'wgonnelly6@ning.com', 'a60ab8303486033e7b81a9d6ad61f08f7733b3bc', false);
insert into user (id, firstname, lastname, username, password, admin) values (8, 'Kimble', 'Alpe', 'kalpe7@ezinearticles.com', 'a98eeebbf817ed47a314b97a93487c7f90b75a50', false);
insert into user (id, firstname, lastname, username, password, admin) values (9, 'Vonnie', 'Coward', 'vcoward8@fc2.com', '15df12f83b42aef0252f7cb90c61dce82d708074', false);
