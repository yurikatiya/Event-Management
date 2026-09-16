<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SponsorController extends Controller
{
    public function index(Request $request): View
    {
        $sponsors = Sponsor::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->string('search') . '%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create(): View
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['logo'] = $request->file('logo')?->store('sponsors', 'public');
        Sponsor::create($data);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil ditambahkan.');
    }

    public function edit(Sponsor $sponsor): View
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor): RedirectResponse
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($sponsor->logo);
            $data['logo'] = $request->file('logo')->store('sponsors', 'public');
        }
        $sponsor->update($data);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil diperbarui.');
    }

    public function destroy(Sponsor $sponsor): RedirectResponse
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor berhasil dihapus.');
    }

    public function toggleStatus(Sponsor $sponsor): RedirectResponse
    {
        $nextStatus = in_array($sponsor->status, ['published', 'active']) ? 'draft' : 'active';
        $sponsor->update(['status' => $nextStatus]);

        return back()->with('success', 'Status sponsor berhasil diperbarui.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
            'tier' => ['required', 'in:Platinum,Gold,Silver,Bronze'],
            'status' => ['required', 'in:draft,active,published,archived'],
        ]);
    }
}
