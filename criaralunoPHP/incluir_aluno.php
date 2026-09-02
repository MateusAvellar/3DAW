<?php
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitização simples para evitar dados corrompidos ou quebra de linha manual
    $nome = str_replace(["\r", "\n", ";"], " ", $_POST["nome"] ?? "");
    $matricula = str_replace(["\r", "\n", ";"], " ", $_POST["matricula"] ?? "");
    $curso = str_replace(["\r", "\n", ";"], " ", $_POST["curso"] ?? "");

    $arquivo = "alunos.txt";

    // Cria o arquivo e escreve o cabeçalho se ele ainda não existir
    if (!file_exists($arquivo)) {
        $arqAluno = fopen($arquivo, "w") or die("Erro ao criar arquivo.");
        fwrite($arqAluno, "nome;matricula;curso\n");
        fclose($arqAluno);
    }

    // Adiciona o novo registro no final do arquivo
    $arqAluno = fopen($arquivo, "a") or die("Erro ao abrir arquivo.");
    $linha = trim($nome) . ";" . trim($matricula) . ";" . trim($curso) . "\n";
    fwrite($arqAluno, $linha);
    fclose($arqAluno);

    $msg = "Aluna(o) cadastrado";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="CSS/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <div class="container">
        <h1>Cadastro de Aluno</h1>
        <p class="subtitulo">Preencha os dados do aluno</p>

        <form action="incluir_aluno.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Ex: Mateus Avellar" required>

            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" id="matricula" placeholder="Ex: 25204708360027" required>

            <label for="curso">Curso:</label>
            <input type="text" name="curso" id="curso" placeholder="Ex: ADS - FAETERJ" required>

            <input type="submit" value="Cadastrar Aluno">
        </form>

        <?php if (!empty($msg)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($msg); ?></p>
        <?php endif; ?>
    </div>

</body>
</html>