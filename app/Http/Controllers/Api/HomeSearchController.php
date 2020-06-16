<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeSearchController extends Controller
{
    public function getInputFields(Request $request)
    {
        $form_data = $request->all(); // Request object
        return response()->json($form_data);
    }
}
