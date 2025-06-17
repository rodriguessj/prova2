<?php
session_start();
require 'conexao.php';

$fornecedor = null;

// 🔍 Se receber ID via GET (ao clicar em "Alterar")
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fornecedor) {
        echo "<script>alert('Fornecedor não encontrado!');</script>";
    }
}

// 🔎 Se buscar por POST (busca manual)
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca_usuario'])) {
    $busca = trim($_POST['busca_usuario']);

    if (is_numeric($busca)) {
        $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }

    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fornecedor) {
        echo "<script>alert('Fornecedor não encontrado!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Fornecedor</title>
    <link rel="stylesheet" href="style_crud.css">
    <script src="scripts_crud.js"></script>
</head>
<body>
<h3 style="text-align: center;">Julia Rodrigues Silva</h3>

    <h2>Alterar Fornecedor</h2>

    <!--  Formulário só aparece se não houver GET -->
    <?php if (!isset($_GET['id'])): ?>
        <form action="alterar_fornecedor.php" method="POST">
            <label for="busca_usuario">Digite o ID ou Nome do Fornecedor:</label>
            <input type="text" id="busca_usuario" name="busca_usuario" required>
            <button type="submit">Buscar</button>
        </form>
    <?php endif; ?>

    <?php if ($fornecedor): ?>
        <!--  Formulário para alterar fornecedor -->
        <form action="processa_alteracao_fornecedor.php" method="POST">
            <input type="hidden" name="id_fornecedor" value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome_fornecedor" name="nome" value="<?= htmlspecialchars($fornecedor['nome_fornecedor']) ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['endereco']) ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($fornecedor['email']) ?>" required>

            <label for="contato">Contato:</label>
            <input type="text" id="contato" name="contato" value="<?= htmlspecialchars($fornecedor['contato']) ?>" required>

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>

    <div class="voltar-container">
    <a href="principal.php" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>
