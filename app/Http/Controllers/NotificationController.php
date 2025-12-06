<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->notifications()->latest();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Get paginated notifications
        $notifications = $query->active()
                              ->paginate(20)
                              ->appends($request->query());
        
        // Calculate separate statistics to avoid conflicts with pagination
        $totalCount = auth()->user()->notifications()->active()->count();
        $unreadCount = auth()->user()->notifications()->unread()->active()->count();
        $readCount = auth()->user()->notifications()->read()->active()->count();
        $highPriorityCount = auth()->user()->notifications()->where('priority', 'high')->active()->count();
        $todayCount = auth()->user()->notifications()
            ->where('created_at', '>=', today())
            ->active()
            ->count();

        return view('notifications.index', compact(
            'notifications',
            'totalCount',
            'unreadCount', 
            'readCount',
            'highPriorityCount',
            'todayCount'
        ));
    }

    /**
     * Get unread notifications count for AJAX requests.
     */
    public function getUnreadCount()
    {
        $count = auth()->user()->notifications()->unread()->active()->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for dropdown.
     */
    public function getRecent()
    {
        $notifications = auth()->user()->notifications()
            ->active()
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'notifications' => $notifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'type_label' => $notification->type_label,
                    'type_icon' => $notification->type_icon,
                    'priority' => $notification->priority,
                    'priority_badge' => $notification->priority_badge,
                    'is_read' => $notification->isRead(),
                    'action_url' => $notification->action_url,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            }),
            'unread_count' => auth()->user()->notifications()->unread()->active()->count()
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            if (request()->expectsJson()) {
                return response()->json(['success' => true]);
            }

            // If there's an action URL, redirect to it
            if ($notification->action_url) {
                return redirect($notification->action_url);
            }

            return redirect()->back()->with('success', 'Notification marquée comme lue.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Notification introuvable.'], 404);
            }
            
            return redirect()->back()->withErrors(['error' => 'Notification introuvable.']);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        try {
            $updatedCount = auth()->user()->notifications()
                ->unread()
                ->active()
                ->update(['read_at' => now()]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'updated_count' => $updatedCount
                ]);
            }

            if ($updatedCount > 0) {
                return redirect()->back()->with('success', "Toutes les notifications ({$updatedCount}) ont été marquées comme lues.");
            } else {
                return redirect()->back()->with('info', 'Aucune notification non lue à marquer.');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Erreur lors de la mise à jour.'], 500);
            }
            
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la mise à jour des notifications.']);
        }
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->delete();

            if (request()->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Notification supprimée.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Notification introuvable.'], 404);
            }
            
            return redirect()->back()->withErrors(['error' => 'Notification introuvable.']);
        }
    }

    /**
     * Delete all read notifications.
     */
    public function deleteAllRead()
    {
        try {
            $deletedCount = auth()->user()->notifications()
                ->read()
                ->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'deleted_count' => $deletedCount
                ]);
            }

            if ($deletedCount > 0) {
                return redirect()->back()->with('success', "{$deletedCount} notifications supprimées.");
            } else {
                return redirect()->back()->with('info', 'Aucune notification lue à supprimer.');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Erreur lors de la suppression.'], 500);
            }
            
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression des notifications.']);
        }
    }

    /**
     * Create a test notification (for development/testing).
     */
    public function createTest()
    {
        if (!app()->environment('local')) {
            abort(403, 'Cette fonctionnalité est uniquement disponible en développement.');
        }

        try {
            $types = ['stock_alert', 'expiry_alert', 'sale_created', 'prescription_ready', 'purchase_received', 'system_alert'];
            $priorities = ['low', 'normal', 'medium', 'high'];
            
            $type = $types[array_rand($types)];
            $priority = $priorities[array_rand($priorities)];

            Notification::createNotification(
                auth()->id(),
                $type,
                'Notification de test',
                'Ceci est une notification de test générée automatiquement.',
                ['test' => true],
                $priority
            );

            return redirect()->back()->with('success', 'Notification de test créée.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la création de la notification de test.']);
        }
    }

    /**
     * Show notification settings.
     */
    public function settings()
    {
        try {
            $user = auth()->user();
            $settings = $user->permissions['notifications'] ?? [];
            
            return view('notifications.settings', compact('settings'));
        } catch (\Exception $e) {
            return redirect()->route('notifications.index')
                ->withErrors(['error' => 'Erreur lors du chargement des paramètres.']);
        }
    }

    /**
     * Update notification settings.
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'browser_notifications' => 'boolean',
            'stock_alerts' => 'boolean',
            'expiry_alerts' => 'boolean',
            'sale_notifications' => 'boolean',
            'prescription_notifications' => 'boolean',
            'purchase_notifications' => 'boolean',
        ], [
            'email_notifications.boolean' => 'Le paramètre email doit être vrai ou faux.',
            'browser_notifications.boolean' => 'Le paramètre navigateur doit être vrai ou faux.',
            'stock_alerts.boolean' => 'Le paramètre alertes stock doit être vrai ou faux.',
            'expiry_alerts.boolean' => 'Le paramètre alertes expiration doit être vrai ou faux.',
            'sale_notifications.boolean' => 'Le paramètre notifications vente doit être vrai ou faux.',
            'prescription_notifications.boolean' => 'Le paramètre notifications ordonnance doit être vrai ou faux.',
            'purchase_notifications.boolean' => 'Le paramètre notifications achat doit être vrai ou faux.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update user preferences
            $user = auth()->user();
            
            // Get existing permissions or initialize empty array
            $permissions = $user->permissions ?? [];
            $permissions['notifications'] = [
                'email_notifications' => $request->has('email_notifications'),
                'browser_notifications' => $request->has('browser_notifications'),
                'stock_alerts' => $request->has('stock_alerts'),
                'expiry_alerts' => $request->has('expiry_alerts'),
                'sale_notifications' => $request->has('sale_notifications'),
                'prescription_notifications' => $request->has('prescription_notifications'),
                'purchase_notifications' => $request->has('purchase_notifications'),
                'updated_at' => now()->toISOString(),
            ];
            
            $user->permissions = $permissions;
            $user->save();

            return redirect()->back()->with('success', 'Paramètres de notification mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la sauvegarde des paramètres.'])
                ->withInput();
        }
    }

    /**
     * Get notification statistics for dashboard.
     */
    public function getStatistics()
    {
        try {
            $user = auth()->user();
            
            $stats = [
                'total' => $user->notifications()->active()->count(),
                'unread' => $user->notifications()->unread()->active()->count(),
                'high_priority' => $user->notifications()->where('priority', 'high')->active()->count(),
                'today' => $user->notifications()->where('created_at', '>=', today())->active()->count(),
                'by_type' => $user->notifications()
                    ->active()
                    ->selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type')
                    ->toArray(),
                'by_priority' => $user->notifications()
                    ->active()
                    ->selectRaw('priority, COUNT(*) as count')
                    ->groupBy('priority')
                    ->pluck('count', 'priority')
                    ->toArray(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors du calcul des statistiques.'], 500);
        }
    }

    /**
     * Bulk actions on notifications.
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:mark_read,delete',
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'integer|exists:notifications,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        try {
            $notifications = auth()->user()->notifications()
                ->whereIn('id', $request->notification_ids);

            $count = 0;
            switch ($request->action) {
                case 'mark_read':
                    $count = $notifications->unread()->update(['read_at' => now()]);
                    $message = "{$count} notifications marquées comme lues.";
                    break;
                    
                case 'delete':
                    $count = $notifications->count();
                    $notifications->delete();
                    $message = "{$count} notifications supprimées.";
                    break;
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de l\'action groupée.']);
        }
    }
}