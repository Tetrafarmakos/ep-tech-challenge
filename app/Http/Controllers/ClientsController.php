<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClientRequest;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }
    public function index()
    {
        $clients = auth()->user()->clients()->withCount('bookings')->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        $filter = request('filter', 'all');

        if (!in_array($filter, ['all', 'future', 'past'])) {
            $filter = 'all';
        }

        $client->load([
            'bookings' => function ($query) use ($filter) {
                $query->timeFilter($filter)
                      ->orderBy('created_at', 'desc');
            }
        ]);

        return view('clients.show', [
            'client' => $client,
            'filter' => $filter,
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        $client = new Client;
        $client->name = $validated['name'];
        $client->email = $validated['email'] ?? null;
        $client->phone = $validated['phone'] ?? null;
        $client->address = $validated['address'] ?? null;
        $client->city = $validated['city'] ?? null;
        $client->postcode = $validated['postcode'] ?? null;
        $client->user_id = auth()->id();
        $client->save();

        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return 'Deleted';
    }
}
