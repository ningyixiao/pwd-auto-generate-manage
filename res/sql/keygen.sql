SET NAMES 'utf8';
DROP DATABASE IF EXISTS keygen;
CREATE DATABASE keygen CHARSET=UTF8;
USE keygen;

CREATE TABLE user(
    uid INT PRIMARY KEY AUTO_INCREMENT,
    nickname VARCHAR(64),
    pwd VARCHAR(256),
    masterKey VARCHAR(256)
);
-- INSERT INTO user(uid,nickname,pwd,masterKey) VALUES
-- (   null,
--     'edem',
--     null,
--     null
-- );
