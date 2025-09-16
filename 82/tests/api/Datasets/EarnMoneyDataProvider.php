<?php

namespace TestsApi\Datasets;

class EarnMoneyDataProvider implements DataProvider
{
    public static function get(): array
    {
        // $data = $this->getData();

        return [
            'Василий' => ['Василий', [20000, 4400], 24400],
            'Михаил' => ['Михаил', [15000, 0], 15000],
            'Алексей' => ['Алексей', [15000, 3300, 50000, 13000], 81300],
        ];
    }

    // private static function getData(): array
    // {
    //     //logic work with data
    // }
}
