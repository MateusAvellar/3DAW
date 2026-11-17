<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $pergunta = trim($_POST['pergunta'] ?? '');
    $gabarito = trim($_POST['gabarito'] ?? '');

    $stmt = $pdo->prepare("UPDATE perguntas SET pergunta = ?, gabarito = ? WHERE id = ?");
    $stmt->execute([$pergunta, $gabarito, $id]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Pergunta discursiva alterada!']);
}
?>