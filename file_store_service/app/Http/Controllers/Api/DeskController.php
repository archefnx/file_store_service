<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Files;

class DeskController extends Controller
{
    public function index() {
        return Files::all();
    }
}
