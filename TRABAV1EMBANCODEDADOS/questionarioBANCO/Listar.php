<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

$perguntas = $pdo->query("SELECT id, pergunta, gabarito FROM perguntas ORDER BY id ASC")->fetchAll();

foreach ($perguntas as &$p) {
    $p['id'] = (int)$p['id'];
    $p['gabarito'] = $p['gabarito'] ?? '';
}

$respostas = [];
$stmtResp = $pdo->query("SELECT id, id_pergunta, texto, eh_correta FROM respostas ORDER BY id ASC");

while ($row = $stmtResp->fetch()) {
    $idPergunta = (int)$row['id_pergunta'];
    $respostas[$idPergunta][] = [
        'id_resposta' => (int)$row['id'],
        'texto' => $row['texto'],
        'correta' => (int)$row['eh_correta']
    ];
}

echo json_encode([
    'sucesso' => true,
    'perguntas' => $perguntas,
    'respostas' => $respostas
]);
?>