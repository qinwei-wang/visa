<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 2019/5/5
 * Time: 14:41
 */



namespace App\Console\Commands;

use Illuminate\Console\Command;
//use GuzzleHttp\Client;
use Storage;
use App\Models\CountryModel;

class GetCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取全球国家信息';


    protected $uri = 'https://restcountries.eu/rest/v2/';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contents = Storage::get('countries.json');
        $countries = json_decode($contents, true);
        foreach ($countries as $item) {
            try {
                $rescord = [
                    'name' => $item['name'],
                    'flag' => $item['flag'],
                    'region' => $item['region']
                ];
                CountryModel::updateOrCreate(['name' => $rescord['name']], $rescord);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                \Log::error($e->getMessage());
                \Log::error($e->getTrace());
            }

        }

    }



    public function getCoutries()
    {
//        $client = new Client([
//            'base_uri' => $this->uri,
//            'timeout'  => 2.0,
//        ]);
//        try {
//            $response = $client->request('GET', 'all');
//            if (!empty($response)) {
//                $countries = json_decode($response, true);
//                foreach ($countries as $country) {
//
//                }
//            }
//
//        } catch (\Exception $e) {
//
//        }
    }


}
