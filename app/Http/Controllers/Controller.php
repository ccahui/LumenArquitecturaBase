<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $pageSize = 20;

     /*Override */
     protected function buildFailedValidationResponse(Request $request, array $errors)
     {
         return response($errors, 400);
     }
    
}

