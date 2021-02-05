<?php

namespace App\Http\Controllers;

use App\Models\BitcoinPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class BitcoinPriceController extends BaseController
{
    public function getBPI(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'startDate' => 'required|date|date_format:Y-m-d',
                'endDate' => 'required|date|after:startDate|date_format:Y-m-d|before_or_equal:now'
            ]);
            if ($validator->fails()) {
                return ['success' => false, 'message' => $validator->errors()];
            }
            $filters = [];
            if ($request->has('startDate')) {
                $filters['startDate'] = $request->input('startDate');
            }
            if ($request->has('endDate')) {
                $filters['endDate'] = $request->input('endDate');
            }
            $response = BitcoinPrice::getBitcoinData($filters);
            if ($response) {
                return ['success' => true, 'data' => (array) $response->bpi];
            }
            return ['success' => false, 'message' => 'Data fetch error'];
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
