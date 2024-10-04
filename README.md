# Pollify

Pollify is a simple, real-time voting system built with PHP and powered by OpenSwoole. It allows users to create accounts, vote in polls, and change their votes before the poll closes. Admins can easily manage polls, add users, and set deadlines. With real-time updates via OpenSwoole, Pollify ensures a smooth and responsive voting experience for both voters and administrators.

## Requirements
- PHP 7.4 or higher
- Composer 2.x

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/rayyanalhourani/pollify.git
    ```

2. Navigate into the project directory:
    ```bash
    cd pollify
    ```

3. Copy the example environment file:
    ```bash
    cp .env.example .env
    ```
    
5. Create the database tables using `tables.sql` located in the client folder.

4. Update the `.env` file with your database configuration settings.

6. Install dependencies using Composer:
    ```bash
    composer install
    ```

7. Start the client server:
    ```bash
    cd client
    php -S localhost:8080 -t public/
    ```

8. Start the WebSocket server:
    ```bash
    cd server
    php votesHandlerSocket.php 
    ```
## Usage
1. Open your browser and navigate to `localhost:8080`.
2. Log in using the following credentials:
    - **Email:** admin@admin.com
    - **Password:** admin123
