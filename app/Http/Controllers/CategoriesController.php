<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $nome = 'Rogerio';
        $linguagens = ['php', 'java', 'python'];

        return view('admin.categories.index', compact('nome', 'linguagens'));
    }
}
