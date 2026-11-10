
<?php
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
class AvaliacaoTest extends TestCase
{
public function testPostCriaProduto(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('POST', '/Despesas')
->withHeader('Content-Type', 'application/json');
$request->getBody()->write(json_encode(['nome' => 'Comida', 'valor' => 10.00, 'data' => '2024-06-01']));
$request->getBody()->rewind();
$response = $app->handle($request);
$this->assertEquals(201, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('Comida', $corpo['nome']);
$this->assertEquals(10.00, $corpo['valor']);
$this->assertEquals('2024-06-01', $corpo['data']);
}





public function testPostCriaProdutoComErro(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('POST', '/Despesas')
->withHeader('Content-Type', 'application/json');
$request->getBody()->write(json_encode([]));
$request->getBody()->rewind();
$response = $app->handle($request);
$this->assertEquals(400, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('O nome é obrigatório', $corpo['erro']);
}


public function testGetProdutoPorId(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('GET', '/Despesas/1')
->withHeader('Content-Type', 'application/json');
$response = $app->handle($request);
$this->assertEquals(200, $response->getStatusCode());
// $corpo = json_decode((string) $response->getBody(), true);
// $this->assertEquals('O nome é obrigatório', $corpo['erro']);
}


public function testGetProdutoPorIdInexistente(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('GET', '/Despesas/999')
->withHeader('Content-Type', 'application/json');
$response = $app->handle($request);
$this->assertEquals(404, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('Despesa não encontrada', $corpo['erro']);
}



public function testDeleteProdutoPorId(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('DELETE', '/Despesas/1')
->withHeader('Content-Type', 'application/json');
$response = $app->handle($request);
$this->assertEquals(200, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('Despesa removida com sucesso', $corpo['mensagem']);
}


public function testDeleteProdutoPorIdInexistente(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('DELETE', '/Despesas/999')
->withHeader('Content-Type', 'application/json');
$response = $app->handle($request);
$this->assertEquals(404, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('Despesa não encontrada', $corpo['erro']);
}


public function testPutProdutoPorId(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('PUT', '/Despesas/1')
->withHeader('Content-Type', 'application/json');
$request->getBody()->write(json_encode(['nome' => 'Despesa atualizada']));
$request->getBody()->rewind();
$response = $app->handle($request);
$this->assertEquals(200, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('Despesa atualizada com sucesso', $corpo['mensagem']);
$requestAtualizado = (new ServerRequestFactory())
->createServerRequest('GET', '/Despesas/1');
$responseAtualizado = $app->handle($requestAtualizado);
$despesaAtualizada = json_decode((string) $responseAtualizado->getBody(), true);
$this->assertEquals('Despesa atualizada', $despesaAtualizada['nome']);
}


public function testputProdutoPorIdinexistente(): void
{
$app = require __DIR__ . '/../src/app.php'; // retorna $app sem chamar ->run()
$request = (new ServerRequestFactory())
->createServerRequest('PUT', '/Despesas/999')
->withHeader('Content-Type', 'application/json');
$request->getBody()->write(json_encode(['nome' => 'Despeja Atualizada']));
$request->getBody()->rewind();
$response = $app->handle($request);
$this->assertEquals(404, $response->getStatusCode());
$corpo = json_decode((string) $response->getBody(), true);
$this->assertEquals('Despesa não encontrada', $corpo['erro']);
}
}