<?php 
// Importa a aplicação Slim configurada em src/app.php.
$app = require __DIR__ . '/../src/app.php';

// Inicia o servidor da API e escuta requisições HTTP.
$app->run();
