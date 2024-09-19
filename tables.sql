-- Create users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'voter') NOT NULL DEFAULT 'voter',
    status ENUM('active', 'banned') NOT NULL DEFAULT 'active'
);

-- Create polls Table
CREATE TABLE polls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id)
    ON DELETE SET NULL
);

-- Create options Table
CREATE TABLE options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poll_id INT,
    option_text VARCHAR(255) NOT NULL,
    FOREIGN KEY (poll_id) REFERENCES polls(id)
    ON DELETE CASCADE
);

-- Create votes Table
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poll_id INT,
    option_id INT,
    voter_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (poll_id) REFERENCES polls(id)
    ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES options(id)
    ON DELETE CASCADE,
    FOREIGN KEY (voter_id) REFERENCES users(id)
    ON DELETE CASCADE
);
