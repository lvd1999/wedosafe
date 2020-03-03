<?php
function get_details($email)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function get_safepass($email)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE email = ? AND type='safepass'");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function delete_cert($email, $type)
{
    global $pdo;
    $stm = $pdo->prepare("DELETE FROM certificates WHERE email = ? AND cert_image_front = ? ");
    $stm->bindValue(1, $email);
    $stm->bindValue(2, $type);
    $stm->execute();
}

function get_cert($email)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM certificates WHERE email = ? AND type <> 'safepass'");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function get_pendingrequest($username)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT users.firstname, users.surname, bs.address, r.message FROM (((users INNER JOIN requests r ON users.email = r.email) INNER JOIN building_sites bs ON r.code = bs.code) INNER JOIN admins a ON bs.company_name = a.company_name WHERE a.username = ? AND r.status='pending')");
    $stm->bindValue(1, $username);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

