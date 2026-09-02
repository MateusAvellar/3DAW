<?php
$msg = "";
$arquivo = "disciplinas.txt";

// 1. Processa a exclusão ao enviar o formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $termoExcluir = trim(str_replace(["\r", "\n", ";"], " ", $_POST["Disciplina"] ?? ""));

    if (!empty($termoExcluir) && file_exists($arquivo)) {
        $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $novasLinhas = [];
        $encontrado = false;

        foreach ($linhas as $index => $linha) {
            // Mantém o cabeçalho
            if ($index === 0 && strpos($linha, 'nome;') === 0) {
                $novasLinhas[] = $linha;
                continue;
            }

            $dados = explode(";", $linha);
            $nome  = trim($dados[0] ?? '');
            $sigla = trim($dados[1] ?? '');

            // Permite excluir digitando a Sigla (ex: 3DAW) ou o Nome
            if (strcasecmp($nome, $termoExcluir) === 0 || strcasecmp($sigla, $termoExcluir) === 0) {
                $encontrado = true;
                continue; // Pula a linha correspondente para removê-la
            }

            $novasLinhas[] = $linha;
        }

        if ($encontrado) {
            file_put_contents($arquivo, implode("\n", $novasLinhas) . "\n");
            $msg = "Disciplina '{$termoExcluir}' excluída com sucesso!";
        } else {
            $msg = "Nenhuma disciplina encontrada com o nome ou sigla informada.";
        }
    } else {
        $msg = "Arquivo de disciplinas não encontrado na pasta.";
    }
}

// 2. Lê os dados para montar a tabela no HTML
$disciplinas = [];
if (file_exists($arquivo)) {
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $index => $linha) {
        if ($index === 0 && strpos($linha, 'nome;') === 0) continue; // Ignora cabeçalho
        
        $dados = explode(";", $linha);
        if (count($dados) >= 3) {
            $disciplinas[] = [
                'nome'  => trim($dados[0]),
                'sigla' => trim($dados[1]),
                'carga' => trim($dados[2])
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Disciplina</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .container { max-width: 650px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .mensagem { color: green; font-weight: bold; margin-bottom: 15px; }
        input[type="text"] { padding: 6px; width: 60%; }
        button { padding: 6px 12px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Excluir Disciplina</h1>

        <?php if (!empty($msg)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($msg); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="Disciplina">Nome ou Sigla da Disciplina a excluir:</label><br><br>
            <input type="text" id="Disciplina" name="Disciplina" required placeholder="Ex: 3DAW ou 1IHM">
            <button type="submit">Excluir</button>
        </form>

        <hr style="margin: 20px 0;">

        <h2>Disciplinas Cadastradas</h2>
        <?php if (!empty($disciplinas)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sigla</th>
                        <th>Carga Horária</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disciplinas as $d): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($d['nome']); ?></td>
                            <td><?php echo htmlspecialchars($d['sigla']); ?></td>
                            <td><?php echo htmlspecialchars($d['carga']); ?>h</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma disciplina cadastrada no momento.</p>
        <?php endif; ?>
    </div>

</body>
</html>