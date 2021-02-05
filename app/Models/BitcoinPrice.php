<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

/**
 * Model for Bitcoin Price
 * Class BitcoinPrice
 * @package App\Models
 */
class BitcoinPrice extends Model
{
    /**
     * Function to get BPI data from API
     * @param array $filters
     * @return false|mixed|string
     */
    public static function getBitcoinData($filters = [])
    {
        // Fetch url from environment variable
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
