<?php

namespace Alura\Leilao\Test\Integration\Dao;

use Alura\Leilao\Model\Leilao;
use PHPUnit\Framework\TestCase;
use Alura\Leilao\Dao\Leilao as DaoLeilao;
use Alura\Leilao\Infra\ConnectionCreator;

class LeilaoDaoTest extends TestCase
{
    public function testInsercaoEBuscaDevemFuncionar()
    {
        // Arrange
        $leilao = new Leilao('Variante 0KM');
        $pdo = ConnectionCreator::getConnection();
        $leilaoDao = new DaoLeilao($pdo);
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

        // tear down
        $pdo->exec('DELETE FROM leiloes WHERE TRUE;');
    }
}
