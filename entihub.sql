/*Eliminacion de Base de datos*/
DROP DATABASE IF EXISTS entihub;
CREATE DATABASE entihub;

USE entihub;

/*Eliminacion de datos*/
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS messages;


/* Creación de tabla de Characters */
CREATE TABLE users (
    id_user INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `name` VARCHAR (32) NOT NULL,
    username VARCHAR (16) NOT NULL,
    email VARCHAR (24) NOT NULL,
    birthday DATE NOT NULL,
    `password` CHAR (32) NOT NULL,
    `status` INT NOT NULL DEFAULT 1
);

INSERT INTO users (`name`, username, email, birthday, `password`)
VALUES 
('Edu', 'edusagnier', 'eduard.sagnier@enti.cat' , '2004/12/20', md5('A123456789a!'));

/* Creación de tabla de Items */
CREATE TABLE messages (
    id_message INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, 
 	`message` VARCHAR (240) NOT NULL,
    post_time DATETIME NOT NULL,
    is_response BOOLEAN NOT NULL DEFAULT FALSE,
    `status` INT NOT NULL DEFAULT 1,
    id_user INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

