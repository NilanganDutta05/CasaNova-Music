-- Create the database
CREATE DATABASE IF NOT EXISTS music_streaming;

-- Use the created database
USE music_streaming;

-- Create users table with role column
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create albums table
CREATE TABLE IF NOT EXISTS albums (
     id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL
);

-- Create tracks table with foreign key to albums
CREATE TABLE IF NOT EXISTS tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL,
    album_id INT,
    genre VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    release_date DATE NOT NULL,
    cover_art VARCHAR(255),
    FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE SET NULL
);

-- Create playlists table
CREATE TABLE IF NOT EXISTS playlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create playlist_tracks table
CREATE TABLE IF NOT EXISTS playlist_tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    playlist_id INT NOT NULL,
    track_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE
);

-- Insert sample users
INSERT INTO users (username, email, password, role) VALUES 
('john_doe', 'john@example.com', 'password_hash_1', 'user'),
('jane_doe', 'jane@example.com', 'password_hash_2', 'user');

-- Insert sample albums
INSERT INTO albums (name, artist) VALUES 
('Album 1', 'Artist 1'), 
('Album 2', 'Artist 2'), 
('Album 3', 'Artist 3'), 
('Album 4', 'Artist 4'), 
('Album 5', 'Artist 5'), 
('Album 6', 'Artist 6'), 
('Album 7', 'Artist 7');

-- Insert sample tracks
INSERT INTO tracks (title, artist, album_id, genre, file_path, release_date, cover_art) VALUES 
('Track 1', 'Artist 1', 1, 'Pop', '../music/song1.mp3', '2023-01-01', '../assets/images/cover_page1.jpeg'),
('Track 2', 'Artist 2', 2, 'Rock', '../music/song2.mp3', '2023-02-01', '../assets/images/cover_page2.jpeg'),
('Track 3', 'Artist 3', 3, 'Jazz', '../music/song3.mp3', '2023-03-01', '../assets/images/cover_page3.jpeg'),
('Track 4', 'Artist 4', 4, 'Classical', '../music/song4.mp3', '2023-04-01', '../assets/images/cover_page4.jpeg'),
('Track 5', 'Artist 5', 5, 'Hip Hop', '../music/song5.mp3', '2023-05-01', '../assets/images/cover_page5.jpeg'),
('Track 6', 'Artist 6', 6, 'Blues', '../music/song6.mp3', '2023-06-01', '../assets/images/cover_page6.jpeg'),
('Track 7', 'Artist 7', 7, 'Country', '../music/song7.mp3', '2023-07-01', '../assets/images/cover_page7.jpeg');

-- Insert sample playlists
INSERT INTO playlists (user_id, name) VALUES 
(1, 'John\'s Playlist'),
(2, 'Jane\'s Playlist');

-- Insert sample playlist tracks
INSERT INTO playlist_tracks (playlist_id, track_id) VALUES 
(1, 1),
(1, 2),
(2, 1);

-- Create settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_title VARCHAR(255) NOT NULL,
    site_description TEXT
);

-- Insert initial settings
INSERT INTO settings (site_title, site_description) VALUES 
('CasaNova Music', 'Your ultimate music platform.');
