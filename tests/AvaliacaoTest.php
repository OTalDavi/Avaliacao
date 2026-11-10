<?php
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class AvaliacaoTest extends TestCase
{
    private function requisicao($metodo, $caminho, $dados = null) {
        $app = require __DIR__ . '/../src/app.php';
        $request = (new ServerRequestFactory())->createServerRequest($metodo, $caminho);
        if ($dados !== null) {
            $request = $request->withHeader('Content-Type', 'application/json');
            $request->getBody()->write(json_encode($dados));
            $request->getBody()->rewind();
        }
        return $app->handle($request);
    }

    public function testStatus(): void {
        $r = $this->requisicao('GET', '/status');
        $this->assertSame(200, $r->getStatusCode());
    }
    public function testListarCategorias(): void {
        $r = $this->requisicao('GET', '/categorias');
        $this->assertSame(200, $r->getStatusCode());
        $this->assertNotEmpty(json_decode((string)$r->getBody(), true)['categorias']);
    }
    public function testCategoriaNaoEncontrada(): void {
        $this->assertSame(404, $this->requisicao('GET', '/categorias/999')->getStatusCode());
    }
    public function testCriarCategoria(): void {
        $r = $this->requisicao('POST', '/categorias', ['nome'=>'Pets','tipo'=>'despesa']);
        $this->assertSame(201, $r->getStatusCode());
    }
    public function testCategoriaDuplicada(): void {
        $r = $this->requisicao('POST', '/categorias', ['nome'=>'Comida','tipo'=>'despesa']);
        $this->assertSame(409, $r->getStatusCode());
    }
    public function testListarLancamentos(): void {
        $this->assertSame(200, $this->requisicao('GET', '/lancamentos')->getStatusCode());
    }
    public function testCriarLancamento(): void {
        $r = $this->requisicao('POST', '/lancamentos', ['descricao'=>'Conta de luz','valor'=>120,'data'=>'2024-06-20','tipo'=>'despesa','categoria_id'=>7]);
        $this->assertSame(201, $r->getStatusCode());
    }
    public function testValorInvalido(): void {
        $r = $this->requisicao('POST', '/lancamentos', ['descricao'=>'Teste','valor'=>0,'data'=>'2024-06-20','tipo'=>'despesa','categoria_id'=>1]);
        $this->assertSame(400, $r->getStatusCode());
    }
    public function testCategoriaIncompativel(): void {
        $r = $this->requisicao('POST', '/lancamentos', ['descricao'=>'Teste','valor'=>10,'data'=>'2024-06-20','tipo'=>'receita','categoria_id'=>1]);
        $this->assertSame(400, $r->getStatusCode());
    }
    public function testResumoSaldo(): void {
        $r = $this->requisicao('GET', '/resumo/saldo');
        $this->assertSame(200, $r->getStatusCode());
        $this->assertArrayHasKey('saldo', json_decode((string)$r->getBody(), true));
    }
    public function testResumoPeriodo(): void {
        $r = $this->requisicao('GET', '/resumo/periodo?data_inicio=2024-06-01&data_fim=2024-06-30');
        $this->assertSame(200, $r->getStatusCode());
    }
    public function testPeriodoInvalido(): void {
        $r = $this->requisicao('GET', '/resumo/periodo?data_inicio=2024-06-30&data_fim=2024-06-01');
        $this->assertSame(400, $r->getStatusCode());
    }
}
