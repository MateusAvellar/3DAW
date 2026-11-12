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
    <title>Confirmar Exclusão</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card-alerta { border: 1px solid #f44336; padding: 20px; border-radius: 5px; max-width: 450px; background-color: #ffebee; }
        .btn-confirmar { padding: 8px 15px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 3px; font-weight: bold; }
        .btn-cancelar { margin-left: 10px; text-decoration: none; color: #333; }
        .dados-aluno { background-color: #fff; padding: 10px; border: 1px solid #ddd; margin: 15px 0; border-radius: 3px; }
    </style>
</head>
<body>

    <h2>Exclusão de Aluno</h2>

    <?php if ($alunoEncontrado !== null): ?>
        <div class="card-alerta">
            <h3 style="color: #d32f2f; margin-top: 0;">Atenção! Você tem certeza que deseja excluir este aluno?</h3>
            
            <div class="dados-aluno">
                <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($alunoEncontrado['matricula']); ?></p>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($alunoEncontrado['nome']); ?></p>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($alunoEncontrado['email']); ?></p>
            </div>

            <form action="excluirAluno.php" method="POST">
                <input type="hidden" name="matricula" value="<?php echo htmlspecialchars($alunoEncontrado['matricula']); ?>">
                <button type="submit" class="btn-confirmar">Confirmar Exclusão</button>
                <a href="listarAluno.php" class="btn-cancelar">Cancelar</a>
            </form>
        </div>
    <?php else: ?>
        <p style="color: red;">Aluno não encontrado para exclusão!</p>
        <a href="listarAluno.php">Voltar para a lista</a>
    <?php endif; ?>

</body>
</html>