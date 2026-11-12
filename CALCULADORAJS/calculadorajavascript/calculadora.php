<?php
//define a resposta em texto simples.
//Pega JSON.
//Transforma em PHP.
//armazena os números 
//formato da resposta, texto simples 
header('Content-Type: application/json');

// Pega a REQUISIÇÃO 
//traduz JSON
//array dados 
$dados = json_decode(file_get_contents('php://input'), true);

$num1 = $dados['numero1'] ?? 0;
$num2 = $dados['numero2'] ?? 0;
$operacao = $dados['operacao'] ?? 'soma';

$resultado = 0;

switch($operacao){
    case '+':
        $resultado = $num1 + $num2;
        break;
    case '-':
        $resultado = $num1 - $num2;
        break;
    case '*':
        $resultado = $num1 * $num2;
        break;
    case '/':
        if($num2 != 0){
            $resultado = $num1 / $num2;
        }else{
            echo json_encode(['erro' => 'Divisão por zero não permitida']);
            exit;
        }
        break;
}


echo json_encode(['resultado' => $resultado]);
?>