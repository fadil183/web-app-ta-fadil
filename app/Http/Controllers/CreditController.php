<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;


class CreditController extends Controller
{
    //
    public function index():View
    {
        return view('credit.index');
    }
}
