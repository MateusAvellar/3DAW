<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    // O ON DELETE CASCADE da tabela respostas apaga as alternativas automaticamente
    $stmt = $pdo->prepare("DELETE FROM perguntas WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Pergunta excluída com sucesso!']);
}
?>