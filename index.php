<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inglaterra</title>
  <!--css-->
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <!--Navbar-->
  <nav class="navbar">
    <ul class="nav-links">
      <li class="active"><a href="index.php">INICIO</a></li>
      <li><a href="cultura.html">CULTURA</a></li>
      <li><a href="turismo.html">TURISMO</a></li>
    </ul>
    <ul>
      <li class="admin-link"><a href="admin-login.html" target="_blank">ÁREA DO ADMINISTRADOR</a></li>
    </ul>
  </nav>
  
  <header>
    <div class="header-content">
      <h2>Explore a Inglaterra</h2>
      <div class="line"></div>
      <h1>AS MARAVILHAS DESSE PAÍS</h1>
      <a href="#" class="ctn">Veja Mais</a>
    </div>
  </header>
  
  <!-- Texto -->
  <section class="events">
    <div class="title">
      <h1> Bem vindo a Inglaterra</h1>
      <div class="line"></div>
    </div>
    <div class="row">
      <div class="col">
        <img src="./img/telefone.jpeg" alt="">
        <h4>LONDRES</h4>
        <p>Você já ouviu falar da icônica cidade de Londres, não é mesmo? Mas você sabe tudo sobre Londres? Ou como é viver em Londres?</p>
        <a href="londres.html" class="ctn">Veja mais</a>
      </div>
      <div class="col">
        <img src="./img/familiareal.jpg" alt="Imagem da Família Real">
        <h4>FAMÍLIA REAL</h4>
        <p>A família real britânica é aquela quem ocupa o trono britânico, sendo vinculada atualmente à dinastia Windsor, surgida em 1917. Essa dinastia foi fundada para substituir a dinastia Saxe-Coburgo-Gota. Até o presente, a Casa de Windsor teve cinco monarcas no trono britânico.</p>
        <a href="familia_real.html" class="ctn">Veja mais</a>
      </div>
    </div> 
    <div class="row">
      <div class="col">
        <img src="./img/turismo1.jpg" alt="Atrações Turísticas">
        <h4>Atrações Turísticas</h4>
        <p>Inglaterra oferece uma gama diversificada de atrações turísticas, desde os icônicos marcos históricos como o Big Ben e a Tower Bridge até os modernos museus e galerias de arte.</p>
        <a href="turismo.html" class="ctn">Veja mais</a>
      </div>
      <div class="col">
        <img src="./img/cultura4.jpg" alt="Teatro e Cinema">
        <h4>Teatro e Cinema</h4>
        <p>O Reino Unido é conhecido por sua forte tradição teatral, com o West End em Londres sendo um dos principais centros de teatro do mundo. O cinema britânico também é amplamente respeitado.</p>
        <a href="cultura.html" class="ctn">Veja mais</a>
      </div>
    </div>
  </section>

  <!-- Formulário de Contato -->
  <section class="contact-form">
    <div class="title">
      <h1>Deixe seu Comentário</h1>
      <div class="line"></div>
    </div>
    <form enctype="multipart/form-data" action="coment-gravar.php" method="post">
      <div class="form-group">
        <label for="txtnome">Nome:</label>
        <input type="text" name="txtnome" required>
      </div>
      <div class="form-group">
        <label for="txtemail">Email:</label>
        <input type="email" name="txtemail" required>
      </div>
      <div class="form-group">
        <label for="txtcomentario">Comentário:</label>
        <textarea name="txtcomentario" rows="4" required></textarea>
      </div>
      <button type="submit">Enviar</button>
    </form>
  </section>

  <!-- Comentários Aprovados -->
  <section class="approved-comments">
    <div class="title">
      <h1>Comentários Aprovados</h1>
      <div class="line"></div>
    </div>
    <div class="comments-container">
      <?php
        require_once 'conexao.php';
        require_once 'classes/Comentario.php';
        
        $comentario = new Comentario($conn);
        $comentariosAprovados = $comentario->listarAprovados();

        if (!empty($comentariosAprovados)) {
            foreach ($comentariosAprovados as $coment) {
                echo "<div class='comment'>";
                echo "<h3>" . htmlspecialchars($coment['nome']) . "</h3>";
                echo "<p>" . htmlspecialchars($coment['comentario']) . "</p>";
                echo "<span>" . htmlspecialchars($coment['data_formatada']) . "</span>";
                echo "<br>";
                echo "-----------------------------------------------------------------------";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhum comentário aprovado ainda.</p>";
        }

        $conn->close();
      ?>
    </div>
  </section>

  <script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
      this.classList.toggle('active');
      document.querySelector('.nav-links').classList.toggle('active');
    });

    document.getElementById('comentarioForm').addEventListener('submit', function(event) {
      var nome = document.getElementById('txtnome').value;
      var email = document.getElementById('txtemail').value;
      var comentario = document.getElementById('txtcomentario').value;

      if (nome === '' || email === '' || comentario === '') {
        alert('Por favor, preencha todos os campos.');
        event.preventDefault(); // Impede o envio do formulário
      }
    });
  </script>
</body>
</html>
