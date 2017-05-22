SET NAMES 'utf8';
DROP DATABASE IF EXISTS keygen;
CREATE DATABASE keygen CHARSET=UTF8;
USE keygen;

CREATE TABLE User(
    uid INT PRIMARY KEY AUTO_INCREMENT,
    nickname VARCHAR(64),
    pwd VARCHAR(256),
    openKey VARCHAR(256)
);
CREATE TABLE Group(
    gid INT PRIMARY KEY AUTO_INCREMENT,
    groupName VARCHAR(64),
    owner VARCHAR(256),
    member VARCHAR(256),
    openKey VARCHAR(256)
);
CREATE TABLE Key(
    kid INT PRIMARY KEY AUTO_INCREMENT,
    owner VARCHAR(256),
    feature VARCHAR(256),
    genKey VARCHAR(256),
    shareState INT,
    uKey VARCHAR(256),
    gKey VARCHAR(256),
    targetUser VARCHAR(64),
    targetGroup VARCHAR(64)
);
-- INSERT INTO user(uid,nickname,pwd,masterKey) VALUES
-- (   null,
--     'edem',
--     null,
--     null
-- );
