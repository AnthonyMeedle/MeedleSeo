
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- meedle_seo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `meedle_seo`;

CREATE TABLE `meedle_seo`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `view_name` VARCHAR(30),
    `view_id` INTEGER DEFAULT 0 NOT NULL,
    `og_url` VARCHAR(255),
    `og_title` VARCHAR(255),
    `og_description` VARCHAR(255),
    `file` VARCHAR(100),
    `og_type` VARCHAR(100),
    `locale` VARCHAR(10),
    `nofollow` TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- meedle_seo_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `meedle_seo_i18n`;

CREATE TABLE `meedle_seo_i18n`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `meedle_seo_id` INTEGER DEFAULT 0 NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    `meta_title` VARCHAR(255),
    `meta_description` TEXT,
    `meta_keywords` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
