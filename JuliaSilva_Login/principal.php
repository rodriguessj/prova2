<?php

session_start();
require_once 'conexao.php';


if(!isset($_SESSION['id_usuario'])){
   header("Location: login.php");
   exit();
}
   //Obtendo o nome do perfil do usuario logado
   $id_perfil = $_SESSION['perfil'];
   $sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
   $stmtPerfil = $pdo->prepare($sqlPerfil);
   $stmtPerfil->bindParam(':id_perfil',$id_perfil);
   $stmtPerfil->execute();
   $perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
   $nome_perfil = $perfil['nome_perfil'];

   //Definição das permissões por perfil
   $permissoes = [
    1 => ["Cadastrar"=>["cadastro_usuario.php","cadastro_perfil.php","cadastro_cliente.php","cadastro_fornecedor.php","cadastro_produto.php","cadastro_funcionario.php"],
          "Buscar"=>["buscar_usuario.php","buscar_perfil.php","buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php","buscar_funcionario.php"],
          "Alterar"=>["alterar_usuario.php","alterar_perfil.php","alterar_cliente.php","alterar_fornecedor.php","alterar_produto.php","alterar_funcionario.php"],
          "Excluir"=>["excluir_usuario.php","excluir_perfil.php","excluir_cliente.php","excluir_fornecedor.php","excluir_produto.php","excluir_funcionario.php"]],

    2 => ["Cadastrar"=>["cadastro_cliente.php"],
          "Buscar"=>["buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php"],
          "Alterar"=>["alterar_cliente.php","alterar_fornecedor.php"]], 

    3 => ["Cadastrar" =>["cadastro_fornecedor.php","cadastro_produto.php"],
          "Buscar" =>["buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php"],
          "Alterar" =>["alterar_fornecedor.php","alterar_produto.php"],
          "Exluir" =>["excluir_produto.php"]],

    4 => ["Cadastrar"=>["cadastro_cliente.php"],
          "Buscar"=>["buscar_produto.php"],
          "Alterar"=>["alterar_cliente.php"]],
   ];

   //Obtendo as opções disponiveis para o perfil logado
   $opcoes_menu = $permissoes[$id_perfil];
    
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Painel Principal</title>
      <link rel="stylesheet" href="styles.css">
      <script src="scripts.js"></script>

</head>
<body>
      <header>
            <div class="saudacao">
                  <h2>Bem Vindo, <?php echo $_SESSION["usuario"];?>! Perfil: <?php echo $nome_perfil;?></h2>
            </div>

            <div class="logout">
                  <form action="logout.php" method="POST">
                        <button type="submit">Logout</button>
            </div>
      </header>

      <nav>
            <ul class="menu">
                  <?php foreach($opcoes_menu as $categoria => $arquivos):?>
                        <li class="dropdown">
                              <a href="#"><?=$categoria?></a>
                              <ul class="dropdown-menu">
                              <?php foreach($arquivos as $arquivo):?>
                                    <li>
                                          <a href="<?= $arquivo ?>"><?=ucfirst(str_replace("_"," ",basename($arquivo,".php")))?></a>
                                    </li>
                                    <?php endforeach;?> 
                              </ul>
                        </li>
                  <?php endforeach;?> 
            </ul>
      </nav>
</body>
</html>
   


