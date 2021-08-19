<?php

namespace Alura\Leilao\Test\Integration\Dao;

use Alura\Leilao\Model\Leilao;
use PHPUnit\Framework\TestCase;
use Alura\Leilao\Dao\Leilao as DaoLeilao;
use Alura\Leilao\Infra\ConnectionCreator;
use PDO;

class LeilaoDaoTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = ConnectionCreator::getConnection();
        $this->pdo->beginTransaction();
    }
    public function testInsercaoEBuscaDevemFuncionar()
    {
        // Arrange
        $leilao = new Leilao('Variante 0KM');
        $leilaoDao = new DaoLeilao($this->pdo);
        $leilaoDao->salva($leilao);

        // act
        $leiloes = $leilaoDao->recuperarNaoFinalizados();

        // assert 
        self::assertCount(1, $leiloes);
        self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
        self::assertSame(
            'Variante 0KM',
            $leiloes[0]->recuperarDescricao()
        );
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack();
    }
}
