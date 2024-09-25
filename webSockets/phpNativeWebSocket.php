<?php

// Database connection details
$host = 'localhost';  // Database host
$db = 'pollify';    // Database name
$user = 'root';       // Database username
$pass = '123456';           // Database password
$charset = 'utf8mb4'; // Charset

// WebSocket server details
$server_host = '127.0.0.1';  // WebSocket server host
$server_port = 8085;         // WebSocket server port

// Set up error reporting
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

// Create the WebSocket server socket
$server_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($server_socket, SOL_SOCKET, SO_REUSEADDR, 1);

// Bind the socket to the server host and port
socket_bind($server_socket, $server_host, $server_port) or die('Could not bind to address');
socket_listen($server_socket);

// Store connected clients
$clients = [];
$client_ids = [];

try {
    // Set up the PDO database connection
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// WebSocket server main loop
while (true) {
    $read_sockets = $clients;
    $read_sockets[] = $server_socket;

    // Monitor multiple connections
    socket_select($read_sockets, $write, $except, 0, 10);

    // Accept new clients
    if (in_array($server_socket, $read_sockets)) {
        $new_socket = socket_accept($server_socket);
        $clients[] = $new_socket;

        $header = socket_read($new_socket, 1024);
        perform_handshake($header, $new_socket, $server_host, $server_port);
        unset($read_sockets[array_search($server_socket, $read_sockets)]);
    }

    // Handle incoming data from clients
    // Handle incoming data from clients
    foreach ($clients as $key => $client_socket) {
        if (in_array($client_socket, $read_sockets)) {
            $data = socket_read($client_socket, 1024);
            if ($data === false) {
                // Client disconnected
                unset($clients[$key]);
                unset($client_ids[$client_socket]); // Remove ID when client disconnects
                continue;
            }

            // Unmask and decode the received data
            $message = unmask($data);
            $decodedMessage = json_decode($message, true);

            // Check if there's an ID sent from the client
            if (isset($decodedMessage['id'])) {
                $client_ids[$client_socket] = $decodedMessage['id']; // Store the ID
                echo "Client ID updated: " . $decodedMessage['id'] . "\n";
            }

            // Now you can use $client_ids array for further logic if needed
            // For example, fetching vote counts or processing data based on client ID
            $id = $client_ids[$client_socket]; // Get ID for the specific client

            // Fetch vote counts from the database using the stored ID
            $vote_counts = fetch_vote_counts($pdo, $id);

            // Broadcast updated vote counts to all clients
            $response_text = mask(json_encode($vote_counts));

            foreach ($clients as $client) {
                socket_write($client, $response_text, strlen($response_text));
            }
        }
    }
}

// Close the server socket
socket_close($server_socket);

/**
 * Perform the WebSocket handshake
 */
function perform_handshake($header, $client, $host, $port)
{
    $headers = [];
    $lines = preg_split("/\r\n/", $header);
    foreach ($lines as $line) {
        $line = chop($line);
        if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "WebSocket-Origin: $host\r\n" .
        "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n" .
        "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client, $upgrade, strlen($upgrade));
}

/**
 * Fetch vote counts from the database
 */
function fetch_vote_counts($pdo, $id)
{
    // Example query to fetch vote counts by option
    $query = "SELECT id , (SELECT COUNT(*) FROM votes WHERE votes.option_id=options.id) as count from options where poll_id=$id;";
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

/**
 * Mask data according to the WebSocket protocol
 */
function mask($text)
{
    $b1 = 0x81;
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
        $header = pack('CCn', $b1, 126, $length);
    } else {
        $header = pack('CCNN', $b1, 127, $length);
    }
    return $header . $text;
}

/**
 * Unmask WebSocket frames according to the WebSocket protocol
 */
function unmask($text)
{
    $length = ord($text[1]) & 127;
    if ($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    } else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = '';
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}
