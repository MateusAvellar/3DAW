<?php
$matriculaRecebida = $_GET['matricula'] ?? '';
$caminhoArquivo = 'alunos.txt';
$alunoEncontrado = null;

if (!empty($matriculaRecebida) && file_exists($caminhoArquivo)) {
    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        $dados = explode(';', trim($linha));
        if (count($dados) === 3 && trim($dados[0]) === trim($matriculaRecebida)) {
            $alunoEncontrado = [
                'matricula' => $dados[0],
                'nome'      => $dados[1],
                'email'     => $dados[2]
            ];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Aluno</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 300px; padding: 8px; }
        .btn-salvar { padding: 8px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-voltar { margin-left: 10px; text-decoration: none; color: #333; }
    </style>
</head>
<body>

    <h2>Alterar Dados do Aluno</h2>

    <?php if ($alunoEncontrado !== null): ?>
        <form action="alterarAluno.php" method="POST">
            <div class="form-group">
                <label>Matrícula:</label>
                <input type="text" value="<?php echo htmlspecialchars($alunoEncontrado['matricula']); ?>" disabled>
                <input type="hidden" name="matricula" value="<?php echo htmlspecialchars($alunoEncontrado['matricula']); ?>">
            </div>

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($alunoEncontrado['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($alunoEncontrado['email']); ?>" required>
            </div>

            <button type="submit" class="btn-salvar">Salvar Alterações</button>
            <a href="listarAluno.php" class="btn-voltar">Cancelar</a>
        </form>
    <?php else: ?>
        <p style="color: red;">Aluno não encontrado!</p>
        <a href="listarAluno.php">Voltar para a lista</a>
    <?php endif; ?>

</body>
</html>