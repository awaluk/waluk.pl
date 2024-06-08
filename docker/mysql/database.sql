CREATE TABLE categories (
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `number` TINYINT UNSIGNED NOT NULL
) ENGINE=InnoDB CHARSET=utf8mb4;

CREATE TABLE posts (
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `category_id` INT UNSIGNED NOT NULL,
    `date` DATETIME NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `description` TEXT,
    `main_image_alt` TEXT,
    `content_md` TEXT,
    `content_html` TEXT
) ENGINE=InnoDB CHARSET=utf8mb4;
ALTER TABLE posts ADD CONSTRAINT category_id FOREIGN KEY (category_id) REFERENCES categories(id);

INSERT INTO categories (name, slug, number) VALUES
    ('PHP', 'php', 1),
    ('Programowanie', 'programowanie', 2),
    ('Praca/rozwój', 'praca-rozwoj', 3),
    ('Sprzęt/sieci', 'sprzet-sieci', 4),
    ('Po godzinach', 'po-godzinach', 5);
