-- Create AnimeTracker database
CREATE DATABASE AnimeTracker;
USE AnimeTracker;

-- Table to store anime details
CREATE TABLE Anime (
    AnimeID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Rating DECIMAL(3,1),  -- Example: 8.5
    Genre VARCHAR(255),
    Status ENUM('Watching', 'Completed', 'Planned', 'Dropped') DEFAULT 'Planned',
    LastUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table to store information about seasons
CREATE TABLE Seasons (
    SeasonID INT AUTO_INCREMENT PRIMARY KEY,
    AnimeID INT,
    SeasonNumber INT,
    ReleaseDate DATE,
    Status ENUM('Announced', 'Airing', 'Finished'),
    FOREIGN KEY (AnimeID) REFERENCES Anime(AnimeID) ON DELETE CASCADE
);

-- Table to store watch history or additional tracking
CREATE TABLE Watchlist (
    WatchlistID INT AUTO_INCREMENT PRIMARY KEY,
    AnimeID INT,
    UserStatus ENUM('Watching', 'Completed', 'Dropped'),
    LastWatched DATE,
    FOREIGN KEY (AnimeID) REFERENCES Anime(AnimeID) ON DELETE CASCADE
);

-- Table to store user info (login/signup)
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for admin (if necessary for managing data)
CREATE TABLE Admin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL
);
