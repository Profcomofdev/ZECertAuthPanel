CREATE TABLE `users` (
    `id` BIGINT(255) NOT NULL AUTO_INCREMENT ,
    `uuid` VARCHAR(255) NOT NULL ,
    `username` VARCHAR(255) NOT NULL ,
    `password` VARCHAR(255) NOT NULL ,
    `role` INT(10) NOT NULL ,
    PRIMARY KEY (`id`),
    INDEX `uuid-user-index` (`uuid`),
    INDEX `username-user-index` (`username`)
) ENGINE = InnoDB;

CREATE TABLE `personalc` (`id` BIGINT(255) NOT NULL AUTO_INCREMENT , `hostname` VARCHAR(255) NOT NULL , `csr` VARCHAR(255) NOT NULL , `key` VARCHAR(255) NOT NULL , `crt` VARCHAR(255) NOT NULL , `p12` VARCHAR(255) NOT NULL , `user` BIGINT(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`), INDEX `hostname-certificates-index` (`hostname`)) ENGINE = InnoDB;

CREATE TABLE `serverc` (`id` BIGINT(255) NOT NULL AUTO_INCREMENT , `hostname` VARCHAR(255) NOT NULL , `csr` VARCHAR(255) NOT NULL , `key` VARCHAR(255) NOT NULL , `crt` VARCHAR(255) NOT NULL , `user` BIGINT(255) NOT NULL, PRIMARY KEY (`id`), INDEX `hostname-certificates-index` (`hostname`)) ENGINE = InnoDB;

ALTER TABLE `personalc`
  ADD CONSTRAINT FOREIGN KEY (`user`) REFERENCES `users` (`id`);

ALTER TABLE `serverc`
  ADD CONSTRAINT FOREIGN KEY (`user`) REFERENCES `users` (`id`);
