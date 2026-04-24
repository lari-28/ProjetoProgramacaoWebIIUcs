<?php
include_once "fachada.php";

$login = @$_GET["login"];
$senha = @$_GET["senha"];
$nome = @$_GET["nome"];
$interno = isset($_GET["interno"]) ? true : false;

$login = trim((string)$login);
$senha = trim((string)$senha);
$nome = trim((string)$nome);
$interno = (bool)$interno;

$dao = $factory->getUsuarioDao();

if ($login === "" || $senha === "" || $nome === "" || $interno === "") {
    header("Location: novo_usuario.php?erro=campos_obrigatorios");
    exit;
}

if ($dao->buscaPorLogin($login) !== null) {
    header("Location: novo_usuario.php?erro=login_duplicado");
    exit;
}

$usuario = new Usuario(null,$login,$senha,$nome,$interno);
$ok = $dao->insere($usuario);

if(!$ok){
    header("Location: novo_usuario.php?erro=erro_insercao");
    exit;
}

header("Location: usuarios.php");
exit;

?>
