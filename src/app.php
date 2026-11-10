<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$Categorias = [
    ['id' => 1, 'nome' => 'Comida', 'tipo' => 'despesa'],
    ['id' => 2, 'nome' => 'Lazer', 'tipo' => 'despesa'],
    ['id' => 3, 'nome' => 'Manutenção', 'tipo' => 'despesa'],
    ['id' => 4, 'nome' => 'Transporte', 'tipo' => 'despesa'],
    ['id' => 5, 'nome' => 'Saúde', 'tipo' => 'despesa'],
    ['id' => 6, 'nome' => 'Educação', 'tipo' => 'despesa'],
    ['id' => 7, 'nome' => 'Moradia', 'tipo' => 'despesa'],
    ['id' => 8, 'nome' => 'Vestuário', 'tipo' => 'despesa'],
    ['id' => 9, 'nome' => 'Impostos', 'tipo' => 'despesa'],
    ['id' => 10, 'nome' => 'Investimentos', 'tipo' => 'despesa'],
    ['id' => 11, 'nome' => 'Trabalho', 'tipo' => 'receita'],
    ['id' => 12, 'nome' => 'Freelance', 'tipo' => 'receita'],
    ['id' => 13, 'nome' => 'InvestimentosRetorno', 'tipo' => 'receita']
];

$Lancamentos = [
    ['id' => 1, 'descricao' => 'Comida', 'valor' => 10.00, 'data' => '2024-06-01', 'tipo' => 'despesa', 'categoria_id' => 1],
    ['id' => 2, 'descricao' => 'Lazer', 'valor' => 20.00, 'data' => '2024-06-02', 'tipo' => 'despesa', 'categoria_id' => 2],
    ['id' => 3, 'descricao' => 'Manutenção', 'valor' => 30.00, 'data' => '2024-06-03', 'tipo' => 'despesa', 'categoria_id' => 3],
    ['id' => 4, 'descricao' => 'Transporte', 'valor' => 40.00, 'data' => '2024-06-04', 'tipo' => 'despesa', 'categoria_id' => 4],
    ['id' => 5, 'descricao' => 'Saúde', 'valor' => 50.00, 'data' => '2024-06-05', 'tipo' => 'despesa', 'categoria_id' => 5],
    ['id' => 6, 'descricao' => 'Educação', 'valor' => 60.00, 'data' => '2024-06-06', 'tipo' => 'despesa', 'categoria_id' => 6],
    ['id' => 7, 'descricao' => 'Moradia', 'valor' => 70.00, 'data' => '2024-06-07', 'tipo' => 'despesa', 'categoria_id' => 7],
    ['id' => 8, 'descricao' => 'Vestuário', 'valor' => 80.00, 'data' => '2024-06-08', 'tipo' => 'despesa', 'categoria_id' => 8],
    ['id' => 9, 'descricao' => 'Impostos', 'valor' => 90.00, 'data' => '2024-06-09', 'tipo' => 'despesa', 'categoria_id' => 9],
    ['id' => 10, 'descricao' => 'Investimentos', 'valor' => 100.00, 'data' => '2024-06-10', 'tipo' => 'despesa', 'categoria_id' => 10],
    ['id' => 11, 'descricao' => 'Trabalho', 'valor' => 1700.00, 'data' => '2024-06-11', 'tipo' => 'receita', 'categoria_id' => 11],
    ['id' => 12, 'descricao' => 'Freelance', 'valor' => 200.00, 'data' => '2024-06-12', 'tipo' => 'receita', 'categoria_id' => 12],
    ['id' => 13, 'descricao' => 'Retorno de investimentos', 'valor' => 1200.00, 'data' => '2024-06-13', 'tipo' => 'receita', 'categoria_id' => 13]
];

$app->get('/status', function ($request, $response) {
    $response->getBody()->write(json_encode(['status' => 'ok']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});
$app->get('/nome', function ($request, $response) {
    $response->getBody()->write(json_encode(['nome' => 'Davi Salvador Schubert']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});
$app->get('/musica', function ($request, $response) {
    $response->getBody()->write(json_encode(['musica' => 'No Surprise - Radiohead']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});
$app->get('/filme', function ($request, $response) {
    $response->getBody()->write(json_encode(['filme' => 'Guardioes da Galaxia Vol.1']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});
$app->get('/tic', function ($request, $response) {
    $response->getBody()->write(json_encode(['tic' => 'Toc']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->get('/categorias', function ($request, $response) use (&$Categorias) {
    $response->getBody()->write(json_encode(['categorias' => $Categorias], JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->get('/categorias/{id}', function ($request, $response, $args) use (&$Categorias) {
    $id = (int) $args['id'];
    foreach ($Categorias as $categoria) {
        if ($categoria['id'] === $id) {
            $response->getBody()->write(json_encode($categoria, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    $response->getBody()->write(json_encode(['erro' => 'Categoria não encontrada']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->post('/categorias', function ($request, $response) use (&$Categorias) {
    $dados = (array) $request->getParsedBody();
    $nome = trim($dados['nome'] ?? '');
    $tipo = strtolower(trim($dados['tipo'] ?? ''));

    if ($nome === '' || !in_array($tipo, ['receita', 'despesa'])) {
        $response->getBody()->write(json_encode(['erro' => 'Informe nome e tipo (receita ou despesa).']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    foreach ($Categorias as $categoria) {
        if (strtolower($categoria['nome']) === strtolower($nome)) {
            $response->getBody()->write(json_encode(['erro' => 'Já existe uma categoria com esse nome.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
        }
    }
    $novoId = empty($Categorias) ? 1 : max(array_column($Categorias, 'id')) + 1;
    $novaCategoria = ['id' => $novoId, 'nome' => $nome, 'tipo' => $tipo];
    $Categorias[] = $novaCategoria;
    $response->getBody()->write(json_encode($novaCategoria, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->put('/categorias/{id}', function ($request, $response, $args) use (&$Categorias, &$Lancamentos) {
    $id = (int) $args['id'];
    $dados = (array) $request->getParsedBody();
    $nome = trim($dados['nome'] ?? '');
    $tipo = strtolower(trim($dados['tipo'] ?? ''));

    if ($nome === '' || !in_array($tipo, ['receita', 'despesa'])) {
        $response->getBody()->write(json_encode(['erro' => 'Informe nome e tipo (receita ou despesa).']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    foreach ($Categorias as $indice => $categoria) {
        if ($categoria['id'] === $id) {
            foreach ($Categorias as $outra) {
                if ($outra['id'] !== $id && strtolower($outra['nome']) === strtolower($nome)) {
                    $response->getBody()->write(json_encode(['erro' => 'Já existe uma categoria com esse nome.']));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
                }
            }
            foreach ($Lancamentos as $lancamento) {
                if ($lancamento['categoria_id'] === $id && $lancamento['tipo'] !== $tipo) {
                    $response->getBody()->write(json_encode(['erro' => 'Não é possível mudar o tipo: existem lançamentos vinculados.']));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
                }
            }
            $Categorias[$indice] = ['id' => $id, 'nome' => $nome, 'tipo' => $tipo];
            $response->getBody()->write(json_encode($Categorias[$indice], JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    $response->getBody()->write(json_encode(['erro' => 'Categoria não encontrada']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->delete('/categorias/{id}', function ($request, $response, $args) use (&$Categorias, &$Lancamentos) {
    $id = (int) $args['id'];
    foreach ($Categorias as $indice => $categoria) {
        if ($categoria['id'] === $id) {
            foreach ($Lancamentos as $lancamento) {
                if ($lancamento['categoria_id'] === $id) {
                    $response->getBody()->write(json_encode(['erro' => 'Categoria possui lançamentos vinculados.']));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
                }
            }
            array_splice($Categorias, $indice, 1);
            $response->getBody()->write(json_encode(['mensagem' => 'Categoria removida com sucesso.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    $response->getBody()->write(json_encode(['erro' => 'Categoria não encontrada']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->get('/lancamentos', function ($request, $response) use (&$Lancamentos) {
    $resultado = $Lancamentos;
    $filtros = $request->getQueryParams();

    if (isset($filtros['data_inicio'])) {
        $resultado = array_filter($resultado, fn($l) => $l['data'] >= $filtros['data_inicio']);
    }
    if (isset($filtros['data_fim'])) {
        $resultado = array_filter($resultado, fn($l) => $l['data'] <= $filtros['data_fim']);
    }
    if (isset($filtros['categoria_id'])) {
        $resultado = array_filter($resultado, fn($l) => $l['categoria_id'] === (int) $filtros['categoria_id']);
    }
    if (isset($filtros['tipo'])) {
        $resultado = array_filter($resultado, fn($l) => $l['tipo'] === strtolower($filtros['tipo']));
    }

    $response->getBody()->write(json_encode(['lancamentos' => array_values($resultado)], JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->get('/lancamentos/{id}', function ($request, $response, $args) use (&$Lancamentos) {
    $id = (int) $args['id'];
    foreach ($Lancamentos as $lancamento) {
        if ($lancamento['id'] === $id) {
            $response->getBody()->write(json_encode($lancamento, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    $response->getBody()->write(json_encode(['erro' => 'Lançamento não encontrado']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->post('/lancamentos', function ($request, $response) use (&$Lancamentos, &$Categorias) {
    $dados = (array) $request->getParsedBody();
    $descricao = trim($dados['descricao'] ?? '');
    $valor = $dados['valor'] ?? null;
    $data = $dados['data'] ?? '';
    $tipo = strtolower(trim($dados['tipo'] ?? ''));
    $categoriaId = filter_var($dados['categoria_id'] ?? null, FILTER_VALIDATE_INT);

    $dataObj = DateTime::createFromFormat('!Y-m-d', $data);
    if ($descricao === '' || !is_numeric($valor) || (float)$valor <= 0 ||
        !$dataObj || $dataObj->format('Y-m-d') !== $data ||
        !in_array($tipo, ['receita', 'despesa']) || $categoriaId === false || $categoriaId === null) {
        $response->getBody()->write(json_encode(['erro' => 'Dados inválidos. Confira descrição, valor maior que zero, data, tipo e categoria.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $categoriaEncontrada = null;
    foreach ($Categorias as $categoria) {
        if ($categoria['id'] === $categoriaId) $categoriaEncontrada = $categoria;
    }
    if (!$categoriaEncontrada || $categoriaEncontrada['tipo'] !== $tipo) {
        $response->getBody()->write(json_encode(['erro' => 'Categoria inexistente ou incompatível com o tipo do lançamento.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $novoId = empty($Lancamentos) ? 1 : max(array_column($Lancamentos, 'id')) + 1;
    $novoLancamento = ['id' => $novoId, 'descricao' => $descricao, 'valor' => (float)$valor, 'data' => $data, 'tipo' => $tipo, 'categoria_id' => $categoriaId];
    $Lancamentos[] = $novoLancamento;
    $response->getBody()->write(json_encode($novoLancamento, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->put('/lancamentos/{id}', function ($request, $response, $args) use (&$Lancamentos, &$Categorias) {
    $id = (int) $args['id'];
    $dados = (array) $request->getParsedBody();
    foreach ($Lancamentos as $indice => $lancamento) {
        if ($lancamento['id'] === $id) {
            $atualizado = array_merge($lancamento, $dados);
            $atualizado['descricao'] = trim($atualizado['descricao'] ?? '');
            $atualizado['tipo'] = strtolower(trim($atualizado['tipo'] ?? ''));
            $atualizado['valor'] = $atualizado['valor'] ?? null;
            $atualizado['data'] = $atualizado['data'] ?? '';
            $atualizado['categoria_id'] = filter_var($atualizado['categoria_id'] ?? null, FILTER_VALIDATE_INT);
            $dataObj = DateTime::createFromFormat('!Y-m-d', $atualizado['data']);

            if ($atualizado['descricao'] === '' || !is_numeric($atualizado['valor']) || (float)$atualizado['valor'] <= 0 ||
                !$dataObj || $dataObj->format('Y-m-d') !== $atualizado['data'] ||
                !in_array($atualizado['tipo'], ['receita', 'despesa']) || $atualizado['categoria_id'] === false || $atualizado['categoria_id'] === null) {
                $response->getBody()->write(json_encode(['erro' => 'Dados inválidos para atualizar o lançamento.']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
            $categoriaEncontrada = null;
            foreach ($Categorias as $categoria) {
                if ($categoria['id'] === $atualizado['categoria_id']) $categoriaEncontrada = $categoria;
            }
            if (!$categoriaEncontrada || $categoriaEncontrada['tipo'] !== $atualizado['tipo']) {
                $response->getBody()->write(json_encode(['erro' => 'Categoria inexistente ou incompatível com o tipo do lançamento.']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
            $Lancamentos[$indice] = $atualizado;
            $response->getBody()->write(json_encode($atualizado, JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    $response->getBody()->write(json_encode(['erro' => 'Lançamento não encontrado']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->delete('/lancamentos/{id}', function ($request, $response, $args) use (&$Lancamentos) {
    $id = (int) $args['id'];
    foreach ($Lancamentos as $indice => $lancamento) {
        if ($lancamento['id'] === $id) {
            array_splice($Lancamentos, $indice, 1);
            $response->getBody()->write(json_encode(['mensagem' => 'Lançamento removido com sucesso.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    $response->getBody()->write(json_encode(['erro' => 'Lançamento não encontrado']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->get('/resumo/saldo', function ($request, $response) use (&$Lancamentos) {
    $receitas = 0;
    $despesas = 0;
    foreach ($Lancamentos as $lancamento) {
        if ($lancamento['tipo'] === 'receita') $receitas += $lancamento['valor'];
        else $despesas += $lancamento['valor'];
    }
    $response->getBody()->write(json_encode(['total_receitas' => round($receitas, 2), 'total_despesas' => round($despesas, 2), 'saldo' => round($receitas - $despesas, 2)]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->get('/resumo/periodo', function ($request, $response) use (&$Lancamentos) {
    $filtros = $request->getQueryParams();
    $inicio = $filtros['data_inicio'] ?? '';
    $fim = $filtros['data_fim'] ?? '';
    $dataInicio = DateTime::createFromFormat('!Y-m-d', $inicio);
    $dataFim = DateTime::createFromFormat('!Y-m-d', $fim);

    if (!$dataInicio || !$dataFim || $dataInicio->format('Y-m-d') !== $inicio || $dataFim->format('Y-m-d') !== $fim || $inicio > $fim) {
        $response->getBody()->write(json_encode(['erro' => 'Informe data_inicio e data_fim válidas (AAAA-MM-DD).']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $receitas = 0;
    $despesas = 0;
    foreach ($Lancamentos as $lancamento) {
        if ($lancamento['data'] >= $inicio && $lancamento['data'] <= $fim) {
            if ($lancamento['tipo'] === 'receita') $receitas += $lancamento['valor'];
            else $despesas += $lancamento['valor'];
        }
    }
    $response->getBody()->write(json_encode(['data_inicio' => $inicio, 'data_fim' => $fim, 'total_receitas' => round($receitas, 2), 'total_despesas' => round($despesas, 2), 'saldo' => round($receitas - $despesas, 2)]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

return $app;





















































































































































































































































































































































































