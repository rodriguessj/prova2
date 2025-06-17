<?php
session_start();
require_once 'conexao.php';


if($_SERVER ["REQUEST_METHOD"]=="POST"){
    $nome_fornecedor = $_POST['nome'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $contato = $_POST['contato'];



    $sql = "INSERT INTO fornecedor(nome_fornecedor, endereco, telefone, email, contato, id_fornecedor) VALUES (:nome_fornecedor, :endereco, :telefone, :email, :contato, :id_fornecedor)";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(':nome_fornecedor',$nome_fornecedor);
    $stmt -> bindParam(':endereco',$endereco);
    $stmt -> bindParam(':telefone',var: $telefone);
    $stmt -> bindParam(':email',var: $email);
    $stmt -> bindParam(':contato',$contato);
    $stmt -> bindParam(':id_fornecedor',$id_fornecedor);

    if($stmt->execute()){
        echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";

    } else{
        echo "<script>alert('Erro ao cadastrar fornecedor!');</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
    <link rel="stylesheet" href="style_crud.css">
    <script src="scripts_crud.js"></script>

   
</head>
<body>
    
<h3 style="text-align: center;">Julia Rodrigues Silva</h3>

    <h2>Cadastrar Fornecedor</h2>
    <form action="cadastro_fornecedor.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

        <label for="contato">Contato:</label>
        <input type="text" id="contato" name="contato" required>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <div class="voltar-container">
    <a href="principal.php" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>