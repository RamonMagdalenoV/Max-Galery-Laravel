<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderRequest;
use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        return $providers;
    }

    public function StoreProvider(ProviderRequest $request)
    {
        Provider::create($request->all());
    }

    public function UpdateProvider(ProviderRequest $request)
    {
        $provider = Provider::find($request->id);
        $provider->update($request->all());
    }

    public function DeleteProvider($id)
    {
        $provider = Provider::find($id);
        $provider->delete();
    }
}
