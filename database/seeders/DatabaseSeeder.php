<?php

namespace Database\Seeders;

use App\Models\CollectionDetail;
use App\Models\CollectionLang;
use App\Models\MCollection;
use Database\Factories\CollectionFactory;
use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $count = 30000;

        $startTime = time();
        echo 'Start: ' . date('Y-m-d H:i:s');
        for ($i = 0; $i < $count; $i ++) {
            $record = $factory->definition();
            $details = $record['details'];
            unset($record['details']);

            // 収蔵品の登録
            $collection = new MCollection($record);
            $collection->save();
            $collectionId = $collection->collection_id;

            foreach ($details as $lang => $detailInfo) {
                // 収蔵品詳細を登録 (JSON)
                $collectionLangRecord = [
                    'collection_id' => $collectionId,
                    'lang_code' => $lang,
                    'collection_title' => $this->_randomTitle($lang, $collectionId),
                    'collection_title_kana' => $this->_randomTitle($lang, $collectionId, true),
                    'common_items' => array_slice($detailInfo, 0, 5, true),
                    'custom_items' => array_slice($detailInfo, 5, null, true),
                ];
                (new CollectionLang($collectionLangRecord))->save();

                // 収蔵品詳細を登録 (DB)
                $detailRecords = [];
                foreach ($detailInfo as $itemId => $itemValue) {
                    $detailRecords[] = [
                        'collection_id' => $collectionId,
                        'lang_code' => $lang,
                        'item_id' => $itemId,
                        'item_value' => (is_array($itemValue) ? implode(',', $itemValue) : $itemValue),
                    ];
                }
                DB::table('collection_details')->insert($detailRecords);
            }

            echo '.';
            if (($i + 1) % 100 == 0) {
                echo '  --- ' . ($i+1) . ' / ' . $count
                    . ' (' . number_format((($i+1) / $count)*100, 1) . ' %)  :  '
                    . (time()-$startTime) . " s\n";
            }
        }

        echo 'End: ' . date('Y-m-d H:i:s') . '  ---  ' . (time()-$startTime) . " seconds\n";

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
