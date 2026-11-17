<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $pergunta = trim($_POST['pergunta'] ?? '');
    $alternativas = $_POST['alternativas'] ?? [];
    $corretaIndex = (int)($_POST['correta'] ?? -1);

    $stmt = $pdo->prepare("UPDATE perguntas SET pergunta = ? WHERE id = ?");
    $stmt->execute([$pergunta, $id]);

    $pdo->prepare("DELETE FROM respostas WHERE id_pergunta = ?")->execute([$id]);

    $stmtAlt = $pdo->prepare("INSERT INTO respostas (id_pergunta, texto, eh_correta) VALUES (?, ?, ?)");
    foreach ($alternativas as $index => $textoAlt) {
        $textoAlt = trim($textoAlt);
        if ($textoAlt !== '') {
            $ehCorreta = ($index === $corretaIndex) ? 1 : 0;
            $stmtAlt->execute([$id, $textoAlt, $ehCorreta]);
        }
    }

    echo json_encode(['sucesso' => true, 'mensagem' => 'Pergunta de múltipla escolha alterada!']);
}
?>