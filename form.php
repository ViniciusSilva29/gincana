<?php

// Ler dados do arquivo
$arquivo = "dados.json";

if(file_exists($arquivo)){
  $conteudo = file_get_contents($arquivo);
  $dados = json_decode($conteudo, true);
} else {
  $dados = [
    "pontuacao" => [
      "9º ANO" => 0,
      "1º EM" => 0,
      "2º EM" => 0,
      "3º EM" => 0
    ],
    "jogos" => []
  ];
}

// Executa apenas quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){

  $equipe1 = $_POST["equipe1"];
  $equipe2 = $_POST["equipe2"];
  $modalidade = $_POST["modalidade"];
  $vencedor = $_POST["vencedor"];

    //Evita que a mesma equipe jogue contra ela mesma
    if($equipe1 != $equipe2){

    // Adiciona um novo jogo ao array jogos
    $dados["jogos"][] = [
      "equipe1" => $equipe1,
      "equipe2" => $equipe2,
      "modalidade" => $modalidade,
      "vencedor" => $vencedor
    ];

    // Soma 1 ponto para a equipe vencedora
    $dados["pontuacao"][$vencedor] += 1;

    // Salvar com fopen
    $fp = fopen($arquivo, "w");
    fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT));
    fclose($fp);
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gincana - SENAI</title>
<link rel="stylesheet" href="form.css">
</head>
<body>

<header>
  <h1> Gincana Esportiva SENAI</h1>
  <img src="img/sesilogo.png" alt="" width="250em">
</header>

    <div class="rodape">
        <h1>
            <a href="index.php">Voltar</a>
        </h1>
    </div>

<section>
  <h2>Cadastro de Jogos</h2>

  <form method="POST">
    <label>Equipe 1:</label>
    <select name="equipe1">
      <option>9º ANO</option>
      <option>1º EM</option>
      <option>2º EM</option>
      <option>3º EM</option>
    </select>

    <label>Equipe 2:</label>
    <select name="equipe2">
      <option>9º ANO</option>
      <option>1º EM</option>
      <option>2º EM</option>
      <option>3º EM</option>
    </select>

    <label>Modalidade:</label>
    <select name="modalidade" id="">
        <option value="VOLEIBOL">VOLEIBOL</option>
        <option value="PEBOLIM">PEBOLIM</option>
        <option value="CABO DE GUERRA">CABO DE GUERRA</option>
        <option value="PENALIDADES">PANALIDADES</option>
        <option value="TÊNIS DE MESA">TÊNIS DE MESA</option>
        <option value="EMBAIXADINHA">EMBAIXADINHA</option>
        <option value="CAMPO MINADO">CAMPO MINADO</option>
        <option value="LANCE LIVRE">LANCE LIVRE</option>
        <option value="QUEIMADA">QUEIMADA</option>
    </select>

    <label>Vencedor:</label>
    <select name="vencedor">
      <option>9º ANO</option>
      <option>1º EM</option>
      <option>2º EM</option>
      <option>3º EM</option>
    </select>

    <button type="submit">Registrar</button>
  </form>
</section>

<section>
  <h2> Classificação</h2>

  <table>
    <tr>
      <th>Turma</th>
      <th>Pontos</th>
    </tr>

    <?php foreach($dados["pontuacao"] as $turma => $pontos): ?>
      <tr>
        <td><?= $turma ?></td>
        <td><?= $pontos ?></td>
      </tr>
    <?php endforeach; ?>

  </table>
</section>

<section>
  <h2> Jogos Registrados</h2>

  <ul>
    <?php foreach($dados["jogos"] as $jogo): ?>
      <li>
        <?= $jogo["equipe1"] ?> x <?= $jogo["equipe2"] ?> 
        (<?= $jogo["modalidade"] ?>) - 
        Vencedor: <strong><?= $jogo["vencedor"] ?></strong>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

<div class="img">
      <img src="img/bloco1.png" alt="bloco 1" width="400em" height="400em">
      <img src="img/bloco 2.png" alt="bloco 2" width="400em" height="400em">
      <img src="img/bloco3.png" alt="bloco 3" width="400em" height="400em">
      <br>
      <br>
</div>

<div class="informacoes">
    <p> <strong>Edifício sede FIESP</strong>
        Av. Paulista, 1313 <br>
        CEP: 01311-923
    </p>

    <p>Grande São Paulo: <strong>(11) 3322-0050</strong>
    <br>
    Outras Localidades: <strong>0800 055 1000</strong>
    </p>
</div>

<footer>
    &COPY; Todos os direitos reservados - SENAI
</footer>

</body>
</html>