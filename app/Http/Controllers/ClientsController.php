<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientsController extends Controller
{
    public function residentiels()
    {
        $clients = Client::where('type', 'residentiel')->get(); // ou filtrer autrement
        return view('clients.residentiels', compact('clients'));
    }

    public function affaires()
    {
        $clients = Client::where('type', 'affaires')->get();
        return view('clients.affaires', compact('clients'));
    }
}
