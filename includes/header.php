<?php

session_start();
ini_set("display_errors", 1);
ini_set("display_startup_errors", 0);
error_reporting(32767);
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];
$isAdmin = $_SESSION['admin'];

$dbans = new SQLite3("./api/.ansdb.db");
$adb = new SQLite3('./api/.adb.db');
$dbans->exec("CREATE TABLE IF NOT EXISTS ibo(id INTEGER PRIMARY KEY NOT NULL,mac_address VARCHAR(100),key VARCHAR(100),username VARCHAR(100),password VARCHAR(100),expire_date VARCHAR(100),dns VARCHAR(100),epg_url VARCHAR(100),title VARCHAR(100),url VARCHAR(100), type VARCHAR(100), id_user INT)");
$dbans->exec("CREATE TABLE IF NOT EXISTS playlist(id INTEGER PRIMARY KEY NOT NULL,mac_address VARCHAR(100),url VARCHAR(100),name VARCHAR(100))");
$dbans->exec("CREATE TABLE IF NOT EXISTS theme(id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL, name VARCHAR(100), url VARCHAR(100))");
$res = $dbans->query("SELECT * FROM theme");
$rows = $dbans->query("SELECT COUNT(*) as count FROM theme");
$row = $rows->fetchArray();
$numRows = $row["count"];
$HOSTa = $lurl = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/img/red.jpg";
$HOSTb = $lurl = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/img/blue.jpg";
$HOSTc = $lurl = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/img/green.jpg";
$HOSTa1 = $lurl = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/img/g1.gif";
$mac_count = $dbans->query("SELECT COUNT(*) as count FROM ibo WHERE id_user = $id");
$mac_count = $mac_count->fetchArray()["count"];

$expired_mac_count = $dbans->query("SELECT COUNT(*) as count FROM ibo WHERE id_user = $id AND (active = 0 OR expire_date < date('today'))");
$expired_mac_count = $expired_mac_count->fetchArray()["count"];

$dbpans = new SQLite3("./api/.anspanel.db");
$resans = $dbpans->query("SELECT * \n\t\t\t\t  FROM USERS \n\t\t\t\t  WHERE ID='1'");
$rowans = $resans->fetchArray();
$nameans = $rowans["NAME"];
$logoans = $rowans["LOGO"];
echo "<!DOCTYPE html>\n<html lang=\"en\">\n\n<head>\n\n";
$jsondata111 = file_get_contents("./includes/ansibo.json");
$json111 = json_decode($jsondata111, true);
$col1 = $json111["info"];
$col2 = $col1["aa"];
$col3 = $col2;
?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="google" content="notranslate">
<script src="https://kit.fontawesome.com/3794d2f89f.js" crossorigin="anonymous"></script>
<title>Ibo 09 Temas Revenda</title>
<link rel="shortcut icon" href="./img2/logo.png?ver=<?= time(); ?>" type="image/png">
<link rel="icon" href="./img2/logo.png?ver=<?= time(); ?>" type="image/png">
<!-- Custom styles for this template-->
<link href="css/sb-admin-<?= $col2 ?>.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css">
<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<style>
    .no-margin {
        margin-top: 0;
        margin-left: 5px;
        margin-bottom: 10px;
        padding: 0;
    }
</style>

</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-header-adm-rev sidebar sidebar-dark accordion" id="accordionSidebar">

<?php if ($logoans != NULL): ?>
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="users.php">
        <div class="sidebar-brand-icon">
            <img class="img-profile rounded-circle" width="65px" src="img2/logo.png?ver=<?= time(); ?>">
        </div>
    </a>
<?php else: ?>
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="users.php">
        <div class="sidebar-brand-icon">
            <img class="img-profile rounded-circle" width="65px" src="img2/logo.png?ver=<?= time(); ?>">
        </div>
    </a>
<?php endif; ?>

<hr class="sidebar-divider my-0">

<!-- Nav Item -->
<span class="text-menu-header">Usuários</span>
<li class="nav-item no-margin">
    <a class="nav-link" href="users.php">
        <i class="fas fa-fw fa-user-plus"></i>
        <span>Meus Clientes (<?= $mac_count ?>)</span>
    </a>
</li>


<?php if ($isAdmin) { ?>
    
    <li class="nav-item no-margin">
        <a class="nav-link" href="all_users.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Clientes Gerais</span></a>
    </li>
    
    <span class="text-menu-header">Área do Revenda</span>
    <li class="nav-item no-margin">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages1" aria-expanded="true" aria-controls="collapsePages1">
            <i class="fas fa-fw fa-search-dollar"></i>
            <span>Revendas</span>
        </a>
        <div id="collapsePages1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Área do Revenda:</h6>
                <a class="collapse-item" href="stores.php"><i class="fas fa-fw fa-infinity"></i><span> Revendas Premium</span></a>
                <a class="collapse-item" href="stores_mac.php"><i class="fas fa-fw fa-hand-holding-usd"></i><span> Revendas MACs</span></a>
            </div>
        </div>
    </li>
    
    <span class="text-menu-header">Design</span>
    <li class="nav-item no-margin">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages3">
            <i class="fa fa-adjust"></i>
            <span>Personalizar</span>
        </a>
        <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Configuração design:</h6>
                <a class="collapse-item" href="layouts.php"><i class="fa fa-hospital-o"></i><span> Temas</span></a>
                <a class="collapse-item" href="logo.php"><i class="fa fa-smile-o"></i><span> Logo</span></a>
                <a class="collapse-item" href="Image.php"><i class="fa fa-picture-o"></i><span> Fundo</span></a>
            </div>
        </div>
    </li>

    
    <span class="text-menu-header">Ajustes</span>
    <li class="nav-item no-margin">
        <a class="nav-link" href="chatbot.php">
            <i class="fas fa-robot"></i>
            <span>ChatBot</span></a>
    </li>
    
    <li class="nav-item no-margin">
        <a class="nav-link" href="autoads.php">
            <i class="fas fa-ad"></i>
            <span>Banners</span></a>
    </li>
    
        <li class="nav-item no-margin">
        <a class="nav-link" href="ads.php">
            <i class="fas fa-bullhorn"></i>
            <span>Banners Manual</span></a>
    </li>
    

    
    <li class="nav-item no-margin">
        <a class="nav-link" href="note.php">
            <i class="fas fa-sms"></i>
            <span>Mensagem</span></a>
            
     </li>
    

    
    <li class="nav-item no-margin">
        <a class="nav-link" href="qrcode.php">
            <i class="fas fa-qrcode"></i>
            <span>QR Code</span></a>
    </li>
    
    <li class="nav-item no-margin">
        <a class="nav-link" href="https://flix-play.com/apks">
            <i class="fas fa-store"></i>
            <span>+ Sscripts Apks</span></a>
    </li>

    <li class="nav-item no-margin">
        <a class="nav-link" href="profile.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Admin</span></a>
    </li>

<?php } ?>
<li class="nav-item no-margin">
    <a class="nav-link" href="logout.php">
        <i class="fas fa-fw fa fa-sign-out"></i>
        <span>Sair</span></a>
</li>

<li class="nav-item2">
    <a class="nav-link2">
    <span>Código do vendedor: <b><?=$id ?></b></span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
<footer class="sticky-footer">
    <div class="copyright text-center">
        <span></a></span> </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light  topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <?php

                    echo "<div><h5 class=\"m-0 text-primary\">" . $nameans . " </br></h5></div>" . "\n";
                    echo "\n          <!-- Topbar Navbar -->\n          <ul class=\"navbar-nav ml-auto\">\n\n\n            <!-- Nav Item - Theme -->\n            <!-- <li class=\"nav-item no-margin dropdown no-arrow mx-1\">\n            </li> -->\n            <div class=\"topbar-divider d-none d-sm-block\"></div>\n\n            <!-- Nav Item - Logout -->\n            <li class=\"nav-item no-margin3 dropdown no-arrow mx-1\">\n              <a class=\"nav-link dropdown-toggle\" href=\"logout.php\"><span class=\"badge badge-danger\">Sair</span>\n                <i class=\"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-red-400\"></i>\n              </a>\n            </li>\n\n          </ul>\n\n        </nav>\n        <!-- End of Topbar -->\n\n";

                    ?>
