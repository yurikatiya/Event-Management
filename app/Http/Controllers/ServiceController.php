<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::query()
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->string('search') . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, true);
        $data['image'] = $request->file('image')?->store('services', 'public');
        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }
        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        Storage::disk('public')->delete($service->image);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service berhasil dihapus.');
    }

    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->update(['status' => $service->status === 'published' ? 'draft' : 'published']);

        return back()->with('success', 'Status service berhasil diperbarui.');
    }

    private function validatedData(Request $request, bool $imageRequired = false): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
    }
}