CREATE TABLE `users` (
    `id` Integer PRIMARY KEY AUTOINCREMENT,
    `uuid` VARCHAR(255) NOT NULL ,
    `username` VARCHAR(255) NOT NULL ,
    `password` VARCHAR(255) NOT NULL ,
    `role` INT(10) NOT NULL
)

CREATE INDEX `uuid-user-index` ON `users` (`uuid`);
CREATE INDEX `username-user-index` ON `users` (`username`);

CREATE TABLE `personalc` (
  `id` Integer NOT NULL PRIMARY KEY AUTOINCREMENT ,
  `hostname` VARCHAR(255) NOT NULL ,
  `csr` VARCHAR(255) NOT NULL ,
  `key` VARCHAR(255) NOT NULL ,
  `crt` VARCHAR(255) NOT NULL ,
  `p12` VARCHAR(255) NOT NULL ,
  `user` Integer NOT NULL ,
  `password` VARCHAR(255) NOT NULL
);

CREATE INDEX `hostname-certificates-index` ON `personalc` (`hostname`);

CREATE TABLE `serverc` (
  `id` Integer NOT NULL PRIMARY KEY AUTOINCREMENT ,
  `hostname` VARCHAR(255) NOT NULL ,
  `csr` VARCHAR(255) NOT NULL ,
  `key` VARCHAR(255) NOT NULL ,
  `crt` VARCHAR(255) NOT NULL ,
  `user` Integer NOT NULL
);

CREATE INDEX `hostname-certificates-index` ON `serverc` (`hostname`);
