<?php

namespace AppUnitTests;

use App\FreelanceMoneyCollector;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;


final class FreelanceMoneyCollectorTest extends TestCase
{

    // public static function setUpBeforeClass(): void
    // {
    //     // поведение перед запуском всех тестов
    // }
    // protected function setUp(): void
    // {
    //     // поведение перед запуском каждого теста
    // }
    // protected function tearDown(): void
    // {
    //     // поведение после каждого теста
    // }
    // public static function tearDownAfterClass(): void
    // {
    //     поведение после всех тестов
    // }

    public function testEarnMoney(): void
    {
        $collector = new FreelanceMoneyCollector('Александр');
        $collector->earnMoney(11000);
        $result = $collector->withdrawMoney();
        //  static::assertSame('Александр заработал 11000 руб. на фрилансе.', $result);

        static::assertSame('Александр заработал 11000 руб. на фрилансе.', $result, 'Александр должен вывести столько же денег, сколько заработал.');
    }


    public function testEarnTooMuchMoney(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/^Роман/'); // old expectExceptionMessageRegExp()
        $collector = new FreelanceMoneyCollector('Роман');
        $collector->earnMoney(1000001);
        $result = $collector->withdrawMoney();
    }

    public function testWithoutAssert(): void
    {
        $collector = new FreelanceMoneyCollector('Вася');
        $result = $collector->withdrawMoney();
    }



    public function testEarnMoneyManyTime()
    {
        static::markTestIncomplete('Недоделанный тест');
        $collector = new FreelanceMoneyCollector('Федор');
        $collector->earnMoney(5111);
        $collector->earnMoney(3625);
        $collector->earnMoney(1234);

        $result = $collector->withdrawMoney();

        static::assertSame('Александр заработал ??? руб. на фрилансе.', $result);
    }

    public function testEarnMoneyWithRandomAmount()
    {
        static::markTestSkipped('Странная ошибка');
        $collector = new FreelanceMoneyCollector('Андрей');
        $collectedAmount = random_int(500000, 2000000);
        $collector->earnMoney($collectedAmount);
        $result = $collector->withdrawMoney();
        static::assertSame("Андрей заработал $collectedAmount руб. на фрилансе.", $result);
    }


    #[testWith(["Василий", 20000])]
    #[testWith(["Михаил", 15000])]
    #[testWith(["Алексей", 77000])]
    public function testEarnMoneyWithArrays(string $name, int $collectedAmount): void
    {
        $collector = new FreelanceMoneyCollector($name);
        $collector->earnMoney($collectedAmount);
        $result = $collector->withdrawMoney();
        static::assertSame("$name заработал $collectedAmount руб. на фрилансе.", $result);
    }

    #[dataProvider('someDataProvider')]
    public function testEarnMoneyWithDataProvider(string $name, array $collected, int $expectedCollectedAmount)
    {
        $collector = new FreelanceMoneyCollector($name);
        foreach ($collected as $item) {
            $collector->earnMoney($item);
        }
        $result = $collector->withdrawMoney();
        static::assertSame("$name заработал $expectedCollectedAmount руб. на фрилансе.", $result);
    }

    public static function someDataProvider()
    {
        return [
            'Василий' => ['Василий', [20000, 4400], 24400],
            'Михаил' => ['Михаил', [15000, 0], 15000],
            'Алексей' => ['Алексей', [15000, 3300, 50000, 13000], 81300],
        ];
    }
}
