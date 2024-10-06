<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$mysqli = new mysqli("localhost", "root", "", "user_management");

if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            get_user($mysqli, $_GET['id']);
        } else {
            get_users($mysqli);
        }
        break;
    case 'POST':
        create_user($mysqli);
        break;
    case 'PUT':
        update_user($mysqli, $_GET['id']);
        break;
    case 'DELETE':
        delete_user($mysqli, $_GET['id']);
        break;
    default:
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

function get_users($mysqli) {
    $result = $mysqli->query("SELECT * FROM users");
    $users = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($users);
}

function get_user($mysqli, $id) {
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    echo json_encode($user);
}

function create_user($mysqli) {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $data['username'], $data['email'], $hashed_password);
    $stmt->execute();
    echo json_encode(["message" => "User created successfully"]);
}

function update_user($mysqli, $id) {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $mysqli->prepare("UPDATE users SET username = ?, email = ?" . (isset($data['password']) ? ", password = ?" : "") . " WHERE id = ?");
    
    if (isset($data['password'])) {
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("sssi", $data['username'], $data['email'], $hashed_password, $id);
    } else {
        $stmt->bind_param("ssi", $data['username'], $data['email'], $id);
    }
    
    $stmt->execute();
    echo json_encode(["message" => "User updated successfully"]);
}

function delete_user($mysqli, $id) {
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["message" => "User deleted successfully"]);
}
?>