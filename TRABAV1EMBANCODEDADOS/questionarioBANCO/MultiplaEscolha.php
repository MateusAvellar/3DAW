<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perguntaTexto = trim($_POST['pergunta'] ?? '');
    $alternativas = $_POST['alternativas'] ?? [];
    $corretaIndex = (int)($_POST['correta'] ?? -1);

    if ($perguntaTexto === '') {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Informe a pergunta.']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO perguntas (pergunta, gabarito) VALUES (?, NULL)");
    $stmt->execute([$perguntaTexto]);
    $novoId = $pdo->lastInsertId();

    $stmtAlt = $pdo->prepare("INSERT INTO respostas (id_pergunta, texto, eh_correta) VALUES (?, ?, ?)");
    foreach ($alternativas as $index => $textoAlt) {
        $textoAlt = trim($textoAlt);
        if ($textoAlt !== '') {
            $ehCorreta = ($index === $corretaIndex) ? 1 : 0;
            $stmtAlt->execute([$novoId, $textoAlt, $ehCorreta]);
        }
    }

    echo json_encode(['sucesso' => true, 'mensagem' => 'Pergunta de múltipla escolha criada!']);
}
?>