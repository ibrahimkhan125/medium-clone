<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService){}
    public function index(Request $request){
        return $this->paymentService->charge(10, 'USD');
    }
}
