<?php
session_start();
require_once 'conexao.php';

$fornecedores = []; //INICIALIZA A VARIAVEL PARA EVITAR ERROS

//SE O FORMULARIO FOR ENVIADO, BUSCA O FORNECEDOR POR ID OU NOME

if($_SERVER ["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

//VERIFICA SE A BUSCA É UM NÚMERO (ID) OU UM NOME 

  if(is_numeric($busca)){
    $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(':busca',$busca,PDO::PARAM_INT);

  }else{
    $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindValue(':busca_nome',"%$busca%",PDO::PARAM_STR);
  }

} else{
    $sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$fornecedores=$stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Fornecedor</title>
    <link rel="stylesheet" href="style_crud.css">

</head>
<body>
    <h2>Lista de Fornecedores</h2>

<!-- Formulário para buscar fornecedores -->

    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou Nome (opcional)</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if(!empty($fornecedores)):?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Contato</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>

            <?php foreach($fornecedores as $fornecedor):?>

                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['endereco'])?></td>
                    <td><?=htmlspecialchars($fornecedor['telefone'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['contato'])?></td>

                    <td>
                        <a href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">Alterar</a>

                        <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>"onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    <?php else: ?>
        <p>Nenhum fornecedor encontrado.</p>
    <?php endif;?>

    <div class="voltar-container">
    <a href="principal.php" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>