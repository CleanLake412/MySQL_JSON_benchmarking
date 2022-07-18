<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CollectionFactory extends Factory
{
    /**
     * 多言語対応：　４つの言語
     * @var int[]
     */
    protected array $_langIds = [1, 2, 4, 5];

    /**
     * 共通５項目
     * @var array[]
     */
    protected array $_commonItems = [
        1 => [
            'name' => 'id',
            'required' => true,
            'type' => 'input',
            'values' => [],
            'multi' => false,
        ],
        2 => [
            'name' => 'data_num',
            'required' => true,
            'type' => 'input',
            'values' => [],
            'multi' => false,
        ],
        3 => [
            'name' => 'classification',
            'required' => true,
            'type' => 'select',
            'values' => [1,2,3,4,5,6,7,8,9,10],
            'multi' => false,
        ],
        4 => [
            'name' => 'group',
            'required' => true,
            'type' => 'select',
            'values' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
            'multi' => true,
        ],
        5 => [
            'name' => 'facility',
            'required' => true,
            'type' => 'select',
            'values' => [1,2,3],
            'multi' => false,
        ],
    ];

    /**
     * カテゴリ別フィールド１０項目を想定
     * @var array[]
     */
    protected array $_customItems = [
        11 => [
            'name' => 'title',
            'required' => true,
            'type' => 'input',
            'values' => [],
            'multi' => false,
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //・多言語対応：　４つの言語
        //・収蔵品の項目数：　共通５項目、カテゴリ別フィールド１０項目を想定

        // 収蔵品情報
        $record = [
            'collection_genre_id' => $this->faker->numberBetween(1, 8),
            'main_image_id' => (rand()%3 == 0 ? 0 : $this->faker->numberBetween(1, 99999)),
            'is_public' => 1,
            'details' => [],
        ];
        $details = [];

        // 共通項目
        shuffle($this->_commonItems[3]['values']);
        shuffle($this->_commonItems[4]['values']);
        shuffle($this->_commonItems[5]['values']);
        $commonFields = [
            1 => $this->faker->numerify('######'),
            2 => 'K' . $this->faker->numerify('####') . strtoupper(Str::random(2)),
            3 => $this->_commonItems[3]['values'][0],
            4 => implode(',', array_splice($this->_commonItems[4]['values'], 0, rand(1,5))),
            5 => implode(',', array_splice($this->_commonItems[5]['values'], 0, rand(1,2))),
        ];
        foreach ($this->_langIds as $langId) {
            $details[$langId] = $commonFields;
        }

        // カスタム項目
        foreach ($this->_langIds as $langId) {
            $details[$langId] = array_merge($details[$langId], [
                11 => $this->faker->title(),
                12 => $this->faker->address(),
                13 => $this->faker->name(),
                14 => $this->faker->url(),
                15 => $this->faker->company(),
                16 => $this->faker->companyEmail(),
                17 => $this->faker->city(),
                18 => $this->faker->colorName(),
                19 => $this->faker->date(),
                20 => $this->faker->text()
            ]);
        }

        // 返却
        $record['details'] = $details;
        return $record;
    }

}
