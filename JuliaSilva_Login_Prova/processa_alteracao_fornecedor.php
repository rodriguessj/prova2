<?php
session_start();
require 'conexao.php';

// Verifica se o formulário foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os dados enviados pelo formulário
    $id_fornecedor = $_POST['id_fornecedor'] ?? null;
    $nome = trim($_POST['nome'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contato = trim($_POST['contato'] ?? '');

    // Validação básica (exemplo, pode ser ampliada)
    if (!$id_fornecedor || empty($nome) || empty($endereco) || empty($telefone) || empty($email) || empty($contato)) {
        echo "<script>alert('Todos os campos são obrigatórios!'); window.history.back();</script>";
        exit;
    }

    // Prepara e executa o UPDATE no banco
    $sql = "UPDATE fornecedor SET nome_fornecedor = :nome, endereco = :endereco, telefone = :telefone, email = :email, contato = :contato WHERE id_fornecedor = :id_fornecedor";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contato', $contato);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor alterado com sucesso!'); window.location.href='alterar_fornecedor.php';</script>";
    } else {
        echo "<script>alert('Erro ao alterar fornecedor.'); window.history.back();</script>";
    }
} else {
    // Caso não tenha vindo via POST, redireciona para o formulário
    header('Location: alterar_fornecedor.php');
    exit;
}
?>