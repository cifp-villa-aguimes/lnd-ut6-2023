<?php
include './config/env.php';
include './helpers/db_connection.php';
include './public_html/header.php';
?>

<h3>Configuración del Sistema</h3>
<ul>
   <li>Host: <?php echo $_SERVER['HTTP_HOST']; ?></li>
   <li>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
   <li>System Root: <?php echo $_SERVER['SystemRoot']; ?></li>
   <li>Server Name: <?php echo $_SERVER['SERVER_NAME']; ?></li>
   <li>Server Port: <?php echo $_SERVER['SERVER_PORT']; ?></li>
   <li>Current File Dir: <?php echo $_SERVER['PHP_SELF']; ?></li>
   <li>Request URI: <?php echo $_SERVER['REQUEST_URI']; ?></li>
   <li>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
   <li>Client Info: <?php echo $_SERVER['HTTP_USER_AGENT']; ?></li>
   <li>Remote Address: <?php echo $_SERVER['REMOTE_ADDR']; ?></li>
   <li>Remote Port: <?php echo $_SERVER['REMOTE_PORT']; ?></li>
   <li>DB Host: <?php echo DB_HOST; ?></li>
   <li>DB User: <?php echo DB_USER; ?></li>
   <li>DB Pass: <?php echo DB_PASS; ?></li>
   <li>DB Name: <?php echo DB_NAME; ?></li>
</ul>

<?php include './public_html/footer.php'; ?>