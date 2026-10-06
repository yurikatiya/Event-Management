<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;

class PartnerController extends Controller
{
    public function index(Request $request): View
    {
        $partners = Partner::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->string('search') . '%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.partners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['logo'] = $request->file('logo')?->store('partners', 'public');
        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->validatedData($request);
        $oldLogo = $partner->logo;
        if ($request->hasFile('logo')) {
            $newLogo = $request->file('logo')->store('partners', 'public');
            if (! $newLogo) {
                throw new RuntimeException('Logo partner gagal disimpan ke penyimpanan.');
            }

            $data['logo'] = $newLogo;
        }
        $partner->update($data);

        if (isset($newLogo) && $oldLogo) {
            Storage::disk('public')->delete($oldLogo);
        }

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus.');
    }

    public function toggleStatus(Partner $partner): RedirectResponse
    {
        $partner->update(['status' => $partner->status === 'published' ? 'draft' : 'published']);

        return back()->with('success', 'Status partner berhasil diperbarui.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'category' => ['required', 'in:Government,Education,Community,Company,Creative Industry'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
    }
}