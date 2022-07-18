<?php

namespace Database\Seeders;

use App\Models\CollectionDetail;
use App\Models\CollectionLang;
use App\Models\MCollection;
use Database\Factories\CollectionFactory;
use Faker\Core\Number;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //・試験データ件数：　５万件
        $factory = new CollectionFactory();

        for ($i = 0; $i < 1; $i ++) {
            $record = $factory->definition();
            $details = $record['details'];
            unset($record['details']);

            // 収蔵品の登録
            $collectionId = (new MCollection($record))->save();

            foreach ($details as $lang => $detailInfo) {
                // 収蔵品詳細を登録 (JSON)
                $collectionLangRecord = [
                    'collection_id' => $collectionId,
                    'lang_code' => $lang,
                    'collection_title' => $this->_randomTitle($lang, $collectionId),
                    'collection_title_kana' => $this->_randomTitle($lang, $collectionId, true),
                    'common_items' => json_encode(array_slice($detailInfo, 0, 5, true)),
                    'custom_items' => json_encode(array_slice($detailInfo, 5, null, true)),
                ];
                (new CollectionLang($collectionLangRecord))->save();

                // 収蔵品詳細を登録 (DB)
                foreach ($detailInfo as $itemId => $itemValue) {
                    $detailRecord = new CollectionDetail();
                    $detailRecord->fill([
                        'collection_id' => $collectionId,
                        'lang_code' => $lang,
                        'item_id' => $itemId,
                        'item_value' => $itemValue,
                    ])->save();
                }
            }
        }

    }

    private function _randomTitle($lang, $cId, $isKana = false)
    {
        switch ($lang) {
            case 1:
                return ($isKana ? 'ニホンゴ・' : '日本語') . 'タイトル: ' . $cId;
            case 2:
                return 'English title: ' . $cId;
            case 4:
                return '中文标题: ' . $cId;
            case 5:
                return '타이틀: ' . $cId;
        }
        return '';
    }

}
