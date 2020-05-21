<?php

namespace App\Http\Controllers\Shop;

class HomePageController extends BaseController
{
    /** Отображаем главную страницу с температурой в Брянске     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

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
        // Проверка на ниличие API Key Яндекса
        if(!env('API_WEATHER_KEY')){return '';};

        //Берем координаты нужного населенного пункта
        $coordinates = $this->getCoordinates();

        //Формируем нужный url
        $url = 'https://api.weather.yandex.ru/v1/forecast?extra=true&'.$coordinates;

        $client = new \GuzzleHttp\Client();

        $response =  $client->request('GET', $url, [
            'headers' => ['X-Yandex-API-Key' => env('API_WEATHER_KEY'),]
        ]);

        $contents = $response->getBody()->getContents(); //json body
        $result = json_decode($contents, true); //array
        $temp = ($result['fact']['temp']); // температура

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
