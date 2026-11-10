<?php 

require __DIR__ . '/../vendor/autoload.php'; 

use Slim\Factory\AppFactory; 

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$Despesas = [
    ['id' => 1, 'nome' => 'Comida', 'valor' => 10.00, 'data' => '2024-06-01', 'tipo' => 'Despesa'],
    ['id' => 2, 'nome' => 'Lazer', 'valor' => 20.00, 'data' => '2024-06-02', 'tipo' => 'Despesa'],
    ['id' => 3, 'nome' => 'Manutenção', 'valor' => 30.00, 'data' => '2024-06-03', 'tipo' => 'Despesa'],
    ['id' => 4, 'nome' => 'Transporte', 'valor' => 40.00, 'data' => '2024-06-04', 'tipo' => 'Despesa'],
    ['id' => 5, 'nome' => 'Saúde', 'valor' => 50.00, 'data' => '2024-06-05', 'tipo' => 'Despesa'],
    ['id' => 6, 'nome' => 'Educação', 'valor' => 60.00, 'data' => '2024-06-06', 'tipo' => 'Despesa'],
    ['id' => 7, 'nome' => 'Moradia', 'valor' => 70.00, 'data' => '2024-06-07', 'tipo' => 'Despesa'],
    ['id' => 8, 'nome' => 'Vestuário', 'valor' => 80.00, 'data' => '2024-06-08', 'tipo' => 'Despesa'],
    ['id' => 9, 'nome' => 'Impostos', 'valor' => 90.00, 'data' => '2024-06-09', 'tipo' => 'Despesa'],
    ['id' => 10, 'nome' => 'Investimentos', 'valor' => 100.00, 'data' => '2024-06-10', 'tipo' => 'Despesa'],
    ['id' => 11, 'nome' => 'Trabalho', 'valor' => 1700.00, 'data' => '2024-06-11', 'tipo' => 'Receita'],
    ['id' => 12, 'nome' => 'Freelance', 'valor' => 200.00, 'data' => '2024-06-12', 'tipo' => 'Receita'],
    ['id' => 13, 'nome' => 'InvestimentosRetorno', 'valor' => 1200.00, 'data' => '2024-06-13', 'tipo' => 'Receita']
];

$app->get('/status', function ($request, $response) { 
    $response->getBody()->write(json_encode(['status' => 'ok'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/status/xml', function ($request, $response) { 
    $response->getBody()->write("<status>ok</status>"); 
    return $response->withHeader('Content-Type', 'application/xml')->withStatus(200); 
}); 

$app->get('/status/plain', function ($request, $response) { 
    $response->getBody()->write("ok"); 
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200); 
}); 

$app->get('/nome', function ($request, $response) { 
    $response->getBody()->write(json_encode(['nome' => 'Davi Salvador Schubert'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/nome/xml', function ($request, $response) { 
    $response->getBody()->write("<nome>Davi Salvador Schubert</nome>"); 
    return $response->withHeader('Content-Type', 'application/xml')->withStatus(200); 
}); 

$app->get('/nome/plain', function ($request, $response) { 
    $response->getBody()->write("Davi Salvador Schubert"); 
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200); 
}); 

$app->get('/categorias', function ($request, $response) { 
    $response->getBody()->write(json_encode(['categorias' => ['Comida', 'Lazer', 'Manutenção', 'Transporte', 'Saúde', 'Educação', 'Moradia', 'Vestuário', 'Impostos', 'Investimentos']])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categorias/xml', function ($request, $response) { 
    $response->getBody()->write("<categorias><categoria>Comida</categoria><categoria>Lazer</categoria><categoria>Manutenção</categoria><categoria>Transporte</categoria><categoria>Saúde</categoria><categoria>Educação</categoria><categoria>Moradia</categoria><categoria>Vestuário</categoria><categoria>Impostos</categoria><categoria>Investimentos</categoria></categorias>"); 
    return $response->withHeader('Content-Type', 'application/xml')->withStatus(200); 
}); 

$app->get('/categorias/plain', function ($request, $response) { 
    $response->getBody()->write("Comida, Lazer, Manutenção, Transporte, Saúde, Educação, Moradia, Vestuário, Impostos, Investimentos"); 
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200); 
});

$app->get('/categoria/Comida', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Comida' => '[id: 1, nome: Comida, valor: 10.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Lazer', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Lazer' => '[id: 2, nome: Lazer, valor: 20.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Manutenção', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Manutenção' => '[id: 3, nome: Manutenção, valor: 30.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Transporte', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Transporte' => '[id: 4, nome: Transporte, valor: 40.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Saúde', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Saúde' => '[id: 5, nome: Saúde, valor: 50.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Educação', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Educação' => '[id: 6, nome: Educação, valor: 60.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Moradia', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Moradia' => '[id: 7, nome: Moradia, valor: 70.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Vestuário', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Vestuário' => '[id: 8, nome: Vestuário, valor: 80.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Impostos', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Impostos' => '[id: 9, nome: Impostos, valor: 90.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/Investimentos', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Investimentos' => '[id: 10, nome: Investimentos, valor: 100.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/categoria/InvestimentosRetorno', function ($request, $response) { 
    $response->getBody()->write(json_encode(['InvestimentosRetorno' => '[id: 13, nome: InvestimentosRetorno, valor: 1200.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 


$app->get('/categoria/Trabalho', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Trabalho' => '[id: 11, nome: Trabalho, valor: 1000.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
});  

$app->get('/categoria/Freelance', function ($request, $response) { 
    $response->getBody()->write(json_encode(['Freelance' => '[id: 12, nome: Freelance, valor: 1100.00]'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/musica', function ($request, $response) { 
    $response->getBody()->write(json_encode(['musica' => 'No Surprise - RadioHead'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/musica/xml', function ($request, $response) { 
    $response->getBody()->write("<musica>No Surprise - RadioHead</musica>"); 
    return $response->withHeader('Content-Type', 'application/xml')->withStatus(200); 
}); 

$app->get('/musica/plain', function ($request, $response) { 
    $response->getBody()->write("No Surprise - RadioHead"); 
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200); 
}); 

$app->get('/filme', function ($request, $response) { 
    $response->getBody()->write(json_encode(['filme' => 'Guardioes da Galaxia Vol.1'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/filme/xml', function ($request, $response) { 
    $response->getBody()->write("<filme>Guardioes da Galaxia Vol.1</filme>"); 
    return $response->withHeader('Content-Type', 'application/xml')->withStatus(200); 
}); 

$app->get('/filme/plain', function ($request, $response) { 
    $response->getBody()->write("Guardioes da Galaxia Vol.1"); 
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200); 
}); 

$app->get('/tic', function ($request, $response) { 
    $response->getBody()->write(json_encode(['tic' => 'Toc'])); 
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
}); 

$app->get('/tic/xml', function ($request, $response) { 
    $response->getBody()->write("<tic>Toc</tic>"); 
    return $response->withHeader('Content-Type', 'application/xml')->withStatus(200); 
}); 

$app->get('/tic/plain', function ($request, $response) { 
    $response->getBody()->write("Toc"); 
    return $response->withHeader('Content-Type', 'text/plain')->withStatus(200); 
});


/* ================================
   AULA 8 - GET COM PARÂMETRO
================================ */

$app->get('/Despesas/{id}', function ($request, $response, $args) use (&$Despesas) {

    $id = (int) $args['id'];

    $despesa = current(
        array_filter($Despesas, fn($d) => $d['id'] === $id)
    ) ?: null;

    if (!$despesa) {

        $response->getBody()->write(
            json_encode(['erro' => 'Despesa não encontrada'])
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
    }

    $response->getBody()->write(
        json_encode($despesa)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


/* ================================
   AULA 8 - POST EM JSON
================================ */

$app->post('/Despesas', function ($request, $response) use (&$Despesas) {

    $dados = $request->getParsedBody();

    if (!isset($dados['nome']) || empty($dados['nome'])) {

        $response->getBody()->write(
            json_encode(['erro' => 'O nome é obrigatório'])
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(400);
    }

    $novoProduto = [
        'id' => $Despesas === [] ? 1 : max(array_column($Despesas, 'id')) + 1,
        'nome' => $dados['nome'],
        'preco' => $dados['preco'] ?? 0
    ];

    $Despesas[] = $novoProduto;

    $response->getBody()->write(
        json_encode($novoProduto)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
});

$app->delete('/Despesas/{id}', function ($request, $response, $args) use (&$Despesas) {
    $id = (int) $args['id'];

    foreach ($Despesas as $indice => $despesa) {
        if ($despesa['id'] === $id) {
            array_splice($Despesas, $indice, 1);

            $response->getBody()->write(
                json_encode(['mensagem' => 'Despesa removida com sucesso'])
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $response->getBody()->write(
        json_encode(['erro' => 'Despesa não encontrada'])
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

$app->put('/Despesas/{id}', function ($request, $response, $args) use (&$Despesas) {
    $id = (int) $args['id'];

    foreach ($Despesas as &$despesa) {
        if ($despesa['id'] === $id) {
            $dados = $request->getParsedBody();

            if (!isset($dados['nome']) || empty($dados['nome'])) {
                $response->getBody()->write(
                    json_encode(['erro' => 'O nome é obrigatório'])
                );

                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            $despesa['nome'] = $dados['nome'];
            unset($despesa);

            $response->getBody()->write(
                json_encode(['mensagem' => 'Despesa atualizada com sucesso'])
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }
    unset($despesa);

    $response->getBody()->write(
        json_encode(['erro' => 'Despesa não encontrada'])
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

return $app;
