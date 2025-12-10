<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CommentController;


// Member Controllers
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\ArtworkController as MemberArtwork;
use App\Http\Controllers\Member\ProfileController as MemberProfile;
use App\Http\Controllers\Member\FavoriteController as MemberFavorite;
use App\Http\Controllers\Member\FollowController as MemberFollow;
use App\Http\Controllers\Member\ReportController as MemberReport;
use App\Http\Controllers\Member\CollectionController as MemberCollection;
use App\Http\Controllers\Member\SubmissionController as MemberSubmission;

// Curator Controllers
use App\Http\Controllers\Curator\PendingController;
use App\Http\Controllers\Curator\DashboardController as CuratorDashboard;
use App\Http\Controllers\Curator\ChallengeController as CuratorChallenge;
use App\Http\Controllers\Curator\SubmissionController as CuratorSubmission;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ModerationController as AdminModeration;

// Models
use App\Models\Challenge;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// =================== PUBLIC ROUTES ===================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/welcome', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'curator' => redirect()->route('curator.dashboard'),
            'member' => redirect()->route('member.dashboard'),
            default => redirect()->route('home'),
        };
    }
    return view('welcome');
})->name('welcome');

// Public Artwork Routes
Route::get('/artworks', [HomeController::class, 'artworks'])->name('artworks.index');
Route::get('/artworks/{artwork}', [HomeController::class, 'showArtwork'])->name('artworks.show');

// Public Profile Routes
Route::get('/profile/{username}', [HomeController::class, 'profile'])->name('profile.show');

// Public Challenge Routes - PERBAIKAN: Gunakan slug bukan model binding
Route::get('/challenges', [HomeController::class, 'challenges'])->name('challenges.index');
Route::get('/challenges/{slug}', function($slug) {
    $challenge = Challenge::where('slug', $slug)->firstOrFail();
    
    $challenge->load([
        'curator:id,name,display_name,profile_image,bio',
        'submissions.artwork.user:id,name,display_name,profile_image',
        'submissions.artwork.category:id,name',
        'winners.submission.artwork.user',
        'winners.submission.artwork'
    ]);
    
    // Get related challenges
    $relatedChallenges = Challenge::where('id', '!=', $challenge->id)
        ->where(function($query) use ($challenge) {
            $query->where('theme', $challenge->theme)
                  ->orWhere('status', $challenge->status);
        })
        ->orWhere('curator_id', $challenge->curator_id)
        ->with('curator:id,name,display_name,profile_image')
        ->latest()
        ->take(3)
        ->get();
    
    return view('challenges.show', compact('challenge', 'relatedChallenges'));
})->name('challenges.show');

// Explore Pages
Route::get('/explore/creators', [HomeController::class, 'exploreCreators'])->name('explore.creators');
Route::get('/explore/trending', [HomeController::class, 'exploreTrending'])->name('explore.trending');
Route::get('/explore/collections', [HomeController::class, 'exploreCollections'])->name('explore.collections');

// Challenge Categories Routes
Route::get('/challenges/active', [HomeController::class, 'activeChallenges'])->name('challenges.active');
Route::get('/challenges/past', [HomeController::class, 'pastChallenges'])->name('challenges.past');

// Search Route
Route::get('/search', [HomeController::class, 'search'])->name('search');

// New Activity Feed Route
Route::get('/activity', [HomeController::class, 'activityFeed'])->name('activity.feed');

// Artwork Interactions (Auth Required)
Route::middleware(['auth'])->group(function () {
    // Like artwork
    Route::post('/artworks/{artwork}/like', [MemberArtwork::class, 'like'])
        ->name('artworks.like');
    
    // Favorite artwork
    Route::post('/artworks/{artwork}/favorite', [MemberArtwork::class, 'favorite'])
        ->name('artworks.favorite');
    
    // Unfavorite artwork
    Route::delete('/artworks/{artwork}/favorite', [MemberArtwork::class, 'unfavorite'])
        ->name('artworks.unfavorite');
});

// Static Pages
Route::view('/about', 'static.about')->name('about');
Route::view('/contact', 'static.contact')->name('contact');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::view('/terms', 'static.terms')->name('terms');
Route::view('/faq', 'static.faq')->name('faq');
Route::view('/guidelines', 'static.guidelines')->name('guidelines');

// Route untuk comments
Route::middleware(['auth'])->group(function () {
    // Store comment
    Route::post('/artworks/{artwork}/comments', [CommentController::class, 'store'])
        ->name('artworks.comments.store');
    
    // Update comment
    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update');
    
    // Delete comment
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
    
    // Reply to comment
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])
        ->name('comments.reply');
    
    // Like comment
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])
        ->name('comments.like');
});

// =================== AUTH ROUTES ===================
Route::get('/pending-approval', [PendingController::class, 'index'])
    ->middleware(['auth', \App\Http\Middleware\CuratorPendingMiddleware::class])
    ->name('pending.approval');

// Auth Routes for Guests
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    
    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Auth Routes for Authenticated Users
Route::middleware('auth')->group(function () {
    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    // Password Confirmation
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
    // Password Update
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// =================== MEMBER ROUTES ===================
Route::middleware(['auth', 'verified', \App\Http\Middleware\MemberMiddleware::class])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [MemberDashboard::class, 'stats'])->name('dashboard.stats');
    
    // Profile Management
    Route::get('/profile/edit', [MemberProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [MemberProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [MemberProfile::class, 'updatePassword'])->name('profile.password.update');
    
    // Artwork Management
    Route::resource('/artworks', MemberArtwork::class)->except(['show']);
    Route::get('/artworks/{artwork}', [MemberArtwork::class, 'show'])->name('artworks.show');
    
    // Artwork Comments
    Route::post('/artworks/{artwork}/comment', [MemberArtwork::class, 'comment'])
        ->name('artworks.comment');
    Route::delete('/comments/{comment}', [MemberArtwork::class, 'deleteComment'])
        ->name('comments.delete');
    
    // Favorites
    Route::get('/favorites', [MemberFavorite::class, 'index'])->name('favorites.index');
    
    // Collections (Moodboards)
    Route::resource('/collections', MemberCollection::class);
    
    // Collection Artwork Management (AJAX)
    Route::post('/collections/{collection}/add-artwork', [MemberCollection::class, 'addArtwork'])
        ->name('collections.add-artwork');
    Route::delete('/collections/{collection}/remove-artwork/{artwork}', [MemberCollection::class, 'removeArtwork'])
        ->name('collections.remove-artwork');
    
    // Follow System
    Route::post('/follow/{user}', [MemberFollow::class, 'toggle'])->name('follow.toggle');
    Route::get('/following/feed', [MemberFollow::class, 'feed'])->name('following.feed');
    Route::get('/followers', [MemberFollow::class, 'followers'])->name('followers');
    Route::get('/following', [MemberFollow::class, 'following'])->name('following');
    
    // Reports
    Route::post('/report/artwork/{id}', [MemberReport::class, 'reportArtwork'])->name('report.artwork');
    Route::post('/report/comment/{id}', [MemberReport::class, 'reportComment'])->name('report.comment');
    
    // Submissions
    Route::get('/submissions', [MemberSubmission::class, 'index'])->name('submissions.index');
    Route::post('/submissions', [MemberSubmission::class, 'store'])->name('submissions.store');
    Route::delete('/submissions/{submission}', [MemberSubmission::class, 'destroy'])->name('submissions.destroy');
    Route::get('/submissions/create/{challenge}', [MemberSubmission::class, 'create'])->name('submissions.create');
    Route::get('/submissions/{challenge}/check', [MemberSubmission::class, 'checkSubmission'])->name('submissions.check');
    
    // Artworks JSON API
    Route::get('/artworks/json', function () {
        try {
            $artworks = Auth::user()->artworks()
                ->select('id', 'title', 'image_url')
                ->latest()
                ->get()
                ->map(function ($artwork) {
                    return [
                        'id' => $artwork->id,
                        'title' => $artwork->title,
                        'image_url' => $artwork->image_url,
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $artworks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load artworks'
            ], 500);
        }
    })->name('artworks.json');
    
    // Notifications
    Route::get('/notifications', function() {
        return view('member.notifications');
    })->name('notifications');
    Route::post('/notifications/mark-all-read', function() {
        return response()->json(['success' => true]);
    })->name('notifications.mark-all-read');
    
    // Settings
    Route::get('/settings', function() {
        return view('member.settings');
    })->name('settings');
    
    // Messages
    Route::get('/messages', function() {
        return view('member.messages');
    })->name('messages');
    
    // Help
    Route::get('/help', function() {
        return view('member.help');
    })->name('help');
    
    // Statistics
    Route::get('/statistics', function() {
        $user = auth()->user();
        $stats = [
            'artworks_count' => $user->artworks()->count(),
            'likes_received' => $user->artworks()->withCount('likes')->get()->sum('likes_count'),
            'views_received' => $user->artworks()->sum('views_count'),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
        ];
        return view('member.statistics', compact('stats'));
    })->name('statistics');
    
    // Additional Member Routes
    Route::get('/activity', function() {
        return view('member.activity');
    })->name('activity');
    
    Route::get('/achievements', function() {
        return view('member.achievements');
    })->name('achievements');
    
    Route::get('/badges', function() {
        return view('member.badges');
    })->name('badges');
    
    Route::get('/rankings', function() {
        return view('member.rankings');
    })->name('rankings');
    
    // Additional functionality
    Route::get('/notifications/settings', function() {
        return view('member.notifications-settings');
    })->name('notifications.settings');
    
    Route::get('/privacy-settings', function() {
        return view('member.privacy-settings');
    })->name('privacy-settings');
    
    Route::get('/account-settings', function() {
        return view('member.account-settings');
    })->name('account-settings');
    
    Route::get('/billing', function() {
        return view('member.billing');
    })->name('billing');
    
    Route::get('/subscription', function() {
        return view('member.subscription');
    })->name('subscription');
    
    Route::get('/gallery', function() {
        return view('member.gallery');
    })->name('gallery');
    
    Route::get('/portfolio', function() {
        return view('member.portfolio');
    })->name('portfolio');
    
    Route::get('/exhibitions', function() {
        return view('member.exhibitions');
    })->name('exhibitions');
    
    Route::get('/workshops', function() {
        return view('member.workshops');
    })->name('workshops');
    
    Route::get('/marketplace', function() {
        return view('member.marketplace');
    })->name('marketplace');
    
    Route::get('/commissions', function() {
        return view('member.commissions');
    })->name('commissions');
    
    Route::get('/collaborations', function() {
        return view('member.collaborations');
    })->name('collaborations');
    
    Route::get('/mentorship', function() {
        return view('member.mentorship');
    })->name('mentorship');
});

// =================== CURATOR ROUTES ===================
Route::middleware(['auth', 'verified', \App\Http\Middleware\CuratorMiddleware::class])
    ->prefix('curator')
    ->name('curator.')
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [CuratorDashboard::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [CuratorDashboard::class, 'stats'])->name('dashboard.stats');
    
    // Pending approval page
    Route::get('/pending', function () {
        return view('curator.pending');
    })->middleware(\App\Http\Middleware\CuratorPendingMiddleware::class)->name('pending');
    
    // Profile & Settings
    Route::get('/profile', function() {
        return view('curator.profile');
    })->name('profile');
    
    Route::get('/settings', function() {
        return view('curator.settings');
    })->name('settings');
    
    // Analytics & Reports
    Route::middleware(\App\Http\Middleware\CuratorActiveMiddleware::class)->group(function () {
        Route::get('/analytics', [CuratorDashboard::class, 'analytics'])->name('analytics');
        Route::get('/submission-reports', [CuratorDashboard::class, 'submissionReports'])->name('submission.reports');
        Route::get('/users', [CuratorDashboard::class, 'users'])->name('users.index');
        Route::get('/artworks', [CuratorDashboard::class, 'artworks'])->name('artworks.index');
    });
    
    // =================== CURATOR CHALLENGE ROUTES ===================
    Route::middleware(\App\Http\Middleware\CuratorActiveMiddleware::class)->group(function () {
        // Challenge Resource tanpa 'show'
        Route::resource('challenges', CuratorChallenge::class)->except(['show']);
        
        // Manual routes dengan constraint numeric untuk menghindari konflik dengan public route
        Route::get('challenges/{challenge}', [CuratorChallenge::class, 'show'])
            ->name('challenges.show')
            ->where('challenge', '[0-9]+');
        
        Route::get('challenges/{challenge}/submissions', [CuratorChallenge::class, 'submissions'])
            ->name('challenges.submissions')
            ->where('challenge', '[0-9]+');
        
        Route::get('challenges/{challenge}/select-winners', [CuratorChallenge::class, 'selectWinners'])
            ->name('challenges.select-winners')
            ->where('challenge', '[0-9]+');
        
        Route::post('challenges/{challenge}/store-winners', [CuratorChallenge::class, 'storeWinners'])
            ->name('challenges.store-winners')
            ->where('challenge', '[0-9]+');
        
        Route::post('challenges/{challenge}/close', [CuratorChallenge::class, 'close'])
            ->name('challenges.close')
            ->where('challenge', '[0-9]+');
        
        Route::post('challenges/{challenge}/reopen', [CuratorChallenge::class, 'reopen'])
            ->name('challenges.reopen')
            ->where('challenge', '[0-9]+');
        
        Route::post('challenges/{challenge}/select-winner/{submission}', [CuratorChallenge::class, 'selectWinner'])
            ->name('challenges.select-winner')
            ->where('challenge', '[0-9]+');
    });
    
    // Submission Management
    Route::middleware(\App\Http\Middleware\CuratorActiveMiddleware::class)->group(function () {
        // Submission Status Management
        Route::post('/submissions/{submission}/status', [CuratorSubmission::class, 'updateStatus'])
            ->name('submissions.update-status');
        
        Route::post('/submissions/bulk-status', [CuratorSubmission::class, 'bulkUpdateStatus'])
            ->name('submissions.bulk-update-status');
        
        Route::post('/submissions/{submission}/mark-winner', [CuratorSubmission::class, 'markAsWinner'])
            ->name('submissions.mark-winner');
        
        Route::delete('/submissions/{submission}/remove', [CuratorSubmission::class, 'remove'])
            ->name('submissions.remove');
    });
    
    // Additional Curator Routes
    Route::get('/reports', function() {
        return view('curator.reports');
    })->name('reports');
    
    Route::get('/analytics/detailed', function() {
        return view('curator.analytics.detailed');
    })->name('analytics.detailed');
    
    Route::get('/community', function() {
        return view('curator.community');
    })->name('community');
    
    Route::get('/communications', function() {
        return view('curator.communications');
    })->name('communications');
    
    Route::get('/tools', function() {
        return view('curator.tools');
    })->name('tools');
    
    Route::get('/resources', function() {
        return view('curator.resources');
    })->name('resources');
    
    Route::get('/help-center', function() {
        return view('curator.help-center');
    })->name('help-center');
    
    // Additional curator functionality
    Route::get('/notifications', function() {
        return view('curator.notifications');
    })->name('notifications');
    
    Route::get('/messages', function() {
        return view('curator.messages');
    })->name('messages');
    
    Route::get('/calendar', function() {
        return view('curator.calendar');
    })->name('calendar');
    
    Route::get('/tasks', function() {
        return view('curator.tasks');
    })->name('tasks');
    
    Route::get('/team', function() {
        return view('curator.team');
    })->name('team');
    
    Route::get('/collaborators', function() {
        return view('curator.collaborators');
    })->name('collaborators');
    
    Route::get('/sponsors', function() {
        return view('curator.sponsors');
    })->name('sponsors');
    
    Route::get('/partners', function() {
        return view('curator.partners');
    })->name('partners');
    
    Route::get('/announcements', function() {
        return view('curator.announcements');
    })->name('announcements');
    
    Route::get('/newsletter', function() {
        return view('curator.newsletter');
    })->name('newsletter');
    
    Route::get('/social-media', function() {
        return view('curator.social-media');
    })->name('social-media');
    
    Route::get('/branding', function() {
        return view('curator.branding');
    })->name('branding');
    
    Route::get('/templates', function() {
        return view('curator.templates');
    })->name('templates');
    
    Route::get('/guidelines', function() {
        return view('curator.guidelines');
    })->name('guidelines');
    
    Route::get('/faq', function() {
        return view('curator.faq');
    })->name('faq');
    
    Route::get('/support', function() {
        return view('curator.support');
    })->name('support');
    
    Route::get('/feedback', function() {
        return view('curator.feedback');
    })->name('feedback');
    
    Route::get('/testimonials', function() {
        return view('curator.testimonials');
    })->name('testimonials');
    
    Route::get('/success-stories', function() {
        return view('curator.success-stories');
    })->name('success-stories');
    
    Route::get('/case-studies', function() {
        return view('curator.case-studies');
    })->name('case-studies');
    
    Route::get('/portfolio', function() {
        return view('curator.portfolio');
    })->name('portfolio');
    
    Route::get('/showcase', function() {
        return view('curator.showcase');
    })->name('showcase');
    
    Route::get('/gallery', function() {
        return view('curator.gallery');
    })->name('gallery');
    
    Route::get('/exhibitions', function() {
        return view('curator.exhibitions');
    })->name('exhibitions');
    
    Route::get('/events', function() {
        return view('curator.events');
    })->name('events');
    
    Route::get('/webinars', function() {
        return view('curator.webinars');
    })->name('webinars');
    
    Route::get('/workshops', function() {
        return view('curator.workshops');
    })->name('workshops');
});

// =================== ADMIN ROUTES ===================
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Statistics
    Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics');
    
    // User Management
    Route::resource('users', AdminUser::class)->except(['show']);
    Route::get('/users/{user}', [AdminUser::class, 'show'])->name('users.show');
    
    // User Actions
    Route::post('/users/{user}/approve', [AdminUser::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [AdminUser::class, 'reject'])->name('users.reject');
    Route::post('/users/{user}/activate', [AdminUser::class, 'activate'])->name('users.activate');
    Route::post('/users/{user}/deactivate', [AdminUser::class, 'deactivate'])->name('users.deactivate');
    Route::put('/users/{user}/role', [AdminUser::class, 'updateRole'])->name('users.role.update');
    Route::put('/users/{user}/status', [AdminUser::class, 'updateStatus'])->name('users.status.update');
    Route::post('/users/{user}/ban', [AdminUser::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminUser::class, 'unban'])->name('users.unban');
    Route::post('/users/{user}/message', [AdminUser::class, 'sendMessage'])->name('users.sendMessage');
    
    // Category Management
    Route::resource('categories', AdminCategory::class);
    
    // Moderation Management
    Route::get('/moderation', [AdminModeration::class, 'index'])->name('moderation.index');
    Route::get('/moderation/reports', [AdminModeration::class, 'reports'])->name('moderation.reports');
    Route::get('/moderation/flags', [AdminModeration::class, 'flags'])->name('moderation.flags');
    Route::get('/moderation/{report}', [AdminModeration::class, 'show'])->name('moderation.show');
    Route::post('/reports/{report}/dismiss', [AdminModeration::class, 'dismiss'])->name('reports.dismiss');
    Route::post('/reports/{report}/resolve', [AdminModeration::class, 'resolve'])->name('reports.resolve');
    Route::post('/moderation/{user}/suspend', [AdminModeration::class, 'suspendUser'])->name('moderation.suspend');
    Route::post('/moderation/{user}/unsuspend', [AdminModeration::class, 'unsuspendUser'])->name('moderation.unsuspend');
    Route::post('/moderation/{report}/note', [AdminModeration::class, 'addNote'])->name('moderation.addNote');
    
    // Site Settings
    Route::get('/settings', [AdminDashboard::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminDashboard::class, 'updateSettings'])->name('settings.update');
    Route::get('/settings/general', [AdminDashboard::class, 'generalSettings'])->name('settings.general');
    Route::get('/settings/appearance', [AdminDashboard::class, 'appearanceSettings'])->name('settings.appearance');
    Route::get('/settings/email', [AdminDashboard::class, 'emailSettings'])->name('settings.email');
    Route::get('/settings/storage', [AdminDashboard::class, 'storageSettings'])->name('settings.storage');
    
    // System Logs
    Route::get('/logs', [AdminDashboard::class, 'logs'])->name('logs');
    Route::get('/logs/activity', [AdminDashboard::class, 'activityLogs'])->name('logs.activity');
    Route::get('/logs/error', [AdminDashboard::class, 'errorLogs'])->name('logs.error');
    Route::get('/logs/access', [AdminDashboard::class, 'accessLogs'])->name('logs.access');
    
    // Backup & Maintenance
    Route::get('/maintenance', [AdminDashboard::class, 'maintenance'])->name('maintenance');
    Route::post('/backup', [AdminDashboard::class, 'createBackup'])->name('backup.create');
    Route::post('/maintenance/cache-clear', [AdminDashboard::class, 'clearCache'])->name('maintenance.cache-clear');
    Route::post('/maintenance/optimize', [AdminDashboard::class, 'optimize'])->name('maintenance.optimize');
    
    // Statistics & Analytics
    Route::get('/statistics', [AdminDashboard::class, 'statistics'])->name('statistics');
    Route::get('/analytics', [AdminDashboard::class, 'analytics'])->name('analytics');
    Route::get('/reports', [AdminDashboard::class, 'reports'])->name('reports');
    
    // Content Management
    Route::get('/content/artworks', [AdminDashboard::class, 'contentArtworks'])->name('content.artworks');
    Route::get('/content/comments', [AdminDashboard::class, 'contentComments'])->name('content.comments');
    Route::get('/content/collections', [AdminDashboard::class, 'contentCollections'])->name('content.collections');
    
    // Curator Management
    Route::get('/curators', [AdminDashboard::class, 'curators'])->name('curators.index');
    Route::get('/curators/pending', [AdminDashboard::class, 'pendingCurators'])->name('curators.pending');
    Route::post('/curators/{user}/approve', [AdminDashboard::class, 'approveCurator'])->name('curators.approve');
    Route::post('/curators/{user}/reject', [AdminDashboard::class, 'rejectCurator'])->name('curators.reject');
    
    // Challenge Management
    Route::get('/challenges', [AdminDashboard::class, 'challenges'])->name('challenges.index');
    Route::get('/challenges/{challenge}', [AdminDashboard::class, 'challengeShow'])->name('challenges.show');
    Route::post('/challenges/{challenge}/approve', [AdminDashboard::class, 'approveChallenge'])->name('challenges.approve');
    Route::post('/challenges/{challenge}/reject', [AdminDashboard::class, 'rejectChallenge'])->name('challenges.reject');
    Route::post('/challenges/{challenge}/feature', [AdminDashboard::class, 'toggleFeature'])->name('challenges.toggle-feature');
    
    // Additional Admin Routes
    Route::get('/system-status', function() {
        return view('admin.system-status');
    })->name('system-status');
    
    Route::get('/api-management', function() {
        return view('admin.api-management');
    })->name('api-management');
    
    Route::get('/email-templates', function() {
        return view('admin.email-templates');
    })->name('email-templates');
    
    Route::get('/payment-settings', function() {
        return view('admin.payment-settings');
    })->name('payment-settings');
    
    Route::get('/notification-center', function() {
        return view('admin.notification-center');
    })->name('notification-center');
    
    Route::get('/seo-settings', function() {
        return view('admin.seo-settings');
    })->name('seo-settings');
    
    Route::get('/social-integration', function() {
        return view('admin.social-integration');
    })->name('social-integration');
    
    Route::get('/theme-customization', function() {
        return view('admin.theme-customization');
    })->name('theme-customization');
    
    // More admin routes
    Route::get('/database', function() {
        return view('admin.database');
    })->name('database');
    
    Route::get('/server', function() {
        return view('admin.server');
    })->name('server');
    
    Route::get('/security', function() {
        return view('admin.security');
    })->name('security');
    
    Route::get('/performance', function() {
        return view('admin.performance');
    })->name('performance');
    
    Route::get('/monitoring', function() {
        return view('admin.monitoring');
    })->name('monitoring');
    
    Route::get('/audit', function() {
        return view('admin.audit');
    })->name('audit');
    
    Route::get('/compliance', function() {
        return view('admin.compliance');
    })->name('compliance');
    
    Route::get('/licensing', function() {
        return view('admin.licensing');
    })->name('licensing');
    
    Route::get('/subscriptions', function() {
        return view('admin.subscriptions');
    })->name('subscriptions');
    
    Route::get('/billing', function() {
        return view('admin.billing');
    })->name('billing');
    
    Route::get('/invoices', function() {
        return view('admin.invoices');
    })->name('invoices');
    
    Route::get('/taxes', function() {
        return view('admin.taxes');
    })->name('taxes');
    
    Route::get('/refunds', function() {
        return view('admin.refunds');
    })->name('refunds');
    
    Route::get('/coupons', function() {
        return view('admin.coupons');
    })->name('coupons');
    
    Route::get('/affiliates', function() {
        return view('admin.affiliates');
    })->name('affiliates');
    
    Route::get('/referrals', function() {
        return view('admin.referrals');
    })->name('referrals');
    
    Route::get('/marketing', function() {
        return view('admin.marketing');
    })->name('marketing');
    
    Route::get('/campaigns', function() {
        return view('admin.campaigns');
    })->name('campaigns');
    
    Route::get('/newsletter-admin', function() {
        return view('admin.newsletter');
    })->name('newsletter.admin');
    
    Route::get('/broadcasts', function() {
        return view('admin.broadcasts');
    })->name('broadcasts');
    
    Route::get('/announcements-admin', function() {
        return view('admin.announcements');
    })->name('announcements.admin');
    
    Route::get('/surveys', function() {
        return view('admin.surveys');
    })->name('surveys');
    
    Route::get('/feedback-admin', function() {
        return view('admin.feedback');
    })->name('feedback.admin');
    
    Route::get('/support-admin', function() {
        return view('admin.support');
    })->name('support.admin');
    
    Route::get('/tickets', function() {
        return view('admin.tickets');
    })->name('tickets');
    
    Route::get('/knowledge-base', function() {
        return view('admin.knowledge-base');
    })->name('knowledge-base');
    
    Route::get('/documentation', function() {
        return view('admin.documentation');
    })->name('documentation');
    
    Route::get('/training', function() {
        return view('admin.training');
    })->name('training');
    
    Route::get('/onboarding', function() {
        return view('admin.onboarding');
    })->name('onboarding');
    
    Route::get('/community-admin', function() {
        return view('admin.community');
    })->name('community.admin');
    
    Route::get('/forums', function() {
        return view('admin.forums');
    })->name('forums');
    
    Route::get('/groups', function() {
        return view('admin.groups');
    })->name('groups');
    
    Route::get('/events-admin', function() {
        return view('admin.events');
    })->name('events.admin');
    
    Route::get('/webinars-admin', function() {
        return view('admin.webinars');
    })->name('webinars.admin');
    
    Route::get('/workshops-admin', function() {
        return view('admin.workshops');
    })->name('workshops.admin');
});

// =================== API ROUTES FOR AJAX ===================
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    // Challenge API
    Route::get('/challenges/active', function() {
        $challenges = \App\Models\Challenge::active()
            ->with('curator:id,name,display_name,profile_image')
            ->latest()
            ->get();
        return response()->json($challenges);
    })->name('challenges.active');
    
    // Artwork API
    Route::get('/artworks/recent', function() {
        $artworks = \App\Models\Artwork::with(['user:id,name,display_name,profile_image', 'category'])
            ->latest()
            ->take(10)
            ->get();
        return response()->json($artworks);
    })->name('artworks.recent');
    
    // User API
    Route::get('/users/top-creators', function() {
        $users = \App\Models\User::where('role', 'member')
            ->withCount('artworks')
            ->orderBy('artworks_count', 'desc')
            ->take(10)
            ->get(['id', 'name', 'display_name', 'profile_image', 'bio']);
        return response()->json($users);
    })->name('users.top-creators');
    
    // Notification API
    Route::get('/notifications/unread-count', function() {
        $count = auth()->user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    })->name('notifications.unread-count');
    
    Route::post('/notifications/mark-read/{id}', function($id) {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    })->name('notifications.mark-read');
    
    Route::post('/notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    })->name('notifications.mark-all-read');
    
    // Challenge Submission API
    Route::get('/challenges/{challenge}/submission-status', function($challengeId) {
        $userId = auth()->id();
        $hasSubmitted = \App\Models\Submission::where('challenge_id', $challengeId)
            ->where('user_id', $userId)
            ->exists();
        
        return response()->json(['hasSubmitted' => $hasSubmitted]);
    })->name('challenges.submission-status');
    
    // User Stats API
    Route::get('/user/stats', function() {
        $user = auth()->user();
        $stats = [
            'artworks_count' => $user->artworks()->count(),
            'likes_received' => $user->artworks()->withCount('likes')->get()->sum('likes_count'),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
        ];
        return response()->json($stats);
    })->name('user.stats');
    
    // Search API
    Route::get('/search/quick', function(Request $request) {
        $query = $request->get('q');
        
        $results = [];
        
        // Search users
        $users = \App\Models\User::where('name', 'like', "%{$query}%")
            ->orWhere('display_name', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'display_name', 'profile_image']);
        
        // Search artworks
        $artworks = \App\Models\Artwork::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('user:id,name,display_name,profile_image')
            ->take(5)
            ->get(['id', 'title', 'image_url', 'user_id']);
        
        // Search challenges
        $challenges = \App\Models\Challenge::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('curator:id,name,display_name,profile_image')
            ->take(5)
            ->get(['id', 'title', 'slug', 'banner_image', 'curator_id']);
        
        return response()->json([
            'users' => $users,
            'artworks' => $artworks,
            'challenges' => $challenges
        ]);
    })->name('search.quick');
    
    // More API routes
    Route::get('/artworks/popular', function() {
        $artworks = \App\Models\Artwork::with(['user:id,name,display_name,profile_image', 'category'])
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(10)
            ->get();
        return response()->json($artworks);
    })->name('artworks.popular');
    
    Route::get('/challenges/featured', function() {
        $challenges = \App\Models\Challenge::featured()
            ->with('curator:id,name,display_name,profile_image')
            ->latest()
            ->get();
        return response()->json($challenges);
    })->name('challenges.featured');
    
    Route::get('/challenges/upcoming', function() {
        $challenges = \App\Models\Challenge::upcoming()
            ->with('curator:id,name,display_name,profile_image')
            ->latest()
            ->get();
        return response()->json($challenges);
    })->name('challenges.upcoming');
    
    Route::get('/categories/all', function() {
        $categories = \App\Models\Category::withCount('artworks')
            ->orderBy('artworks_count', 'desc')
            ->get();
        return response()->json($categories);
    })->name('categories.all');
    
    Route::get('/users/online', function() {
        $users = \App\Models\User::where('last_seen', '>=', now()->subMinutes(5))
            ->where('role', 'member')
            ->take(20)
            ->get(['id', 'name', 'display_name', 'profile_image', 'last_seen']);
        return response()->json($users);
    })->name('users.online');
    
    Route::get('/system/stats', function() {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_artworks' => \App\Models\Artwork::count(),
            'total_challenges' => \App\Models\Challenge::count(),
            'total_submissions' => \App\Models\Submission::count(),
            'total_likes' => \App\Models\Like::count(),
            'total_comments' => \App\Models\Comment::count(),
        ];
        return response()->json($stats);
    })->name('system.stats');
});

// =================== DEBUG ROUTES ===================
Route::get('/debug/routes', function() {
    $routes = collect(Route::getRoutes())->map(function ($route) {
        return [
            'methods' => $route->methods(),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    })->filter(function ($route) {
        // Filter hanya route yang berhubungan dengan challenge
        return str_contains($route['uri'], 'challenge') || 
               str_contains($route['name'] ?? '', 'challenge') ||
               str_contains($route['action'] ?? '', 'ChallengeController');
    });
    
    return response()->json([
        'total_challenge_routes' => $routes->count(),
        'routes' => $routes->values(),
    ]);
})->middleware('auth');

Route::get('/debug/current-route', function() {
    $currentRoute = Route::current();
    
    return response()->json([
        'current_route_name' => Route::currentRouteName(),
        'current_uri' => request()->path(),
        'current_parameters' => $currentRoute ? $currentRoute->parameters() : [],
        'route_action' => $currentRoute ? $currentRoute->getActionName() : null,
        'route_methods' => $currentRoute ? $currentRoute->methods() : [],
        'is_challenge_param_string' => is_string(request()->route('challenge')),
        'is_challenge_param_object' => is_object(request()->route('challenge')),
        'challenge_param_type' => gettype(request()->route('challenge')),
    ]);
})->middleware('auth');

// =================== TEST ROUTES ===================
Route::get('/test/hello', function() {
    return 'Hello World! Route test successful.';
})->name('test.hello');

Route::get('/test/challenge/{id}', function($id) {
    return "Test Challenge ID: " . $id;
})->name('test.challenge');

// =================== FALLBACK ROUTES ===================
Route::fallback(function () {
    return redirect()->route('home')->with('error', 'Page not found.');
});