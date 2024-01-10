<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billet;

class billetController extends Controller
{
    //
    public function index()
    {
        $billets = Billet::all();

        // return to billet index
        return view('billet.index', compact('billets'));
    }

    public function dashboard()
    {
        $billets = Billet::all();

        return view('dashboard', compact('billets'));
    }

    public function create()
    {
        return view('billet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_billet' => 'required',
            'diameter' => 'required',
            'status' => 'required',
            'total_defected' => 'required',
            'date' => 'required',
        ]);

        Billet::create($request->all());

        return redirect()->route('billet.index')
            ->with('success', 'Billet created successfully.');
    }

    // edit using id
    public function edit($id)
    {
        $billet = Billet::findOrFail($id);

        return view('billet.edit', compact('billet'));
    } 

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'total_billet' => 'required',
            'diameter' => 'required',
            'status' => 'required',
            'total_defected' => 'required',
        ]);

        $billet = Billet::findOrFail($id);
        $billet->update($request->all());

        return redirect()->route('billet.index')
            ->with('success', 'Billet updated successfully.');
    }
    // delete 
    public function destroy($id)
    {
        $billet = Billet::findOrFail($id);
        $billet->delete();

        return redirect()->route('billet.index')
            ->with('success', 'Billet deleted successfully.');
    }
}
