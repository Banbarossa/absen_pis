<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    public function getAllRombel(Request $request)
    {

        $data = Rombel::all();
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function getRombel($id)
    {
        $data = Rombel::find($id);
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);

    }
}
