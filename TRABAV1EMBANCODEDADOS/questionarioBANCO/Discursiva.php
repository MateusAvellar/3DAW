<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perguntaTexto = trim($_POST['pergunta'] ?? '');
    $gabaritoTexto = trim($_POST['gabarito'] ?? '');

    if ($perguntaTexto === '') {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Informe a pergunta.']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO perguntas (pergunta, gabarito) VALUES (?, ?)");
    $stmt->execute([$perguntaTexto, $gabaritoTexto]);

    echo json_encode(['sucesso' => true, 'mensagem' => 'Pergunta discursiva criada!']);
}
?>