<?php
function userDetails($email)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function adminDetails($username)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stm->bindValue(1, $username);
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
    $stm = $pdo->prepare("SELECT users.firstname, users.surname, bs.id as bs_id, bs.address, r.message, r.code, r.id, r.email FROM (((users INNER JOIN requests r ON users.email = r.email) INNER JOIN building_sites bs ON r.code = bs.code) INNER JOIN admins a ON bs.company_name = a.company_name) WHERE a.username = ? AND r.status='pending'");
    $stm->bindValue(1, $username);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function get_sites($company_name)
{
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites WHERE company_name = ?");
    $stm->bindValue(1, $company_name);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function codeExists($code) {

    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites WHERE code = ?");
    $stm->bindValue(1, $code);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(empty($row)) {
        return false;
    } else {
        return true;
    }
}

function acceptRequest($id, $email, $building_site_id) {
    global $pdo;
    $stm = $pdo->prepare("UPDATE requests SET status='allowed' WHERE id = ?");
    $stm->bindValue(1, $id);
    $stm->execute();
    $stm2 = $pdo->prepare("INSERT INTO site_registration (email, building_site) VALUES (? , ?)");
    $stm2->bindValue(1, $email);
    $stm2->bindValue(2, $building_site_id);
    $stm2->execute();
}

function displayRegisteredSites($email) {
    global $pdo;
    $stm = $pdo->prepare("SELECT bs.code, bs.address FROM (building_sites bs INNER JOIN requests r ON bs.code = r.code) WHERE r.email = ? AND r.status='allowed'");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function siteMembers($id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT u.id,u.email, u.firstname, u.surname, u.occupation FROM (site_registration sr INNER JOIN users u ON sr.email = u.email) WHERE sr.building_site = ?");
    $stm->bindValue(1, $id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}


function registeredSites($email) {
    global $pdo;
    $stm = $pdo->prepare("SELECT r.code, r.status, bs.address,bs.id FROM (requests r INNER JOIN building_sites bs ON r.code = bs.code) 
    WHERE email = ? ORDER BY FIELD(status, 'allowed')");
    $stm->bindValue(1, $email);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getSiteByCode($code) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites WHERE code = ?");
    $stm->bindValue(1, $code);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function pdfByAdmin($admin_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM pdf WHERE admin_id = ?");
    $stm->bindValue(1, $admin_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getSitesByAdmin($admin_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM building_sites bs INNER JOIN admins a ON a.company_name = bs.company_name WHERE a.company_name = ?");
    $stm->bindValue(1, $admin_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getDocuments($user_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT p.title, pdfs.pdf_id,p.admin_id, a.company_name FROM ((pdf p INNER JOIN pdf_status pdfs ON p.id=pdfs.pdf_id )INNER JOIN admins a ON a.id=p.admin_id)
    WHERE pdfs.user_id = ? AND pdfs.status='unread'  ");
    $stm->bindValue(1, $user_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getPDFById($pdf_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM pdf WHERE id = ?");
    $stm->bindValue(1, $pdf_id);
    $stm->execute();
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function readDocuments($user_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT p.name,p.title, pdfs.pdf_id,p.admin_id, a.company_name FROM ((pdf p INNER JOIN pdf_status pdfs ON p.id=pdfs.pdf_id )INNER JOIN admins a ON a.id=p.admin_id)
    WHERE pdfs.user_id = ? AND pdfs.status='read'  ");
    $stm->bindValue(1, $user_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getSite($site_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM site_registration WHERE id=?");
    $stm->bindValue(1, $site_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getSiteDocuments($building_site_id) {
    global $pdo;
    $stm = $pdo->prepare("SELECT * FROM pdf_site ps INNER JOIN pdf p ON ps.pdf_id = p.id WHERE ps.building_site_id=?");
    $stm->bindValue(1, $building_site_id);
    $stm->execute();
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}