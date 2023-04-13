<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    //
    public function author(): JsonResponse
    {
        return response()->json([
            'nama' => 'Dandi Lesmana',
            'nim' => '21416255201018',
            'kelas' => 'IF21E'
        ]);
    }
}
