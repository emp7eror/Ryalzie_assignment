<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{




    public function index(Request $request)
    {
        // return $request->all();
        $request->validate([
            'limit' => 'nullable|int',
            'page' => 'nullable|int',
            'name' => 'nullable|string',
            'id' => 'nullable|int'

        ]);


        $limit = $request->limit ? $request->limit : 10;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;
        $clients = Client::when($request->has('name'), function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->name . '%');
        })->when($request->has('id'), function ($query) use ($request) {

            $query->where('id',  $request->id);
        })->paginate($limit);

        return response()->json([
            'status' => true,
            'message' => 'Clients retrieve Successfully',
            'clients' => $clients
        ], 200);
    }


    public function show($id)
    {
        $clients = Client::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Clients retrieve Successfully',
            'clients' => $clients
        ], 200);
    }
}
