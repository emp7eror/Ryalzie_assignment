<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index')->with('clients', $clients);
    }
    public function ajax()
    {
        $clients = Client::all();
        return view('clients.index')->with('clients', $clients);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Client::create($input);
        return redirect('clients')->with('flash_message', 'Client Addedd!');
    }

    public function show($id)
    {
        $clients = Client::find($id);
        return view('clients.show')->with('clients', $clients);
    }

    public function edit($id)
    {
        $clients = Client::find($id);
        return view('clients.edit')->with('clients', $clients);
    }

    public function update(Request $request, $id)
    {
        $clients = Client::find($id);
        $input = $request->all();
        $clients->update($input);
        return redirect('clients')->with('flash_message', 'Client Updated!');
    }

    public function destroy($id)
    {
        Client::destroy($id);
        return redirect('clients')->with('flash_message', 'Client deleted!');
    }
}
