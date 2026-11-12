<?php
$matricula = $_POST['matricula'] ?? '';
$caminhoArquivo = 'alunos.txt';
$excluidoComSucesso = false;

if (!empty($matricula) && file_exists($caminhoArquivo)) {
    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $novasLinhas = [];

    foreach ($linhas as $linha) {
        $dados = explode(';', trim($linha));
        if (count($dados) === 3) {
            // Mantém no arquivo apenas quem NÃO for a matrícula excluída
            if (trim($dados[0]) !== trim($matricula)) {
                $novasLinhas[] = trim($linha);
            } else {
                $excluidoComSucesso = true;
            }
        }
    }

    if ($excluidoComSucesso) {
        $conteudoFinal = !empty($novasLinhas) ? implode(PHP_EOL, $novasLinhas) . PHP_EOL : '';
        file_put_contents($caminhoArquivo, $conteudoFinal);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exclusão Concluída</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 5px; max-width: 400px; }
        .sucesso { color: #f44336; }
        .erro { color: #ff9800; }
        .btn-voltar { display: inline-block; margin-top: 15px; padding: 8px 15px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <div class="card">
        <?php if ($excluidoComSucesso): ?>
            <h2 class="sucesso">Aluno Excluído com Sucesso!</h2>
            <p>A matrícula <strong><?php echo htmlspecialchars($matricula); ?></strong> foi removida do arquivo <strong>alunos.txt</strong>.</p>
        <?php else: ?>
            <h2 class="erro">Erro ao Excluir!</h2>
            <p>A matrícula não foi encontrada ou o arquivo não está acessível.</p>
        <?php endif; ?>

        <a href="listarAluno.php" class="btn-voltar">Voltar para a Lista de Alunos</a>
    </div>

</body>
</html>