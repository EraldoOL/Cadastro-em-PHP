<?php
require_once 'config.php';

function inserirCorretor($name, $cpf, $creci) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO corretores (name, cpf, creci) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $cpf, $creci]);
}

function buscarCorretores() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM corretores");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function excluirCorretor($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM corretores WHERE id = ?");
    return $stmt->execute([$id]);
}
?>