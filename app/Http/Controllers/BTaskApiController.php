<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BTaskApiController extends Controller
{
    public function getApiData()
    {
        $data = [
            [
                "name" => "田中 太郎",
                "age" => 10,
                "city" => "東京",
                "hobbies" => ["読書", "プログラミング", "旅行"]
            ],
            [
                "name" => "田中 次郎",
                "age" => 12,
                "city" => "石川",
                "hobbies" => ["読書", "プログラミング", "旅行"]
            ]
        ];      

        return response()->json($data);
    }
}
