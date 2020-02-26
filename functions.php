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
    $stm = $pdo->prepare("DELETE FROM certificates WHERE email = ? AND type = ? ");
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
