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
        $leilao = new Leilao('Variante 0KM');
        $leilaoDao = new DaoLeilao(ConnectionCreator::getConnection());

        $leilaoDao->salva($leilao);
        $leiloes = $leilaoDao->recuperarNaoFinalizados();

        self::assertCount(1, $leiloes);
        self::assertContainsOnlyInstancesOf(Leilao::class, $leiloes);
        self::assertSame(
            'Viariante 0Km',
            $leiloes[0]->recuperarDescricao()
        );
    }
}
