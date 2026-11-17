<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

$acao = $_GET['acao'] ?? $_POST['acao'] ?? 'listar';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuarios = $pdo->query("SELECT id, nome, email FROM usuarios ORDER BY id ASC")->fetchAll();
    foreach ($usuarios as &$u) {
        $u['id'] = (int)$u['id'];
    }
    echo json_encode(['sucesso' => true, 'usuarios' => $usuarios]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($acao === 'novo' || $acao === 'editar') {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($nome === '' || $email === '') {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Informe nome e e-mail.']);
            exit;
        }

        if ($acao === 'novo') {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário criado!']);
            exit;
        } else {
            if ($senha !== '') {
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha_hash = ? WHERE id = ?");
                $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT), $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
                $stmt->execute([$nome, $email, $id]);
            }
            echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário atualizado!']);
            exit;
        }
    } elseif ($acao === 'excluir') {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário excluído!']);
        exit;
    }
}
?>