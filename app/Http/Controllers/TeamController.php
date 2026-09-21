<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::query()
            ->when(request('search'), fn ($query, $search) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('division', 'like', "%{$search}%");
            }))
            ->when(request('division'), fn ($query, $division) => $query->where('division', $division))
            ->when(request('status'), fn ($query, $status) => $query->where('status', $status))
            ->orderBy('order')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.teams.index', [
            'teams' => $teams,
            'divisionStats' => Team::query()
                ->selectRaw("COALESCE(NULLIF(division, ''), 'Belum diisi') as division, COUNT(*) as total, SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as active")
                ->groupBy('division')
                ->orderBy('division')
                ->get(),
            'divisions' => Team::query()->whereNotNull('division')->where('division', '!=', '')->distinct()->orderBy('division')->pluck('division'),
        ]);
    }

    public function create(): View
    {
        return view('admin.teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['photo'] = $request->file('photo')?->store('teams', 'public');
        Team::create($data);

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(Team $team): View
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($team->photo);
            $data['photo'] = $request->file('photo')->store('teams', 'public');
        }
        $team->update($data);

        return redirect()->route('admin.teams.index')->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    public function destroy(Team $team): RedirectResponse
    {
        Storage::disk('public')->delete($team->photo);
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil dihapus.');
    }

    public function toggleStatus(Team $team): RedirectResponse
    {
        $team->update(['status' => $team->status === 'published' ? 'draft' : 'published']);

        return back()->with('success', 'Status anggota team berhasil diperbarui.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'position' => ['required', 'string', 'max:150'],
            'division' => ['nullable', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'bio' => ['nullable', 'string'],
            'order' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
    }
}