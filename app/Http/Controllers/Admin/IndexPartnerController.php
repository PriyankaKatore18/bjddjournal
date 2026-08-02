<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndexPartner;
use Illuminate\Http\Request;

class IndexPartnerController extends Controller
{
    public function index()
    {
        $partners = IndexPartner::latest()->get();

        return view('admin.index-partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.index-partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'url'  => 'nullable|string|max:255',
        ]);

        $iconPath = null;

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('index-partners', 'public');
        }

        IndexPartner::create([
            'name' => $request->name,
            'icon' => $iconPath,
            'url'  => $request->url,
        ]);

        return redirect()->route('admin.index-partners.index')
            ->with('success', 'Partner added successfully.');
    }

    public function edit($id)
    {
        $partner = IndexPartner::findOrFail($id);

        return view('admin.index-partners.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'url'  => 'nullable|string|max:255',
        ]);

        $partner = IndexPartner::findOrFail($id);

        $iconPath = $partner->icon;

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('index-partners', 'public');
        }

        $partner->update([
            'name' => $request->name,
            'icon' => $iconPath,
            'url'  => $request->url,
        ]);

        return redirect()->route('admin.index-partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy($id)
    {
        $partner = IndexPartner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.index-partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
