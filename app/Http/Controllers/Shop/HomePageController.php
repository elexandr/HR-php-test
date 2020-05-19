<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;


class HomePageController extends BaseController
{
    public function index()
    {
        $temp = $this->getWeather();

        return view('shop.index', compact('temp'));
    }

    /** Метод получения погоды
     * @return mixed
     */
    public function getWeather ()
    {
        $coordinates = $this->getCoordinates(); //Берем координаты нужного населенного пункта

        $url = 'https://api.weather.yandex.ru/v1/forecast?extra=true&'.$coordinates; //Формируем нужный url

        $client = new \GuzzleHttp\Client();

        $response =  $client->request('GET', $url, [
            'headers' => ['X-Yandex-API-Key' => env('API_WEATHER_KEY'),]
        ]);

        $contents = $response->getBody()->getContents(); //json body
        $result = json_decode($contents, true); //array
        $temp = ($result['fact']['temp']);

        return $temp;
    }

    /** В структуре предусматриваем возможность дальнейшего масштабирования, логичным будет картирование по городам,
     * пока же просто возвращаем строку с координатами
     * @return string
     */
    public function getCoordinates()
    {
        return 'lat=53.2521&lon=34.3717'; //координаты Брянска
    }

}
