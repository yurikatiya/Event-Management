<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminContentObserver
{
    private const ENTITIES = [
        Event::class => ['event', 'Event', 'name', 'admin.events.index'],
        Gallery::class => ['gallery', 'Gallery', 'title', 'admin.gallery.index'],
        Category::class => ['category', 'Category', 'name', 'admin.categories.index'],
        Sponsor::class => ['sponsor', 'Sponsor', 'name', 'admin.sponsors.index'],
        Partner::class => ['partner', 'Partner', 'name', 'admin.partners.index'],
        Team::class => ['team', 'Tim', 'name', 'admin.teams.index'],
    ];

    public function created(Model $model): void
    {
        $this->notify($model, 'created');
    }

    public function updated(Model $model): void
    {
        if (! $model->wasChanged()) {
            return;
        }

        $this->notify($model, $model->wasChanged('status') ? 'status' : 'updated');
    }

    public function deleted(Model $model): void
    {
        $this->notify($model, 'deleted');
    }

    private function notify(Model $model, string $action): void
    {
        $entity = self::ENTITIES[$model::class] ?? null;
        $actor = request()->user();

        if ($entity === null || ! $actor instanceof User || $actor->role !== 'admin') {
            return;
        }

        [$key, $label, $nameAttribute, $routeName] = $entity;
        $name = trim((string) ($model->getAttribute($nameAttribute) ?: $model->getAttribute('caption')));
        if ($name === '') {
            $name = class_basename($model) === 'Gallery' ? basename((string) $model->getAttribute('file_path')) : $label;
        }

        $actionLabel = match ($action) {
            'created' => 'menambahkan',
            'deleted' => 'menghapus',
            'status' => 'mengubah status',
            default => 'memperbarui',
        };
        $titleAction = match ($action) {
            'created' => 'baru ditambahkan',
            'deleted' => 'dihapus',
            'status' => 'status diperbarui',
            default => 'diperbarui',
        };
        $url = route($routeName);

        if ($key === 'gallery' && $model->getAttribute('event_id')) {
            $url = route($routeName, ['event_id' => $model->getAttribute('event_id')]);
        }

        $now = now();
        $rows = User::query()
            ->where('role', 'admin')
            ->where('admin_notifications_enabled', true)
            ->pluck('id')
            ->map(fn (int $userId) => [
                'user_id' => $userId,
                'actor_id' => $actor->id,
                'entity' => $key,
                'action' => $action,
                'title' => "{$label} {$titleAction}",
                'message' => "{$actor->name} {$actionLabel} {$label}: {$name}.",
                'url' => $url,
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->all();

        if ($rows !== []) {
            \App\Models\AdminNotification::query()->insert($rows);
        }
    }
}
