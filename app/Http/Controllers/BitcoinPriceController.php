<?php

namespace App\Http\Controllers;

use App\Models\BitcoinPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Main Class for getting BPI
 * Class BitcoinPriceController
 * @package App\Http\Controllers
 */
class BitcoinPriceController extends BaseController
{
    /**
     * Controller for getting BPI
     * @param Request $request
     * @return array|string
     */
    public function getBPI(Request $request)
    {
        try {

            // Validation of params
            $validator = Validator::make($request->all(), [
                'startDate' => 'required|date|date_format:Y-m-d',
                'endDate' => 'required|date|after:startDate|date_format:Y-m-d|before_or_equal:now'
            ]);

            // Check if validation fail
            if ($validator->fails()) {
                return ['success' => false, 'message' => $validator->errors()];
            }

            // Set Filters
            $filters = [];
            $filters['startDate'] = $request->input('startDate');
            $filters['endDate'] = $request->input('endDate');

            // Get Data from Model
            $response = BitcoinPrice::getBitcoinData($filters);

            // Return response
            if ($response) {
                return ['success' => true, 'data' => (array)$response->bpi];
            }
            return ['success' => false, 'message' => 'Data fetch error'];
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
