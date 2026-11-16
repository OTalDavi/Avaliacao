<?php
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

// Classe de testes automatizados para validar o comportamento da API.
class AvaliacaoTest extends TestCase
{
    // Cria uma requisição HTTP simulada para testar cada rota da API.
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

    // Verifica se o endpoint de status responde corretamente.
    public function testStatus(): void {
        $r = $this->requisicao('GET', '/status');
        $this->assertSame(200, $r->getStatusCode());
    }

    // Confirma que a listagem de categorias retorna sucesso e dados preenchidos.
    public function testListarCategorias(): void {
        $r = $this->requisicao('GET', '/categorias');
        $this->assertSame(200, $r->getStatusCode());
        $this->assertNotEmpty(json_decode((string)$r->getBody(), true)['categorias']);
    }

    // Testa o erro 404 quando a categoria não existe.
    public function testCategoriaNaoEncontrada(): void {
        $this->assertSame(404, $this->requisicao('GET', '/categorias/999')->getStatusCode());
    }

    // Verifica a criação de uma nova categoria.
    public function testCriarCategoria(): void {
        $r = $this->requisicao('POST', '/categorias', ['nome'=>'Pets','tipo'=>'despesa']);
        $this->assertSame(201, $r->getStatusCode());
    }

    // Garante que categorias duplicadas não sejam cadastradas.
    public function testCategoriaDuplicada(): void {
        $r = $this->requisicao('POST', '/categorias', ['nome'=>'Comida','tipo'=>'despesa']);
        $this->assertSame(409, $r->getStatusCode());
    }

    // Confirma que a listagem de lançamentos funciona.
    public function testListarLancamentos(): void {
        $this->assertSame(200, $this->requisicao('GET', '/lancamentos')->getStatusCode());
    }

    // Testa a criação de um lançamento com valores válidos.
    public function testCriarLancamento(): void {
        $r = $this->requisicao('POST', '/lancamentos', ['descricao'=>'Conta de luz','valor'=>120,'data'=>'2024-06-20','tipo'=>'despesa','categoria_id'=>7]);
        $this->assertSame(201, $r->getStatusCode());
    }

    // Valida que valores iguais a zero são rejeitados.
    public function testValorInvalido(): void {
        $r = $this->requisicao('POST', '/lancamentos', ['descricao'=>'Teste','valor'=>0,'data'=>'2024-06-20','tipo'=>'despesa','categoria_id'=>1]);
        $this->assertSame(400, $r->getStatusCode());
    }

    // Verifica erro quando o tipo do lançamento não combina com a categoria.
    public function testCategoriaIncompativel(): void {
        $r = $this->requisicao('POST', '/lancamentos', ['descricao'=>'Teste','valor'=>10,'data'=>'2024-06-20','tipo'=>'receita','categoria_id'=>1]);
        $this->assertSame(400, $r->getStatusCode());
    }

    // Testa o endpoint de resumo de saldo geral.
    public function testResumoSaldo(): void {
        $r = $this->requisicao('GET', '/resumo/saldo');
        $this->assertSame(200, $r->getStatusCode());
        $this->assertArrayHasKey('saldo', json_decode((string)$r->getBody(), true));
    }

    // Verifica o resumo financeiro em um intervalo de datas válido.
    public function testResumoPeriodo(): void {
        $r = $this->requisicao('GET', '/resumo/periodo?data_inicio=2024-06-01&data_fim=2024-06-30');
        $this->assertSame(200, $r->getStatusCode());
    }

    // Garante que o período inválido retorna erro 400.
    public function testPeriodoInvalido(): void {
        $r = $this->requisicao('GET', '/resumo/periodo?data_inicio=2024-06-30&data_fim=2024-06-01');
        $this->assertSame(400, $r->getStatusCode());
    }
}
