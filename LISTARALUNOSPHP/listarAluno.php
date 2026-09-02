<?php
$caminhoArquivo = 'alunos.txt';
$alunos = [];

if (file_exists($caminhoArquivo)) {
    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        $dados = explode(';', trim($linha));
        if (count($dados) === 3) {
            $alunos[] = [
                'matricula' => $dados[0],
                'nome'      => $dados[1],
                'email'     => $dados[2]
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; font-size: 14px; }
        .btn-alterar { background-color: #2196F3; }
        .btn-excluir { background-color: #f44336; margin-left: 5px; }
    </style>
</head>
<body>

    <h2>Listagem de Alunos</h2>

    <table>
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($alunos)): ?>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aluno['matricula']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                        <td>
                            <a href="formAlterarAluno.php?matricula=<?php echo $aluno['matricula']; ?>" class="btn btn-alterar">Alterar</a>
                            <a href="formExcluirAluno.php?matricula=<?php echo $aluno['matricula']; ?>" class="btn btn-excluir">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum aluno cadastrado no arquivo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>