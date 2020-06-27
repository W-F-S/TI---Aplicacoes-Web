<?php
	
	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$ids = array();
	$names = array();
	$grades = array();
	$tasks = array();
	$users = array();
	$current_id;
	$aux = 0;
	$error_msg = "";

	$sql = "SELECT id, name, grade, file_name, usertype FROM users ORDER BY id ASC";

	if($stmt = $pdo->prepare($sql))
	{
		if($stmt->execute())
		{
			if($stmt->rowCount() > 0)
				while($row = $stmt->fetch())
				{
					$ids[$aux] = $row["id"];
					$names[$aux] = $row["name"];
					$grades[$aux] = $row["grade"];
					$tasks[$aux] = $row["file_name"];
					$users[$aux] = $row["usertype"];
					$aux++;
				}

			else
				$error_msg = "Não há alunos cadastrados.";
		}

		else
			$error_msg = "Algo deu errado. Por favor tente mais tarde.";

		unset($stmt);
		unset($pdo);

	}

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_SESSION["grade"] = $_POST["change"];
		header("location: change_all_datas.php");
		exit;
	}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Administrador</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 20px sans-serif;
			text-align: center;
		}

		.wrapper
		{	
			width: 100%;
			padding: 30px;
			text-align: left;
		}

		th, td
		{
			padding: 5px;
		}

		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button
		{
			-webkit-appearance: none;
		}

		input
		{
			width: 55px;
			text-align: center !important;
		}

		.success
		{
			border-color: #4CAF50;
			background-color: white;
			color: green;
		}

		.success:hover
		{
			background-color: #4CAF50;
			color: white;
		}

		.info
		{
			border-color: #2196F3;
			background-color: white;
			color: dodgerblue;
		}

		.info:hover
		{
			background: #2196F3;
			color: white;
		}

		.semi-danger
		{	
			border-color: #FF9800;
			background-color: white;
			color: orange;
		}

		.semi-danger:hover
		{
			background: #FF9800;
			color: white;
		}

		.dark-orange
		{	
			border-color: #FF4500;
			background-color: white;
			color: orangered;
		}

		.dark-orange:hover
		{
			background: #FF4500;
			color: white;
		}

		.danger
		{
			border-color: #F44336;
			background-color: white;
			color: red;
		}

		.danger:hover
		{
			background: #F44336;
			color: white;
		}

		.gray
		{
			border-color: #E7E7E7;
			background-color: white;
			color: black;
		}

		.gray:hover
		{
			background: #E7E7E7;
		}


	</style>

	<script type="text/javascript">
		
		function getInfo(current_id) 
		{
			document.getElementById(current_id).click();
		}

	</script>

</head>

<body>

	<div class="page-header">

		<h1>Olá, <b><?php echo htmlspecialchars($_SESSION["usertype"])." ". htmlspecialchars($_SESSION["name"]); ?></b>, bem vindo ao site!</h1>

	</div>
	<div class="wrapper">

		<h1>Lista de Professores</h1>
		<br>

		<table style='width: 100%;'>
			
			<tr>
				
				<th>ID</th>
				<th>Nome</th>

			</tr>

			<?php
				
				for ($i = 0; $i < $aux; $i++)
				{	
					if($users[$i] == "Professor")
					{
						$current_id = $ids[$i];
						echo "<tr><td style='width: 100px;'>".htmlspecialchars($ids[$i])."</td>";
						echo "<td style='width: 300px;'>".htmlspecialchars($names[$i])."</td>";


						echo "<td><form action='info.php' method='post'><input type='submit' id='$current_id' name='info' class='btn info' value='$current_id' style='display: none;'></form></td>";


						echo "<td style='display: inline-block;'><button type='button' name='info' class='btn info' onclick='getInfo($current_id);'>Info</button></td>";


						echo "<td style='display: inline-block;'><form action='admin.php' method='post'><button type='submit' name='change' class='btn semi-danger' value='$current_id'>Alterar Dados</button></form></td>";

						echo "<td style='display: inline-block;'><form action='aux_reset_users_password.php' method='post'><button type='submit' name='change' class='btn dark-orange' value='$current_id'>Resetar Senha</button></form></td>";

						echo "<td style='display: inline-block;'><form action='delete_user.php' method='post'><button type='submit' name='delete_user' class='btn danger' value='$current_id'>Excluir</button></form></td></tr>";
					}							
				}
			?>

		</table>

	</div>	

	<div class="wrapper">

		<h1>Lista de Alunos</h1>
		<br>

		<table style='width: 100%;'>
			<tr>
				
				<th>ID</th>
				<th>Nome</th>
				<th>Nota</th>
				<th>Trabalho</th>

			</tr>
		
			<?php

				$button_grade = "<form action='send_grade.php' method='post'><td style='display: inline-block;'><input type='number' min='0' max='100' value='' step='any' name='grade' class='btn info'>";
				
				for ($i = 0; $i < $aux; $i++)
				{	
					if($users[$i] == "Estudante")
					{
						$current_id = $ids[$i];
						echo "<tr><td style='width: 100px;'>".htmlspecialchars($ids[$i])."</td>";
						echo "<td style='width: 400px;'>".htmlspecialchars($names[$i])."</td>";
						echo "<td style='width: 100px;'>".htmlspecialchars($grades[$i])."</td>";
						echo "<td style='width: 400px;'>".htmlspecialchars($tasks[$i])."</td>";

						echo "<td><form action='info.php' method='post'><input type='submit' id='$current_id' name='info' class='btn btn-primary' value='$current_id' style='display: none;'></form></td>";

						echo "<td style='display: inline-block;'><button type='button' name='info' class='btn info' onclick='getInfo($current_id);'>Info</button></td>";

						echo "<td style='display: inline-block;'><form action='admin.php' method='post'><button type='submit' name='change' class='btn semi-danger' value='$current_id'>Alterar Dados</button></form></td>";

						echo "<td style='display: inline-block;'><form action='aux_reset_users_password.php' method='post'><button type='submit' name='change' class='btn dark-orange' value='$current_id'>Resetar Senha</button></form></td>";

						echo "<td style='display: inline-block;'><form action='download.php' method='post'><button type='submit' name='download' class='btn gray' value='$current_id'>Download</button></form></td>";

						echo $button_grade;

						echo "<td style='display: inline-block;'><button type='submit' name='send_grade' class='btn success' value='$current_id'>Enviar Nota</button></td></form>";

						echo "<td style='display: inline-block;'><form action='delete_task.php' method='post'><button type='submit' name='delete_task' class='btn semi-danger' value='$current_id'>Excluir Trabalho</button></form></td>";

						echo "<td style='display: inline-block;'><form action='delete_user.php' method='post'><button type='submit' name='delete_user' class='btn danger' value='$current_id'>Excluir</button></form></td></tr>";
					}							
				}
			?>

		</table>

	</div>

	<div class="form-group">

		<a href="logout.php" class="btn danger">Logout</a>

	</div>

</body>
</html>
<?php
	
	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$ids = array();
	$names = array();
	$grades = array();
	$tasks = array();
	$users = array();
	$current_id;
	$aux = 0;
	$error_msg = "";

	$sql = "SELECT id, name, grade, file_name, usertype FROM users ORDER BY id ASC";

	if($stmt = $pdo->prepare($sql))
	{
		if($stmt->execute())
		{
			if($stmt->rowCount() > 0)
				while($row = $stmt->fetch())
				{
					$ids[$aux] = $row["id"];
					$names[$aux] = $row["name"];
					$grades[$aux] = $row["grade"];
					$tasks[$aux] = $row["file_name"];
					$users[$aux] = $row["usertype"];
					$aux++;
				}

			else
				$error_msg = "Não há alunos cadastrados.";
		}

		else
			$error_msg = "Algo deu errado. Por favor tente mais tarde.";

		unset($stmt);
		unset($pdo);

	}

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_SESSION["grade"] = $_POST["change"];
		header("location: change_all_datas.php");
		exit;
	}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Administrador</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 20px sans-serif;
			text-align: center;
		}

		.wrapper
		{	
			width: 100%;
			padding: 30px;
			text-align: left;
		}

		th, td
		{
			padding: 5px;
		}

		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button
		{
			-webkit-appearance: none;
		}

		input
		{
			width: 55px;
			text-align: center !important;
		}

		.success
		{
			border-color: #4CAF50;
			background-color: white;
			color: green;
		}

		.success:hover
		{
			background-color: #4CAF50;
			color: white;
		}

		.info
		{
			border-color: #2196F3;
			background-color: white;
			color: dodgerblue;
		}

		.info:hover
		{
			background: #2196F3;
			color: white;
		}

		.semi-danger
		{	
			border-color: #FF9800;
			background-color: white;
			color: orange;
		}

		.semi-danger:hover
		{
			background: #FF9800;
			color: white;
		}

		.dark-orange
		{	
			border-color: #FF4500;
			background-color: white;
			color: orangered;
		}

		.dark-orange:hover
		{
			background: #FF4500;
			color: white;
		}

		.danger
		{
			border-color: #F44336;
			background-color: white;
			color: red;
		}

		.danger:hover
		{
			background: #F44336;
			color: white;
		}

		.gray
		{
			border-color: #E7E7E7;
			background-color: white;
			color: black;
		}

		.gray:hover
		{
			background: #E7E7E7;
		}


	</style>

	<script type="text/javascript">
		
		function getInfo(current_id) 
		{
			document.getElementById(current_id).click();
		}

	</script>

</head>

<body>

	<div class="page-header">

		<h1>Olá, <b><?php echo htmlspecialchars($_SESSION["usertype"])." ". htmlspecialchars($_SESSION["name"]); ?></b>, bem vindo ao site!</h1>

	</div>
	<div class="wrapper">

		<h1>Lista de Professores</h1>
		<br>

		<table style='width: 100%;'>
			
			<tr>
				
				<th>ID</th>
				<th>Nome</th>

			</tr>

			<?php
				
				for ($i = 0; $i < $aux; $i++)
				{	
					if($users[$i] == "Professor")
					{
						$current_id = $ids[$i];
						echo "<tr><td style='width: 100px;'>".htmlspecialchars($ids[$i])."</td>";
						echo "<td style='width: 300px;'>".htmlspecialchars($names[$i])."</td>";


						echo "<td><form action='info.php' method='post'><input type='submit' id='$current_id' name='info' class='btn info' value='$current_id' style='display: none;'></form></td>";


						echo "<td style='display: inline-block;'><button type='button' name='info' class='btn info' onclick='getInfo($current_id);'>Info</button></td>";


						echo "<td style='display: inline-block;'><form action='admin.php' method='post'><button type='submit' name='change' class='btn semi-danger' value='$current_id'>Alterar Dados</button></form></td>";

						echo "<td style='display: inline-block;'><form action='aux_reset_users_password.php' method='post'><button type='submit' name='change' class='btn dark-orange' value='$current_id'>Resetar Senha</button></form></td>";

						echo "<td style='display: inline-block;'><form action='delete_user.php' method='post'><button type='submit' name='delete_user' class='btn danger' value='$current_id'>Excluir</button></form></td></tr>";
					}							
				}
			?>

		</table>

	</div>	

	<div class="wrapper">

		<h1>Lista de Alunos</h1>
		<br>

		<table style='width: 100%;'>
			<tr>
				
				<th>ID</th>
				<th>Nome</th>
				<th>Nota</th>
				<th>Trabalho</th>

			</tr>
		
			<?php

				$button_grade = "<form action='send_grade.php' method='post'><td style='display: inline-block;'><input type='number' min='0' max='100' value='' step='any' name='grade' class='btn info'>";
				
				for ($i = 0; $i < $aux; $i++)
				{	
					if($users[$i] == "Estudante")
					{
						$current_id = $ids[$i];
						echo "<tr><td style='width: 100px;'>".htmlspecialchars($ids[$i])."</td>";
						echo "<td style='width: 400px;'>".htmlspecialchars($names[$i])."</td>";
						echo "<td style='width: 100px;'>".htmlspecialchars($grades[$i])."</td>";
						echo "<td style='width: 400px;'>".htmlspecialchars($tasks[$i])."</td>";

						echo "<td><form action='info.php' method='post'><input type='submit' id='$current_id' name='info' class='btn btn-primary' value='$current_id' style='display: none;'></form></td>";

						echo "<td style='display: inline-block;'><button type='button' name='info' class='btn info' onclick='getInfo($current_id);'>Info</button></td>";

						echo "<td style='display: inline-block;'><form action='admin.php' method='post'><button type='submit' name='change' class='btn semi-danger' value='$current_id'>Alterar Dados</button></form></td>";

						echo "<td style='display: inline-block;'><form action='aux_reset_users_password.php' method='post'><button type='submit' name='change' class='btn dark-orange' value='$current_id'>Resetar Senha</button></form></td>";

						echo "<td style='display: inline-block;'><form action='download.php' method='post'><button type='submit' name='download' class='btn gray' value='$current_id'>Download</button></form></td>";

						echo $button_grade;

						echo "<td style='display: inline-block;'><button type='submit' name='send_grade' class='btn success' value='$current_id'>Enviar Nota</button></td></form>";

						echo "<td style='display: inline-block;'><form action='delete_task.php' method='post'><button type='submit' name='delete_task' class='btn semi-danger' value='$current_id'>Excluir Trabalho</button></form></td>";

						echo "<td style='display: inline-block;'><form action='delete_user.php' method='post'><button type='submit' name='delete_user' class='btn danger' value='$current_id'>Excluir</button></form></td></tr>";
					}							
				}
			?>

		</table>

	</div>

	<div class="form-group">

		<a href="logout.php" class="btn danger">Logout</a>

	</div>

</body>
</html>
<?php
	
	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_SESSION["grade"] = $_POST["change"];
		header("location: reset_users_password.php");
		exit;
	}

?>
<?php

include "is_loggedin.php";

isLoggedin();

require_once "config.php";

include "validate_cpf.php";

include "validate_date.php";

 $id = $name = $cpf = $birthdate = $address = $phone = "";

$new_name = $new_cpf = $new_birthdate = $new_address = $new_phone = $new_usertype = "";

$new_cpf_err = $new_birthdate_err = $new_phone_err = "";	

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "SELECT * FROM users WHERE id = :id";

    if($stmt = $pdo->prepare($sql))
    {
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

        $param_id = $_SESSION["grade"];

        if($stmt->execute())
        {
            if($stmt->rowCount() == 1)
            {
                if($row = $stmt->fetch())
                {
                    $id = $row["id"];
                    $name = $row["name"];
                    $cpf = $row["cpf"];
                    $birthdate = $row["birthdate"];
                    $address = $row["address"];
                    $phone = $row["phone"];
                }
            }
        }

        unset($stmt);
    }

    if(empty(trim($_POST["new_name"])))
        $new_name = $name;

    else
        $new_name = ($_POST["new_name"]);
        
    if(!empty(trim($_POST["new_cpf"])) && !(validateCpf($_POST["new_cpf"])))
        $new_cpf_err = "CPF inválido.";

    elseif(!empty(trim($_POST["new_cpf"])) && (validateCpf($_POST["new_cpf"])))
    {
        $sql = "SELECT id FROM users WHERE cpf = :cpf";

        if($stmt = $pdo->prepare($sql))
        {
            $stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR);

            $param_cpf = ($_POST["new_cpf"]);

            if($stmt->execute())
            {
                if($stmt->rowCount() == 1)
                    $new_cpf_err = "CPF já cadastrado.";

                else
                    $new_cpf = ($_POST["new_cpf"]);
            }

            else
                echo "Algo deu errado, tente novamente mais tarde.";			
        }

        unset($stmt);
        
    }

    else
        $new_cpf = $cpf;

    if(!empty(trim($_POST["new_birthdate"])) && validateDate($_POST["new_birthdate"]))
        $new_birthdate = ($_POST["new_birthdate"]);

    elseif(!empty(trim($_POST["new_birthdate"])) && !validateDate($_POST["new_birthdate"]))
        $new_birthdate_err = "Insira uma data válida.";

    else
        $new_birthdate = $birthdate;			

    if(!empty(trim($_POST["new_address"])))
        $new_address = ($_POST["new_address"]);

    else
        $new_address = $address;

    if((!empty(trim($_POST["new_phone"]))) && (strlen($_POST["new_phone"]) >= 10))
        $new_phone = ($_POST["new_phone"]);

    elseif((!empty(trim($_POST["new_phone"]))) && (strlen($_POST["new_phone"]) < 10))
        $new_phone_err = "Insira um telefone válido.";

    else
        $new_phone = $phone;

    if(empty($new_birthdate_err) && empty($new_phone_err) && empty($new_cpf_err))
    {
        $sql = "UPDATE users SET name = :name, cpf = :cpf, birthdate = :birthdate, address = :address, phone = :phone WHERE id = :id";

        if($stmt = $pdo->prepare($sql))
        {
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR);
            $stmt->bindParam(":birthdate", $param_birthdate, PDO::PARAM_STR);
            $stmt->bindParam(":address", $param_address, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);

            $param_id = $id;
            $param_name = $new_name;
            $param_cpf = $new_cpf;
            $param_birthdate = $new_birthdate;
            $param_address = $new_address;
            $param_phone = $new_phone;

            if($stmt->execute())
            {	
                header("location: users.php");
                exit();
            }

            else
                echo "Algo deu errado! Por favor tente novamente mais tarde.";
        }

        unset($stmt);
    }

    unset($pdo);

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<title>Alterar Dados</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

<style type="text/css">
    
    body
    {
        font: 14px sans-serif;
    }

    .title
    {
        width: 450px; 
        padding: 20px;
    }

    .wrapper
    {
        width: 350px; 
        padding: 20px; 
        margin-top: -30px;
    }

</style>

</head>

<body>

<div class="title">
    
    <h2>Alterar Dados</h2>
    <p>Preencha os desejados campos para alterar os dados cadastrais.</p>
    <br>

</div>

<div class="wrapper">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
        <div class="form-group">

            <label>Nome Completo</label>
            <input type="text" name="new_name" class="form-control" value="<?php echo $new_name; ?>">

        </div>

        <div class="form-group <?php echo (!empty($cpf_err)) ? 'Erro' : ''; ?>">

            <label>CPF</label>
            <input type="text" name="new_cpf" class="form-control" value="<?php echo $new_cpf; ?>">
            <span class="help-block">
                <?php echo $new_cpf_err; ?>
            </span>

        </div>

        <div class="form-group <?php echo (!empty($new_birthdate_err)) ? 'Erro' : ''; ?>">

            <label>Data de Nascimento</label>

            <input type="text" name="new_birthdate" class="form-control" value="<?php echo $new_birthdate; ?>">
            <span class="help-block">
                <?php echo $new_birthdate_err; ?>
            </span>

        </div>

        <div class="form-group">

            <label>Endereço</label>
            <input type="text" name="new_address" class="form-control" value="<?php echo $new_address; ?>">

        </div>	

        <div class="form-group <?php echo (!empty($new_phone_err)) ? 'Erro' : ''; ?>">

            <label>Telefone</label>
            <input type="tel" name="new_phone" class="form-control" value="<?php echo $new_phone; ?>">
            <span class="help-block">
                <?php echo $new_phone_err; ?>
            </span>

        </div>	

        <div class="form-group">

            <button type="submit" class="btn btn-primary" value="submit">Enviar</button>
            <button type="reset" class="btn btn-default" value="reset">Resetar</button>
            <button type="button" class="btn btn-link" value="go_back"><a href="users.php">Voltar</a></button>

        </div>

    </form>

</div>

</body>
</html>
<?php

	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	include "validate_date.php";

	$new_name = $new_birthdate = $new_address = $new_phone = "";

	$new_birthdate_err = $new_phone_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["new_name"])))
			$new_name = ($_SESSION["name"]);

		else
			$new_name = ($_POST["new_name"]);

		if(empty(trim($new_birthdate)))
			$new_birthdate = ($_SESSION["birthdate"]);

		elseif(!validateDate($_POST["new_birthdate"]))
			$new_birthdate_err = "Insira uma data válida.";

		else
			$new_birthdate = ($_POST["new_birthdate"]);

		if(empty(trim($_POST["new_address"])))
			$new_address = $_SESSION["address"];

		else
			$new_address = ($_POST["new_address"]);

		if(empty(trim($_POST["new_phone"])))
			$new_phone = ($_SESSION["phone"]);

		elseif((!empty(trim($_POST["new_phone"]))) && (strlen($_POST["new_phone"]) < 10))
			$new_phone_err = "Insira um telefone válido.";

		else
			$new_phone = ($_POST["new_phone"]);

		if(empty($new_birthdate_err) && empty($new_phone_err))
		{
			$sql = "UPDATE users SET name = :name, birthdate = :birthdate, address = :address, phone = :phone WHERE id = :id";

			if($stmt = $pdo->prepare($sql))
			{
				$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
				$stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
				$stmt->bindParam(":birthdate", $param_birthdate, PDO::PARAM_STR);
				$stmt->bindParam(":address", $param_address, PDO::PARAM_STR);
				$stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);

				$param_id = ($_SESSION["id"]);
				$param_name = $new_name;
				$param_birthdate = $new_birthdate;
				$param_address = $new_address;
				$param_phone = $new_phone;

				if($stmt->execute())
				{	
					$_SESSION["name"] = $new_name;
					header("location: users.php");
					exit();
				}

				else
					echo "Algo deu errado! Por favor tente novamente mais tarde.";
			}

			unset($stmt);
		}

		unset($pdo);

	}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="pt-br">

	<title>Alterar Dados</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 14px sans-serif;
		}

		.title
		{
			width: 450px; 
			padding: 20px;
		}

		.wrapper
		{
			width: 350px; 
			padding: 20px; 
			margin-top: -30px;
		}

	</style>

</head>

<body>

	<div class="title">

		<h2>Alterar os dados cadastrais</h2>
		<p>Preencha os desejados campos para alterar os dados cadastrais.</p>

	</div>

	<div class="wrapper">

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
			<div class="form-group">

				<label>Nome Completo</label>
				<input type="text" name="new_name" class="form-control" value="<?php echo $new_name; ?>">

			</div>

			<div class="form-group <?php echo (!empty($new_birthdate_err)) ? 'Erro' : ''; ?>">

				<label>Data de Nascimento</label>

				<input type="text" name="new_birthdate" class="form-control" value="<?php echo $new_birthdate; ?>">
				<span class="help-block">
					<?php echo $new_birthdate_err; ?>
				</span>

			</div>

			<div class="form-group">

				<label>Endereço</label>
				<input type="text" name="new_address" class="form-control" value="<?php echo $new_address; ?>">

			</div>	

			<div class="form-group <?php echo (!empty($new_phone_err)) ? 'Erro' : ''; ?>">

				<label>Telefone</label>
				<input type="tel" name="new_phone" class="form-control" value="<?php echo $new_phone; ?>">
				<span class="help-block">
					<?php echo $new_phone_err; ?>
				</span>

			</div>	

			<div class="form-group">

				<button type="submit" class="btn btn-primary" value="submit">Enviar</button>
				<button type="reset" class="btn btn-default" value="reset">Resetar</button>
				<button type="button" class="btn btn-link" value="go_back"><a href="users.php">Voltar</a></button>

			</div>

		</form>

	</div>

</body>
</html>
<?php 
	
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'schoolDB');

	try
	{
		$pdo = new PDO("mysql:host=" . DB_SERVER . "; dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e)
	{
		die("ERROR: Could not connect. " . $e->getMessage());
	}

?>
<?php
	
	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$sql = "UPDATE users SET file_name = :file_name, grade = :grade WHERE id = :id";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if($stmt = $pdo->prepare($sql))
		{
			$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
			$stmt->bindParam(":file_name", $param_file_name, PDO::PARAM_STR);
			$stmt->bindParam(":grade", $param_grade, PDO::PARAM_STR);

			$param_id = $_POST["delete_task"];
			$param_file_name = "Não Enviado";
			$param_grade = "0";


			if($stmt->execute())
			{
				header("location: users.php");
				exit();
			}

			unset($stmt);
			unset($pdo);
		}
	}

?>
<?php
	
	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$sql = "DELETE FROM users WHERE id = :id";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if($stmt = $pdo->prepare($sql))
		{
			$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

			$param_id = $_POST["delete_user"];

			if($stmt->execute())
			{
				header("location: users.php");
				exit();
			}

			unset($stmt);
			unset($pdo);
		}
	}

?>
<?php

include "is_loggedin.php";

isLoggedin();

require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "SELECT file_name FROM users WHERE id = :id";

    if($stmt = $pdo->prepare($sql))
    {
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

        $param_id = $_POST["download"];

        if($stmt->execute())
        {
            if($stmt->rowCount() == 1)
            {
                if($row = $stmt->fetch())
                {
                    $file_path = "uploads/" . $row["file_name"];
                }
    
                header('Content-Disposition: attachment; filename=' . basename($file_path));
                readfile($file_path);
            }
            
            header("location: users.php");
            exit;
        }
    }

    unset($stmt);
    unset($pdo);
}

?>
<?php

include "is_loggedin.php";

isLoggedin();

require_once "config.php";

$id = $name = $cpf = $birthdate = $address = $phone = $usertype = "";

$sql = "SELECT * FROM users WHERE id = :id";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($stmt = $pdo->prepare($sql))
    {
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

        $param_id = $_POST["info"];

        if($stmt->execute())
        {
            if($stmt->rowCount() == 1)
            {
                if($row = $stmt->fetch())
                {
                    $id = $row["id"];
                    $name = $row["name"];
                    $cpf = $row["cpf"];
                    $birthdate = $row["birthdate"];
                    $address = $row["address"];
                    $phone = $row["phone"];
                    $usertype = $row["usertype"];
                    $task = $row["file_name"];
                    $grade = $row["grade"];
                }
            }
        }

        unset($stmt);
        unset($pdo);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<title>Informações</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

<style type="text/css">
    
    body
    {
        font: 20px sans-serif;
        text-align: left;
        margin-left: 10px;
    }

    .wrapper
    {
        width: 100%;
        padding: 20px;
        margin-bottom: -15px;
        text-align: left;
    }

    .form-group
    {
        padding: 15px;
        margin-top: 10px;
    }

    .info
    {
        border-color: #5BC0DE;
        background-color: white;
        color: deepskyblue;
    }

    .info:hover
    {
        background: #5BC0DE;
        color: white;
    }

</style>

</head>

<body>

<div class="wrapper">
    
    <h2>Informações</h2>
    <br>

</div>

<div class="wrapper">

    <label>ID</label>
    <?php echo "<br>".$id; ?>

</div>

<div class="wrapper">
    
    <label>Nome Completo</label>
    <?php echo "<br>".$name; ?>

</div>

<div class="wrapper">

    <label>CPF</label>
    <?php echo "<br>".$cpf; ?>

</div>

<div class="wrapper">

    <label>Data de Nascimento</label>
    <?php echo "<br>".$birthdate; ?>

</div>

<div class="wrapper">

    <label>Endereço</label>
    <?php echo "<br>".$address; ?>

</div>

<div class="wrapper">

    <label>Telefone</label>
    <?php echo "<br>".$phone; ?>

</div>

<div class="wrapper">

    <label>Usuário</label>
    <?php echo "<br>".$usertype; ?>

</div>

<div class="wrapper">

    <label>Trabalho</label>
    <?php echo "<br>".$task; ?>

</div>

<div class="wrapper">

    <label>Nota</label>
    <?php echo "<br>".$grade; ?>

</div>

<div class="form-group">

    <form action="users.php">

        <button type="submit" class="btn info" value="go_back">Voltar</button>

    </form>

</div>

</body>
</html>

<?php

	function isLoggedin()
	{
		session_start();

		if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
		{
			header("location:login.php");
			exit;
		}
	}

?>
<?php
	
    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        header("location: users.php");
        exit;
    }

    require_once "config.php";

    $name = $cpf = $password = "";
    $cpf_err = $password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty(trim($_POST["cpf"])))
            $cpf_err = "Por favor insira um CPF.";

        else
            $cpf = trim($_POST["cpf"]);

        if(empty(trim($_POST["password"])))
            $password_err = "Por favor insira uma senha.";

        else
            $password = trim($_POST["password"]);

        if(empty($cpf_err) && empty($password_err))
        {
            $sql = "SELECT id, name, cpf, birthdate, address, phone, usertype, password, grade FROM users WHERE cpf = :cpf";

            if($stmt = $pdo->prepare($sql))
            {
                $stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR);

                $param_cpf = trim($_POST["cpf"]);

                if($stmt->execute())
                {
                    if($stmt->rowCount() == 1)
                    {
                        if($row = $stmt->fetch())
                        {
                            $id = $row["id"];
                            $name = $row["name"];
                            $cpf = $row["cpf"];
                            $birthdate = $row["birthdate"];
                            $address = $row["address"];
                            $phone = $row["phone"];
                            $usertype = $row["usertype"];
                            $hashed_password = $row["password"];
                            $grade = $row["grade"];

                            if(password_verify($password, $hashed_password))
                            {
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["name"] = $name;
                                $_SESSION["cpf"] = $cpf;
                                $_SESSION["birthdate"] = $birthdate;
                                $_SESSION["address"] = $address;
                                $_SESSION["phone"] = $phone;
                                $_SESSION["usertype"] = $usertype;
                                $_SESSION["grade"] = $grade;

                                header("location: users.php");
                            }

                            else
                                $password_err = "Senha inválida.";
                        }

                    else
                        $cpf_err = "Usuário não encontrado.";
                    }

                else
                    $cpf_err = "Usuário não encontrado.";

                }
            }

            unset($stmt);
        }

        unset($pdo);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   
   <meta charset="UTF-8">

   <title>Login</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

   <style type="text/css">
       
       body
       {
           font: 14px sans-serif;
       }

       .wrapper
       {
           width:350px; 
           padding: 20px;
       }

   </style>

</head>

<body>
   
   <div class="wrapper">

       <h2>Login</h2>
       <p>Preencha os campos abaixos para fazer  login.</p>

       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           
           <div class="form-group <?php echo (!empty($cpf_err)) ? 'Erro' : '';	?>">

               <label>CPF</label>
               <input type="text" name="cpf" class="form-control" value="<?php echo $cpf; ?>">
               <span class="help-block">
                   <?php echo $cpf_err; ?>	
               </span>

           </div>

           <div class="form-group <?php echo (!empty($password_err)) ? 'Erro' : ''; ?>">

               <label>Senha</label>
               <input type="password" name="password" class="form-control">
               <span class="help-block">
                   <?php echo $password_err; ?>
               </span>

           </div>

           <div class="form-group">
               <input type="submit" class="btn btn-primary" value="Login">	
           </div>

           <p>Não tem uma conta? <a href="register.php">Criar conta</a>.</p>

       </form>

   </div>

</body>
</html>	
<?php

	session_start();

	$_SESSION = array();

	session_destroy();

	header("location: login.php");
	exit;

?>
<?php

include "is_loggedin.php";

isLoggedin();

require_once "config.php";

$ids = array();
$names = array();
$grades = array();
$tasks = array();
$current_id;
$aux = 0;
$error_msg = "";

$sql = "SELECT id, name, grade, file_name FROM users WHERE usertype = :usertype ORDER BY id ASC";

if($stmt = $pdo->prepare($sql))
{
    $stmt->bindParam(":usertype", $param_usertype, PDO::PARAM_STR);

    $param_usertype = "Estudante";

    if($stmt->execute())
    {
        if($stmt->rowCount() > 0)
            while($row = $stmt->fetch())
            {
                $ids[$aux] = $row["id"];
                $names[$aux] = $row["name"];
                $grades[$aux] = $row["grade"];
                $tasks[$aux] = $row["file_name"];
                $aux++;
            }

        else
            $error_msg = "Não há alunos cadastrados.";
    }

    else
        $error_msg = "Algo deu errado. Por favor tente mais tarde.";

    unset($stmt);
    unset($pdo);

}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<title>Professor</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

<style type="text/css">
    
    body
    {
        font: 20px sans-serif;
        text-align: center;
    }

    .wrapper
    {	
        width: 100%;
        padding: 30px;
        text-align: left;
    }

    th, td
    {
        padding: 5px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button
    {
        -webkit-appearance: none;
    }

    input
    {
        width: 65px;
        text-align: center !important;
    }

    table
    {

    }

    .success
    {
        border-color: #4CAF50;
        background-color: white;
        color: green;
    }

    .success:hover
    {
        background-color: #4CAF50;
        color: white;
    }

    .info
    {
        border-color: #2196F3;
        background-color: white;
        color: dodgerblue;
    }

    .info:hover
    {
        background: #2196F3;
        color: white;
    }

    .gray
    {
        border-color: #E7E7E7;
        background-color: white;
        color: black;
    }

    .gray:hover
    {
        background: #E7E7E7;
    }

    .danger
    {
        border-color: #F44336;
        background-color: white;
        color: red;
    }

    .danger:hover
    {
        background: #F44336;
        color: white;
    }

</style>

<script type="text/javascript">
    
    function getInfo(current_id) 
    {
        document.getElementById(current_id).click();
    }

</script>

</head>

<body>

<div class="page-header">

    <h1>Olá, <b><?php echo htmlspecialchars($_SESSION["usertype"])." ". htmlspecialchars($_SESSION["name"]); ?></b>, bem vindo ao site!</h1>

</div>

<div class="wrapper">

    <h1>Lista de Alunos</h1>
    <br>

    <table style='width: 100%;'>
        <tr>
            
            <th>ID</th>
            <th>Nome</th>
            <th>Nota</th>
            <th>Trabalho</th>

        </tr>
    
        <?php

            $button_grade = "<form action='send_grade.php' method='post'><td style='display: inline-block;'><input type='number' min='0' max='100' value='' step='any' name='grade' class='btn info'>";
            
            for ($i = 0; $i < $aux; $i++)
            {
                $current_id = $ids[$i];
                echo "<tr><td style='width: 100px;'>".htmlspecialchars($ids[$i])."</td>";
                echo "<td style='width: 400px;'>".htmlspecialchars($names[$i])."</td>";
                echo "<td style='width: 125px;'>".htmlspecialchars($grades[$i])."</td>";
                echo "<td style='width: 450px;'>".htmlspecialchars($tasks[$i])."</td>";

                echo "<td><form action='info.php' method='post'><input type='submit' id='$current_id' name='info' class='btn info' value='$current_id' style='display: none;'></form></td>";

                echo "<td style='display: inline-block;'><button type='button' name='info' class='btn info' onclick='getInfo($current_id);'>Info</button></td>";

                echo "<td style='display: inline-block;'><form action='download.php' method='post'><button type='submit' name='download' class='btn gray' value='$current_id'>Download</button></form></td>";

                echo $button_grade;

                echo "<td style='display: inline-block;'><button type='submit' name='send_grade' class='btn success' value='$current_id'>Enviar Nota</button></td></form></tr>";							
            }
        ?>

    </table>

</div>

<div class="form-group">

    <a href="logout.php" class="btn danger">Logout</a>

</div>

</body>
</html>
<?php
	
	require_once "config.php";

	include "validate_cpf.php";

	include "validate_date.php";

	$name = $cpf = $birthdate = $address = $phone = $usertype = $password = $confirm_password = "";

	$name_err = $cpf_err = $birthdate_err = $address_err = $phone_err = $usertype_err = $password_err = $confirm_password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["name"])))
			$name_err = "Por favor insira o seu nome.";

		else
			$name = ($_POST["name"]);

		if(empty(trim($_POST["cpf"])) || !(validateCpf($_POST["cpf"])))
			$cpf_err = "CPF inválido.";

		else
		{
			$sql = "SELECT id FROM users WHERE cpf = :cpf";

			if($stmt = $pdo->prepare($sql))
			{
				$stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR);

				$param_cpf = ($_POST["cpf"]);

				if($stmt->execute())
					if($stmt->rowCount() == 1)
						$cpf_err = "CPF já cadastrado.";
					else
						$cpf = trim($_POST["cpf"]);

				else
					echo "Algo deu errado, tente novamente mais tarde.";
			}

			unset($stmt);
			
		}

		if(empty(trim($_POST["birthdate"])) || !(validateDate($_POST["birthdate"])))
			$birthdate_err = "Insira uma data válida.";

		else
			$birthdate = trim(($_POST["birthdate"]));	

		if(empty(trim($_POST["address"])))
			$address_err = "Insira um endereço.";

		else
			$address = (trim($_POST["address"]));

		if(empty(trim($_POST["phone"])) || (strlen($_POST["phone"]) < 10))
			$phone_err = "Insira um número de telefone válido.";

		else
			$phone = trim($_POST["phone"]);

		if(empty(trim($_POST["usertype"])))
			$usertype_err = "Escolha o tipo de usuário.";

		else
			$usertype = trim($_POST["usertype"]);

		if(empty(trim($_POST["password"])))
			$password_err = "Por favor insira uma senha.";

		elseif(strlen(trim($_POST["password"])) < 8)
			$password_err = "A senha tem de conter pelo menos 8 caracteres.";

		else
			$password = trim($_POST["password"]);
		
		if(empty(trim($_POST["confirm_password"])))
			$confirm_password_err = "Por favor confirme a senha.";

		else
		{
			$confirm_password = trim($_POST["confirm_password"]);

			if(empty($password_err) && ($password != $confirm_password))
				$confirm_password_err = "As senhas não são iguais.";
		}

		if(empty($name_err) && empty($password_err) && 
			empty($confirm_password_err) && empty($cpf_err) && empty($birthdate_err) && (empty($address_err)) && (empty($phone_err)) && (empty($usertype_err)))
		{
			$sql = "INSERT INTO users (name, cpf, birthdate, address, phone, usertype, password, file_name, grade) VALUES 
			(:name, :cpf, :birthdate, :address, :phone, :usertype, :password, :file_name, :grade)";

			if($stmt = $pdo->prepare($sql))
			{
				$stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
				$stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR);
				$stmt->bindParam(":birthdate", $param_birthdate, PDO::PARAM_STR);
				$stmt->bindParam(":address", $param_address, PDO::PARAM_STR);
				$stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
				$stmt->bindParam(":usertype", $param_usertype, PDO::PARAM_STR);
				$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
				$stmt->bindParam(":file_name", $param_file_name, PDO::PARAM_STR);
				$stmt->bindParam(":grade", $param_grade, PDO::PARAM_STR);

				$param_name = $name;
				$param_cpf = $cpf;
				$param_birthdate = $birthdate;
				$param_address = $address;
				$param_phone = $phone;
				$param_usertype = $usertype;
				$param_password = password_hash($password, PASSWORD_DEFAULT);

				if($_POST["usertype"] == "Estudante")
				{
					$param_file_name = "Não Enviado";
					$param_grade = "0";
				}

				else
				{
					$param_file_name = "";
					$param_grade = "";
				}

				if($stmt->execute())
					header("location: login.php");

				else
					echo "Algo deu errado, por favor tente mais tarde.";
			}

			unset($stmt);

		}

		unset($pdo);

	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Cadastro</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">

		body
		{
			font: 14px sans-serif;
		}

		.wrapper
		{
			width: 400px; 
			padding: 20px;
		}

	</style>

</head>

<body>
	
	<div class="wrapper">

		<h2>Cadastro</h2>
		<p>Preencha os campos abaixos para criar uma conta.</p>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			<div class="form-group <?php echo (!empty($name_err)) ? 'Erro' : ''; ?>">

				<label>Nome Completo</label>
				<input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
				<span class="help-block">
					<?php echo $name_err; ?>
				</span>

			</div>

			<div class="form-group <?php echo (!empty($cpf_err)) ? 'Erro' : ''; ?>">

				<label>CPF</label>
				<input type="text" name="cpf" class="form-control" value="<?php echo $cpf; ?>">
				<span class="help-block">
					<?php echo $cpf_err; ?>
				</span>

			</div>

			<div class="form-group <?php echo (!empty($birthdate)) ? 'Erro' : ''; ?>">

				<label>Data de Nascimento</label>
				<input type="text" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>">
				<span class="help-block">
					<?php echo $birthdate_err; ?>
				</span>

			<div class="form-group <?php echo (!empty($address_err)) ? 'Erro' : ''; ?>">

				<label>Endereço</label>
				<input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
				<span class="help-block">
					<?php echo $address_err; ?>
				</span>

			</div>

			<div class="form-group <?php echo (!empty($phone_err)) ? 'Erro' : ''; ?>">

				<label>Telefone</label>
				<input type="tel" name="phone" class="form-control" value="<?php echo $phone; ?>">
				<span class="help-block">
					<?php echo $phone_err; ?>
				</span>

			</div>

			<div class="form-group <?php echo (!empty($usertype_err)) ? 'Erro' : ''; ?>">

				<label>Tipo de Usuário</label>
				<br><input type="radio" name="usertype" value="Administrador">Administrador<br>
				<input type="radio" name="usertype" value="Professor">Professor<br>
				<input type="radio" name="usertype" value="Estudante">Estudante<br>
				<input type="radio" name="usertype" value="" style="display: none;" checked>
				<span clas="help-block">
					<?php echo "<br>".$usertype_err; ?>
				</span>

			</div>

			<div class="form-group <?php echo (!empty($password_err)) ? 'Erro' : ''; ?>">

				<label>Senha</label>
				<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
				<span class="help-block">
					<?php echo $password_err; ?>
				</span>

			</div>

			<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'Erro' : ''; ?>">

				<label>Confirme a senha</label>
				<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
				<span class="help-block">
					<?php echo $confirm_password_err; ?>			
				</span>

			</div>

			<div class="form-group">

				<button type="submit" class="btn btn-primary" value="submit">Enviar</button>
				<button type="reset" class="btn btn-default" value="reset">Resetar</button>
				
			</div>

			<p>Já possui uma conta? <a href="login.php"> Logue aqui</a>.</p>

		</form>

	</div>

</body>
</html>

<?php

	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$new_password = $confirm_password = "";
	$new_password_err = $confirm_password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["new_password"])))
			$new_password_err = "Por favor insira sua nova senha.";

		elseif(strlen(trim($_POST["new_password"])) < 8)
			$new_password_err = "A senha deve conter pelo menos 8 caracteres.";

		else
			$new_password = trim($_POST["new_password"]);

		if(empty(trim($_POST["confirm_password"])))
			$confirm_password_err = "Confirme a senha.";

		else
		{
			$confirm_password = trim($_POST["confirm_password"]);

			if(empty($new_password_err) && ($new_password != $confirm_password))
				$confirm_password_err = "As senhas não iguais.";
		}

		if(empty($new_password_err) && empty($confirm_password_err))
		{
			$sql = "UPDATE users SET password = :password WHERE id = :id";

			if($stmt = $pdo->prepare($sql))
			{
				$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
				$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

				$param_id = $_SESSION["id"];
				$param_password = password_hash($new_password, PASSWORD_DEFAULT);
				
				if($stmt->execute())
				{
					session_destroy();
					header("location: login.php");
					exit();
				}

				else
					echo "Algo deu errado! Por favor tente novamente mais tarde.";
			}

			unset($stmt);

		}

		unset($pdo);
	}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Resetar a senha</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 14px sans-serif;
		}

		.wrapper
		{
			width: 350px;
			padding: 20px;
		}

	</style>

</head>

<body>

	<div class="wrapper">

		<h2>Resetar a senha</h2>
		<p>Preencha os campos abaixos para resetar a senha.</p>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			<div class="form-group <?php echo (!empty($new_password_err)) ? 'Erro' : ''; ?>">

				<label>Nova senha</label>
				<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
				<span class="help-block">
					<?php echo $new_password_err; ?>
				</span>	

			</div>	

			<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'Erro' : ''; ?>">

				<label>Confirme a senha</label>
				<input type="password" name="confirm_password" class="form-control">
				<span class="help-block">
					<?php echo $confirm_password_err; ?>
				</span>

			</div>

			<div class="form-group">

				<button type="submit" class="btn btn-primary" value="submit">Enviar</button>
				<a class="btn btn-link" href="users.php">Cancelar</a>	

			</div>

		</form>

	</div>

</body>
</html><?php

	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$new_password = $confirm_password = "";
	$new_password_err = $confirm_password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["new_password"])))
			$new_password_err = "Por favor insira sua nova senha.";

		elseif(strlen(trim($_POST["new_password"])) < 8)
			$new_password_err = "A senha deve conter pelo menos 8 caracteres.";

		else
			$new_password = trim($_POST["new_password"]);

		if(empty(trim($_POST["confirm_password"])))
			$confirm_password_err = "Confirme a senha.";

		else
		{
			$confirm_password = trim($_POST["confirm_password"]);

			if(empty($new_password_err) && ($new_password != $confirm_password))
				$confirm_password_err = "As senhas não iguais.";
		}

		if(empty($new_password_err) && empty($confirm_password_err))
		{
			$sql = "UPDATE users SET password = :password WHERE id = :id";

			if($stmt = $pdo->prepare($sql))
			{
				$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
				$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

				$param_id = $_SESSION["id"];
				$param_password = password_hash($new_password, PASSWORD_DEFAULT);
				
				if($stmt->execute())
				{
					session_destroy();
					header("location: login.php");
					exit();
				}

				else
					echo "Algo deu errado! Por favor tente novamente mais tarde.";
			}

			unset($stmt);

		}

		unset($pdo);
	}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Resetar a senha</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 14px sans-serif;
		}

		.wrapper
		{
			width: 350px;
			padding: 20px;
		}

	</style>

</head>

<body>

	<div class="wrapper">

		<h2>Resetar a senha</h2>
		<p>Preencha os campos abaixos para resetar a senha.</p>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			<div class="form-group <?php echo (!empty($new_password_err)) ? 'Erro' : ''; ?>">

				<label>Nova senha</label>
				<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
				<span class="help-block">
					<?php echo $new_password_err; ?>
				</span>	

			</div>	

			<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'Erro' : ''; ?>">

				<label>Confirme a senha</label>
				<input type="password" name="confirm_password" class="form-control">
				<span class="help-block">
					<?php echo $confirm_password_err; ?>
				</span>

			</div>

			<div class="form-group">

				<button type="submit" class="btn btn-primary" value="submit">Enviar</button>
				<a class="btn btn-link" href="users.php">Cancelar</a>	

			</div>

		</form>

	</div>

</body>
</html>
<?php

	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";

	$new_password = $confirm_password = "";
	$new_password_err = $confirm_password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["new_password"])))
			$new_password_err = "Por favor insira sua nova senha.";

		elseif(strlen(trim($_POST["new_password"])) < 8)
			$new_password_err = "A senha deve conter pelo menos 8 caracteres.";

		else
			$new_password = trim($_POST["new_password"]);

		if(empty(trim($_POST["confirm_password"])))
			$confirm_password_err = "Confirme a senha.";

		else
		{
			$confirm_password = trim($_POST["confirm_password"]);

			if(empty($new_password_err) && ($new_password != $confirm_password))
				$confirm_password_err = "As senhas não iguais.";
		}

		if(empty($new_password_err) && empty($confirm_password_err))
		{
			$sql = "UPDATE users SET password = :password WHERE id = :id";

			if($stmt = $pdo->prepare($sql))
			{
				$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
				$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

				$param_id = $_SESSION["grade"];
				$param_password = password_hash($new_password, PASSWORD_DEFAULT);
				
				if($stmt->execute())
				{
					session_destroy();
					header("location: login.php");
					exit();
				}

				else
					echo "Algo deu errado! Por favor tente novamente mais tarde.";
			}

			unset($stmt);

		}

		unset($pdo);
	}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Resetar a senha</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 14px sans-serif;
		}

		.wrapper
		{
			width: 350px;
			padding: 20px;
		}

	</style>

</head>

<body>

	<div class="wrapper">

		<h2>Resetar a senha</h2>
		<p>Preencha os campos abaixos para resetar a senha.</p>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			<div class="form-group <?php echo (!empty($new_password_err)) ? 'Erro' : ''; ?>">

				<label>Nova senha</label>
				<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
				<span class="help-block">
					<?php echo $new_password_err; ?>
				</span>	

			</div>	

			<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'Erro' : ''; ?>">

				<label>Confirme a senha</label>
				<input type="password" name="confirm_password" class="form-control">
				<span class="help-block">
					<?php echo $confirm_password_err; ?>
				</span>

			</div>

			<div class="form-group">

				<button type="submit" class="btn btn-primary" value="submit">Enviar</button>
				<a class="btn btn-link" href="users.php">Cancelar</a>	

			</div>

		</form>

	</div>

</body>
</html>
<?php

	include "is_loggedin.php";

	isLoggedin();

	require_once "config.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$sql = "UPDATE users SET grade = :grade WHERE id = :id";

		if($stmt = $pdo->prepare($sql))
		{
			$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
			$stmt->bindParam(":grade", $param_grade, PDO::PARAM_STR);

			$param_id = $_POST["send_grade"];
			$param_grade = $_POST["grade"];

			if($stmt->execute())
			{
				header("location: users.php");
				exit;
			}
		}

		unset($stmt);
		unset($pdo);
	}

?>
<?php

include "is_loggedin.php";

isLoggedin();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<title>Aluno</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

<style type="text/css">

    body
    {
        font: 14px sans-serif; 
        text-align: center;
    }

    .success
    {
        border-color: #4CAF50;
        background-color: white;
        color: green;
    }

    .success:hover
    {
        background-color: #4CAF50;
        color: white;
    }

    .primary
    {
        border-color: #337AB7;
        background-color: white;
        color: dodgerblue;
    }

    .primary:hover
    {
        background: #337AB7;
        color: white;
    }

    .info
    {
        border-color: #5BC0DE;
        background-color: white;
        color: deepskyblue;
    }

    .info:hover
    {
        background: #5BC0DE;
        color: white;
    }

    .semi-danger
    {	
        border-color: #FF9800;
        background-color: white;
        color: orange;
    }

    .semi-danger:hover
    {
        background: #FF9800;
        color: white;
    }

    .danger
    {
        border-color: #F44336;
        background-color: white;
        color: red;
    }

    .danger:hover
    {
        background: #F44336;
        color: white;
    }

    .gray
    {
        border-color: #E7E7E7;
        background-color: white;
        color: black;
    }

    .gray:hover
    {
        background: #E7E7E7;
    }

</style>

<script type="text/javascript">
    
    function uploadFile()
    {
        document.getElementById("upload_file").click();
    }

</script>

</head>

<body>

<div class="page-header">
    
    <h1>Olá, <b><?php echo htmlspecialchars($_SESSION["usertype"])." ". htmlspecialchars($_SESSION["name"]); ?></b>, bem vindo ao site!</h1>

</div>

<p>

    <div>
        <h3>Sua nota atual é: <?php echo htmlspecialchars($_SESSION["grade"]); ?></h3>
    </div>

    <div class="form-group">

        <form action="submit_task.php" method="post" enctype="multipart/form-data">

            <input type="file" id="upload_file" name="file_name" style="display: none;">
            <button type="button" name="button" class="btn info" value="upload" onclick="uploadFile();">Upload Trabalho</button>
            <button type="submit" name="submit" class="btn primary" value="submit" >Enviar Trabalho</button>
            

            <a href="change_data.php" class="btn success">Alterar Dados</a>	
            <a href="reset_password.php" class="btn semi-danger">Resetar Senha</a>
            <a href="logout.php" class="btn danger">Logout</a>

        </form>

    </div>
    
</p>

</body>
</html>

<?php 
	
	include "is_loggedin.php";

	isLoggedin();
	
	require_once "config.php";

	$status_msg = "";
	$target_dir = "uploads/";
	$file_name = basename($_FILES["file_name"]["name"]);
	$target_file_path = $target_dir . $file_name;
	$file_type = pathinfo($target_file_path, PATHINFO_EXTENSION);

	if(isset($_POST["submit"]) && (!empty($_FILES["file_name"]["name"])))
	{
		$allowed_types = array('zip', 'rar', 'pdf');

		if(in_array($file_type, $allowed_types))
		{
			if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file_path))
			{
				$sql = "UPDATE users SET file_name = :file_name, grade = :grade WHERE id = :id";

				if($stmt = $pdo->prepare($sql))
				{
					$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
					$stmt->bindParam(":file_name", $param_file_name, PDO::PARAM_STR);
					$stmt->bindParam(":grade", $param_grade, PDO::PARAM_STR);

					$param_id = ($_SESSION["id"]);
					$param_file_name = $file_name;
					$param_grade = 0.0;

					if($stmt->execute())
					{ 
						$_SESSION["grade"] = $param_grade;
						$status_msg = "O arquivo " . $file_name . " foi enviado
					 com sucesso.";
					}

					else
						$status_msg = "Falha ao enviar o arquivo, tente mais tarde novamente.";
				}

				else
					$status_msg = "Houve um erro ao enviar o seu arquivo.";

					unset($stmt);
			}
			else
				$status_msg = "Houve um erro ao enviar o seu arquivo.";
				unset($pdo);
		}

		else
			$status_msg = "Apenas arquivos no formato ZIP, RAR e PDF são permitidos.";
		
	}

	else
		$status_msg = "Por favor selecione um arquivo para enviar.";

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">

	<title>Envio do Trabalho</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

	<style type="text/css">
		
		body
		{
			font: 14px sans-serif;
			text-align: center;
		}

	</style>

</head>

<body>

	<div class="page-header">

		<h1><b><?php echo htmlspecialchars($status_msg); ?></b></h1>

	</div>

	<div class="form-group">

		<a href="student.php" class="btn btn-primary">Voltar</a>

	</div>	

</body>
</html>
<?php

	include "is_loggedin.php";

	isLoggedin();

	if($_SESSION["usertype"] === "Estudante")
 		header("location: student.php");

	elseif($_SESSION["usertype"] === "Professor")
 		header("location: professor.php");

 	elseif($_SESSION["usertype"] === "Administrador")
 		header("location: admin.php");

 	else
 	{
 		echo "Algo deu errado! Tente novamente mais tarde.";
 		header("location: login.php");
	}

?>

<?php

function validateCpf($cpf)
	{
		$cpf = preg_replace('/[^0-9]/is', '', $cpf);

		if(strlen($cpf) != 11)
			return false;

		if(preg_match('/(\d)\1{10}/', $cpf))
			return false;

		for ($i = 9; $i < 11; $i++)
		{
			for($j = 0, $k = 0; $k < $i; $k++)
			{
				$j += $cpf[$k] * (($i + 1) - $k);
			}

			$j = (((10 * $j) % 11) % 10);

			if($cpf[$k] != $j)
				return false;
		}

		return true;
	}

?>
<?php

function validateDate($date)
{
    $day = $date[0] . $date[1];
    $month = $date[3] . $date[4];
    $year = $date[6] . $date[7] . $date[8] . $date[9];

    return checkdate($month, $day, $year);
}

?>
