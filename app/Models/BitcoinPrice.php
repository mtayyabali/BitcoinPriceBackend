<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;


class BitcoinPrice extends Model
{
    public static function getBitcoinData($filters = [])
    {
        $apiUrl = env('API_URL');
        try {
            if (!empty($filters)) {
                $response = file_get_contents($apiUrl . '?start=' . $filters['startDate'] . '&end=' . $filters['endDate']);
            } else {
                $response = file_get_contents($apiUrl);
            }
            return $response ? json_decode($response) : false;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
