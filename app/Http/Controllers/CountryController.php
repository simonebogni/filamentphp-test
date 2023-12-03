<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CountryController extends Controller
{
    public function index(Request $request): View
    {
        $countries = Country::all();

        return view('country.index', compact('countries'));
    }

    public function create(Request $request): View
    {
        return view('country.create');
    }

    public function store(CountryStoreRequest $request): RedirectResponse
    {
        $country = Country::create($request->validated());

        $request->session()->flash('country.id', $country->id);

        return redirect()->route('country.index');
    }

    public function show(Request $request, Country $country): View
    {
        return view('country.show', compact('country'));
    }

    public function edit(Request $request, Country $country): View
    {
        return view('country.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, Country $country): RedirectResponse
    {
        $country->update($request->validated());

        $request->session()->flash('country.id', $country->id);

        return redirect()->route('country.index');
    }

    public function destroy(Request $request, Country $country): RedirectResponse
    {
        $country->delete();

        return redirect()->route('country.index');
    }
}
