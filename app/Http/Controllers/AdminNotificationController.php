<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user->admin_notifications_enabled) {
            return response()->json([
                'enabled' => false,
                'unread_count' => 0,
                'items' => [],
            ]);
        }

        $notifications = AdminNotification::query()
            ->where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'enabled' => true,
            'unread_count' => AdminNotification::query()
                ->where('user_id', $user->id)
                ->whereNull('read_at')
                ->count(),
            'items' => $notifications->map(fn (AdminNotification $notification) => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'url' => $notification->url,
                'read_at' => $notification->read_at?->toISOString(),
                'time_ago' => $notification->created_at->diffForHumans(),
                'read_url' => route('admin.notifications.read', $notification),
                'icon' => $this->iconFor($notification->entity),
            ]),
        ]);
    }

    public function markRead(Request $request, AdminNotification $adminNotification): JsonResponse
    {
        abort_unless($adminNotification->user_id === $request->user()->id, 404);

        if ($adminNotification->read_at === null) {
            $adminNotification->update(['read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function markAllRead(Request $request): JsonResponse
    {
        AdminNotification::query()
            ->where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    private function iconFor(string $entity): string
    {
        return match ($entity) {
            'event' => 'bi-calendar-event',
            'gallery' => 'bi-images',
            'category' => 'bi-tags',
            'sponsor' => 'bi-award',
            'partner' => 'bi-people',
            'team' => 'bi-person-badge',
            default => 'bi-bell',
        };
    }
}
