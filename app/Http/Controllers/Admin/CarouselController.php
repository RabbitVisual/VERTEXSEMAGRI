<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = CarouselSlide::ordered()->get();
        $isEnabled = \App\Models\SystemConfig::get('carousel_enabled', true);

        return view('admin.carousel.index', compact('slides', 'isEnabled'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable', // Aceita HTML formatado do Quill
            'description' => 'nullable', // Aceita HTML formatado do Quill
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'show_image' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('carousel', 'public');
        }

        $validated['order'] = $validated['order'] ?? CarouselSlide::max('order') + 1;
        $validated['is_active'] = $request->has('is_active');
        $validated['show_image'] = $request->has('show_image');

        CarouselSlide::create($validated);

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide do carousel criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarouselSlide $carousel)
    {
        return view('admin.carousel.show', compact('carousel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarouselSlide $carousel)
    {
        return view('admin.carousel.edit', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarouselSlide $carousel)
    {
        $validated = $request->validate([
            'title' => 'nullable', // Aceita HTML formatado do Quill
            'description' => 'nullable', // Aceita HTML formatado do Quill
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'show_image' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Deletar imagem antiga
            if ($carousel->image) {
                Storage::disk('public')->delete($carousel->image);
            }
            $validated['image'] = $request->file('image')->store('carousel', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['show_image'] = $request->has('show_image');

        $carousel->update($validated);

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide do carousel atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarouselSlide $carousel)
    {
        if ($carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->delete();

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide do carousel removido com sucesso!');
    }

    /**
     * Toggle carousel enabled/disabled
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        $enabled = (bool) $request->input('enabled');

        \App\Models\SystemConfig::set(
            'carousel_enabled',
            $enabled,
            'boolean',
            'carousel',
            'Habilita ou desabilita o carousel na homepage'
        );

        return response()->json([
            'success' => true,
            'enabled' => $enabled,
            'message' => $enabled ? 'Carousel ativado com sucesso!' : 'Carousel desativado com sucesso!'
        ]);
    }

    /**
     * Reorder slides
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'slides' => 'required|array',
            'slides.*.id' => 'required|exists:carousel_slides,id',
            'slides.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->slides as $slide) {
            CarouselSlide::where('id', $slide['id'])->update(['order' => $slide['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordem dos slides atualizada com sucesso!'
        ]);
    }
}
