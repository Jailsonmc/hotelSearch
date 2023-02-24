<?php

namespace Hotels\xlr8\Service;

use Hotels\xlr8\Util\UtilConstants;
use Psr\Container\ContainerInterface;

class HotelService
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getNearbyHotelsService($latitude, $longitude, $order)
    {

        $urls = UtilConstants::urls;

        $mh = curl_multi_init();
        $handles = array();

        foreach ($urls as $url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_multi_add_handle($mh, $ch);
            $handles[$url] = $ch;
        }
        $running = null;

        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        // buscar conteúdo de todas as URLs usando curl_multi
        $messages = array_map(function ($ch) {
            $content = curl_multi_getcontent($ch);
            return json_decode($content);
        }, $handles);

        // filtrar apenas as mensagens bem-sucedidas
        $successfulMessages = array_reduce($messages, function ($accumulator, $value) {
            if ($value->success) {
                $accumulator = array_merge($accumulator, $value->message);
            }
            return $accumulator;
        }, []);

        // remover todos os handles
        array_map(function ($ch) use ($mh) {
            curl_multi_remove_handle($mh, $ch);
        }, $handles);

        $response = array();
        foreach ($successfulMessages as $message) {
            $response[] = [ $message[0], round($this->haversineDistance($latitude, $longitude, $message[1], $message[2]), 1), $message[3] ];
        }

        $this->order($response, $order);

        $response = $this->mountResponse($response);

        curl_multi_close($mh);
        return $response;
    }

    private function mountResponse($responses){

        return array_map(function($item) {
            return "$item[0], $item[1] KM, $item[2] EUR";
        }, $responses);

    }

    private function order(&$list, $order) {

        usort($list, function ($a, $b) use ($order) {
            return $a[$order] - $b[$order];
        });

    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        // Raio médio da Terra em km
        $R = 6371;

        // Converter graus para radianos
        $lat1 = deg2rad((float) $lat1);
        $lon1 = deg2rad((float) $lon1);
        $lat2 = deg2rad((float) $lat2);
        $lon2 = deg2rad((float) $lon2);

        // Diferença de latitude e longitude
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        // Fórmula Haversine
        $a = sin($dLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dLon / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        // Distância em km
        $distance = $R * $c;

        return $distance;
    }
}
