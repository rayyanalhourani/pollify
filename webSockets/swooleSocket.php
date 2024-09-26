<?php

use OpenSwoole\WebSocket\{Frame, Server};
use OpenSwoole\Constant;
use OpenSwoole\Http\Request;
use OpenSwoole\Table;

use Core\App;
use Core\Database;

$host = 'localhost';
$db = 'pollify';
$user = 'root';
$pass = '123456';
$charset = 'utf8mb4';

try {
    // Set up the PDO database connection
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$server = new Server("127.0.0.1", 8085, Server::SIMPLE_MODE, Constant::SOCK_TCP);

$fds = new Table(1024);
$fds->column('fd', Table::TYPE_INT, 4);
$fds->column('name', Table::TYPE_STRING, 16);
$fds->create();

$server->on("Start", function (Server $server) {
    echo "Swoole WebSocket Server is started at " . $server->host . ":" . $server->port . "\n";
});

$server->on('Open', function (Server $server, Request $request) use ($fds) {
    $fd = $request->fd;
    $clientName = sprintf("Client-%'.06d\n", $request->fd);
    $fds->set($request->fd, [
        'fd' => $fd,
        'name' => sprintf($clientName)
    ]);
    echo "Connection <{$fd}> open by {$clientName}. Total connections: " . $fds->count() . "\n";
    foreach ($fds as $key => $value) {
        if ($key == $fd) {
            $server->push($request->fd, "Welcome {$clientName}, there are " . $fds->count() . " connections");
        } else {
            $server->push($key, "A new client ({$clientName}) is joining to the party");
        }
    }
});

$server->on('Message', function (Server $server, Frame $frame) use ($fds) {
    $data = json_decode($frame->data, true);
    $poll_id = $data["poll_id"];

    if ($data["action"] == "get") {
        $response = [
            "status" => "success",
            "result" => fetch_vote_counts($poll_id)
        ];
        $server->push($frame->fd, json_encode($response));
    } else {
        $user_id = $data["user_id"];
        $option_id = $data["option_id"];

        $result = insert($poll_id, $option_id, $user_id);

        if (isset($result["error"])) {
            $response = [
                "status" => "failed",
                "error" => $result["error"]
            ];
            $server->push($frame->fd, json_encode($response));
        } else {
            $response = [
                "status" => "success",
                "result" => fetch_vote_counts($poll_id)
            ];
            foreach ($fds as $key => $value) {

                $server->push($key, json_encode($response));
            }
        }
    }
});

$server->on('Close', function (Server $server, int $fd) use ($fds) {
    $fds->del($fd);
    echo "Connection close: {$fd}, total connections: " . $fds->count() . "\n";
});

$server->on('Disconnect', function (Server $server, int $fd) use ($fds) {
    $fds->del($fd);
    echo "Disconnect: {$fd}, total connections: " . $fds->count() . "\n";
});

$server->start();

function fetch_vote_counts($id)
{
    global $pdo;
    $query = "SELECT id , (SELECT COUNT(*) FROM votes WHERE votes.option_id=options.id) as count from options where poll_id=$id;";
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function insert($poll_id, $option_id, $user_id)
{
    global $pdo;
    $result = [];
    $selectQuery = "SELECT * FROM votes WHERE poll_id = :poll_id AND voter_id = :voter_id";
    $stmt = $pdo->prepare($selectQuery);
    $stmt->execute(["poll_id" => $poll_id, "voter_id" => $user_id]);
    $vote = $stmt->fetch(PDO::FETCH_ASSOC);

    $error = null;
    if (!$option_id) {
        $error = "You have choose at option";
    } else if ($vote && $vote['option_id'] == $option_id) {
        $error = "You have choose this option before";
    }

    if ($error) {
        $result["error"] = $error;
        return $result;
    }


    if ($vote) {
        if (($vote['option_id'] != $option_id)) {
            $deleteQuery = "DELETE FROM votes WHERE id = :id";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->execute(["id" => $vote['id']]);
        }
    }

    $voteQuery = "INSERT INTO votes (poll_id, option_id, voter_id) VALUES (:poll_id, :option_id, :voter_id)";
    $stmt = $pdo->prepare($voteQuery);

    $stmt->execute([
        "poll_id" => $poll_id,
        "option_id" => $option_id,
        "voter_id" => $user_id
    ]);

    return $result;
}
