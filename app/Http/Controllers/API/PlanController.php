<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ApiResponseHelpers;
    public function index()
    {
        return $this->respondWithSuccess(PlanResource::collection(Plan::all()));
    }
}
