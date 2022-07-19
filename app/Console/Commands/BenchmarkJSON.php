<?php

namespace App\Console\Commands;

use App\Models\CollectionDetail;
use App\Models\CollectionLang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BenchmarkJSON extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benchmark:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start to benchmark JSON fields');

        //$records = CollectionDetail::where('collection_id', 1)->get();
        //print_r($records->toArray());

        //$records = CollectionLang::where('collection_id', 1)->get();
        $startTime = microtime(true);
        $count = CollectionLang::whereBetween('common_items->1', [300000, 600000])
            ->where('common_items->2', 'like', '%00%')
            //->where('common_items->3', 1)
            //->whereJsonContains('common_items->4', [2])
            //->whereJsonLength('common_items->5', '>', 0)
            //->groupBy('collection_id')
            //->select('collection_id', DB::raw('count(*) AS cnt'))
            ->select(DB::raw('count(distinct collection_id) AS cnt'))
            ->get();
        $this->info($count[0]->cnt . ' collections : ' . number_format(microtime(true)-$startTime, 3) . ' seconds');

        $startTime = microtime(true);
        $count = CollectionDetail::where('item_id', 2)
            //->whereBetween('item_value', [300000, 600000])
            ->where('item_value', 'like', '%00%')
            ->select(DB::raw('count(distinct collection_id) AS cnt'))
            ->get();
        $this->info($count[0]->cnt . ' collections : ' . number_format(microtime(true)-$startTime, 3) . ' seconds');

        return 0;
    }
}
