/* SET GLOBAL log_output = 'TABLE';
SET GLOBAL general_log = 'ON';
select * from mysql.general_log;
*/

CREATE TABLE users (
    username VARCHAR(20) NOT NULL,
    password CHAR(32) NOT NULL,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    level INT DEFAULT 1,
    lottery BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(`username`)
) DEFAULT CHARACTER SET = utf8;
insert into users(username,password,name,surname,level) values('admin',md5('admin123'),'Super','Admin',0);

CREATE TABLE lottery (
    username VARCHAR(20) NOT NULL,
    name VARCHAR(20),
    PRIMARY KEY(`username`)
) DEFAULT CHARACTER SET = utf8;

CREATE TABLE presents (
    id INTEGER NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    present VARCHAR(255) NOT NULL,
    description VARCHAR(500),
    link VARCHAR(255),
    reservedBy VARCHAR(20),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET = utf8;
CREATE INDEX presents_username_idx on presents(username);
