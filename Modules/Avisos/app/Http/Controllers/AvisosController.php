<?php

namespace Modules\Avisos\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avisos = \Modules\Avisos\App\Models\Aviso::ativos()
            ->orderBy('destacar', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('avisos::index', compact('avisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('avisos::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('avisos::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('avisos::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
