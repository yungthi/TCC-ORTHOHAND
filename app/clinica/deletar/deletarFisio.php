<?php
	session_start();
	$logged = $_SESSION['clinica'] ?? NULL;
	if(!$logged) die ('Sessão Encerrada!');

	$email = $_SESSION['email'];
	$senha = $_SESSION['senha'];

	/* #Pegar nome da Clinica */
		//Conexão com o banco
		include_once("../../../conexao.php");
		//Pegar ID do usuario
		$sqlUsu = "SELECT id_usuario FROM tb_usuarios WHERE email = '$email' AND senha = '$senha'";

		//Executando p ver se existe
		$resultUsu = $conexao->query($sqlUsu);
		while($row = mysqli_fetch_array($resultUsu)){
			$idUsu = $row['id_usuario'];
		}
		
		//Pegar nome do usuario
		$sqlNm = "select cl.nome from tb_clinica as cl join tb_usuarios as us on (us.id_usuario = cl.id_usuario) where cl.id_usuario = ".$idUsu;

		//executando p ver se existe
		$resultNome = $conexao->query($sqlNm);
		while($row = mysqli_fetch_array($resultNome)){
			$nomeCli = $row['nome'];
		}
	/* # */
	/* #Pegar id da clinica */
		$sqlID = "Select id_clinica from tb_clinica where id_usuario =".$idUsu;
			
		$resultID = $conexao->query($sqlID);
		while($row = mysqli_fetch_array($resultID)){
			$idClinica = $row['id_clinica'];
		}
		$_SESSION['id_clinica'] = $idClinica;
	/* # */

	/* #Parte da edição de dados */
        if(!empty($_GET['idFisio'])){

            $idFisio = $_GET['idFisio'];
            
            $sqlSelect = "select me.nome, me.cpf, me.crefito, me.dt_nascimento, me.genero, us.email from tb_medico as me join tb_usuarios as us on (me.id_usuario = us.id_usuario) where me.id_medico = $idFisio";

            $result = $conexao->query($sqlSelect);

            if($result->num_rows > 0){
                while($user_data = mysqli_fetch_assoc($result)){
                    $nome = $user_data['nome'];
                    $cpf = $user_data['cpf'];
                    $crefito = $user_data['crefito'];
                    $dt_nascimento = $user_data['dt_nascimento'];
                    $genero = $user_data['genero'];
                    $email = $user_data['email'];
                }
            }
            else{
                header('Location: medicFisio.php');
            }
        }
	/* # */

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Deletar fisioterapeuta</title>
		<link rel="icon" href="../../../img/logoicon.png">
		<meta charset="utf-8" />
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../../assets/css/main.css" />
	</head>
	<body class="is-preload">
		
		<!-- #sidebar -->
		<?php include('../sidebarClinicaPaste.php'); ?>

		<section class="home-section">
			
			<div class="home-content">
				<i class='bx bx-menu'></i>
				<span class="text">Deletar <span>Fisioterapeuta</span>
			</div>

		<!-- Content -->
			<div id="content">

				<div class="row-del">
					<div class="col-6" >
						<form action="../edit/saveDelFisio.php" method="post">

							<div class="">
								<div class="input-group">
									<input class="id-del" type="text" name="idFisio" value="<?php echo $idFisio; ?>" readonly>
								</div>
							</div>

							<div class="input-del-usuarios">
								<h2 class="">Deseja apagar o fisioterapeuta, <span> <?php echo $nome;?></span>? </h2><br>
								<div class="input-group">
									<input class="form-control" type="radio" name="confirmacao" value="Sim">
									<label class="sim" for="Sim">Sim</label>

									<input class="form-control" type="radio" name="confirmacao" value="Nao" checked>
									<label for="Nao">Não</label>
								</div>
							</div>

							<div class="agenda-botao">
								<input class="concluir-btn" type="submit" value="Confirmar" name="deletarFisio">
							</div>

						</form>
					</div>
				</div> 
			</div>

		</section>

			
<!-- #region Scripts -->
		<!-- Scripts -->
			<script src="../../assets/js/jquery.min.js"></script>
			<script src="../../assets/js/browser.min.js"></script>
			<script src="../../assets/js/breakpoints.min.js"></script>
			<script src="../../assets/js/util.js"></script>
			<script src="../../assets/js/mainEdit.js"></script>
<!-- #endregion -->

	</body>
</html>