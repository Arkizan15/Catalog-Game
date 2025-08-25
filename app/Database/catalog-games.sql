CREATE TABLE games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_year YEAR,
    genre VARCHAR(100),
    platform VARCHAR(100),
    description TEXT
);