<?php
$matricula = $_POST['matricula'] ?? '';
$nome      = $_POST['nome'] ?? '';
$cpf       = $_POST['cpf'] ?? '';
$endereco  = $_POST['endereco'] ?? '';

$caminhoArquivo = 'professores.txt';
$alteradoComSucesso = false;

if (!empty($matricula) && !empty($nome) && !empty($cpf) && !empty($endereco) && file_exists($caminhoArquivo)) {
    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $novasLinhas = [];

    foreach ($linhas as $linha) {
        $dados = explode(';', trim($linha));
        
        // Verifica se a linha possui os 4 campos esperados (matricula;nome;cpf;endereco)
        if (count($dados) >= 4) {
            // Se for o professor alterado, grava a nova linha
            if (trim($dados[0]) === trim($matricula)) {
                $novasLinhas[] = "{$matricula};{$nome};{$cpf};{$endereco}";
                $alteradoComSucesso = true;
            } else {
                $novasLinhas[] = trim($linha);
            }
        }
    }

    // Reescreve o arquivo txt atualizado se houver dados alterados
    if ($alteradoComSucesso) {
        file_put_contents($caminhoArquivo, implode(PHP_EOL, $novasLinhas) . PHP_EOL);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Professor</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 5px; max-width: 450px; }
        .sucesso { color: #4CAF50; }
        .erro { color: #f44336; }
        .btn-voltar { display: inline-block; margin-top: 15px; padding: 8px 15px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>

    <div class="card">
        <?php if ($alteradoComSucesso): ?>
            <h2 class="sucesso">Professor alterado com sucesso!</h2>
            <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($matricula); ?></p>
            <p><strong>Novo Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
            <p><strong>Novo CPF:</strong> <?php echo htmlspecialchars($cpf); ?></p>
            <p><strong>Novo Endereço:</strong> <?php echo htmlspecialchars($endereco); ?></p>
        <?php else: ?>
            <h2 class="erro">Erro ao alterar!</h2>
            <p>Não foi possível salvar os dados no arquivo TXT.</p>
        <?php endif; ?>

        <a href="listarProfessor.php" class="btn-voltar">Voltar para a Lista de Professores</a>
    </div>

</body>
</html>