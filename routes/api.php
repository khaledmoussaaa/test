<?php

use App\Http\Controllers\Followups\FollowupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Blogs\BlogController;
use App\Http\Controllers\Branches\BranchController;
use App\Http\Controllers\Chats\ChatController;
use App\Http\Controllers\ClassRooms\ClassRoomController;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\Faqs\FaqController;
use App\Http\Controllers\Galleries\GalleryController;
use App\Http\Controllers\Galleries\GalleryMediaController;
use App\Http\Controllers\Guests\GuestController;
use App\Http\Controllers\KidPyamentBills\KidPaymentBillController;
use App\Http\Controllers\Kids\KidController;
use App\Http\Controllers\Meals\MealController;
use App\Http\Controllers\Messages\MessageController;
use App\Http\Controllers\Newsletters\NewsletterController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Nurseries\NurseryController;
use App\Http\Controllers\Parents\ParentController;
use App\Http\Controllers\PaymentBills\PaymentBillController;
use App\Http\Controllers\Policies\PolicyController;
use App\Http\Controllers\Reviews\ReviewController;
use App\Http\Controllers\Schedules\ScheduleController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication -- API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
        // Authentication
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/password/forget', 'passwordForget');
        Route::post('/password/reset', 'passwordReset');

        // Authorization
        Route::group(['middleware' => ['auth:api', 'auth.device']], function () {
            Route::post('/me', 'me');
            Route::post('/logout', 'logout');
            Route::post('/permissions', 'permissions');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Authorization -- API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:api', 'auth.device']], function () {

        // Branch Controller
        Route::apiResource('branches', BranchController::class);
        Route::post('branches/main/{branch}', [BranchController::class, 'main'])->name('branches.main');

        // Users Controller
        Route::apiResource('users', UserController::class);
        Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');

        // ClassRoom Controller
        Route::apiResource('classrooms', ClassRoomController::class);
        Route::post('classrooms/assign/subject/{classroom}', [ClassRoomController::class, 'assignSubject'])->name('classrooms.assignSubject');
        Route::delete('classrooms/delete/assign/subject/{classroom}', [ClassRoomController::class, 'deleteAssignSubject'])->name('classrooms.deleteAssignSubject');
        Route::get('classroom/subjects/{classroom}', [ClassRoomController::class, 'classSubjects'])->name('classrooms.classSubjects');

        // Parent Controller
        Route::apiResource('parents', ParentController::class);
        Route::post('parents/{parent}', [ParentController::class, 'update'])->name('parents.update');
        Route::get('parents/kids/{user}', [ParentController::class, 'parentKids'])->name('parents.parentKids');
        Route::get('parents/branches/{user}', [ParentController::class, 'parentBranches'])->name('parents.parentBranches');

        // Kid Controller
        Route::apiResource('kids', KidController::class);
        Route::post('kids/{kid}', [KidController::class, 'update'])->name('kids.update');
        Route::get('kids/birthday/comming', [KidController::class, 'birthday'])->name('kids.birthday');
        Route::get('kids/followup/{kid}', [KidController::class, 'followup'])->name('kids.followup');

        // Newsletter Controller
        Route::apiResource('newsletters', NewsletterController::class);
        Route::post('newsletters/{newsletter}', [NewsletterController::class, 'update'])->name('newsletters.update');
        Route::post('newsletters/like/{newsletter}', [NewsletterController::class, 'likeOrUnlike'])->name('newsletters.likeOrUnlike');

        // Subject Controller
        Route::apiResource('subjects', SubjectController::class);

        // Meal Controller
        Route::apiResource('meals', MealController::class);

        // Payment Bills Controller
        Route::apiResource('payemntbills', PaymentBillController::class);
        Route::post('payemntbills/{paymentBill}', [PaymentBillController::class, 'update'])->name('payemntbills.update');

        // Meal Controller
        Route::apiResource('kidpaymentbills', KidPaymentBillController::class);
        Route::post('kidpaymentbills/{kidpaymentbill}', [KidPaymentBillController::class, 'update'])->name('kidpaymentbills.update');

        // Followup Controller
        Route::apiResource('followups', FollowupController::class);
        Route::post('followups/attendance', [FollowupController::class, 'store'])->name('followups.store');
        Route::post('followups/{followUp}', [FollowupController::class, 'update'])->name('followups.update');
        Route::post('followups/media/{followUp}', [FollowupController::class, 'media'])->name('followups.media');

        // Nursery Controller
        Route::apiResource('nurseries', NurseryController::class);
        Route::post('nurseries/{nurseries}', [NurseryController::class, 'update'])->name('nurseries.update');
        Route::post('nurseries/status/{nursery}', [NurseryController::class, 'status'])->name('nurseries.status');

        // Schedules Controller
        Route::apiResource('schedules', ScheduleController::class);
        Route::post('schedules/{classRoom}', [ScheduleController::class, 'store'])->name('schedules.store');

        // Policies Controller
        Route::apiResource('policies', PolicyController::class);

        // Faqs Controller
        Route::apiResource('faqs', FaqController::class);

        // Gallery Controller
        Route::apiResource('galleries', GalleryController::class);

        // Gallery / Media
        Route::apiResource('gallery/medias', GalleryMediaController::class);
        Route::get('gallery/medias/downloadSingle/{media}', [GalleryMediaController::class, 'download'])->name('medias.download');
        Route::get('gallery/medias/download/zip/{gallery}', [GalleryMediaController::class, 'downloadMultiple'])->name('medias.downloadMultiple');

        // Dashboards
        Route::get('dashboards/nursery', [DashboardController::class, 'nursery']);
        Route::get('dashboard/mind', [DashboardController::class, 'mind']);

        // Reviews
        Route::apiResource('reviews', ReviewController::class);

        // Chats
        Route::apiResource('chats', ChatController::class);
        Route::apiResource('messages', MessageController::class);
        Route::post('chats/send/message', [ChatController::class, 'storeMessage'])->name('chats.storeMessage');

        // Notifications
        Route::apiResource('notifications', NotificationController::class);
    });
});


/*
|--------------------------------------------------------------------------
| Guest -- API Routes
|--------------------------------------------------------------------------
*/
// Guest
Route::apiResource('guest/nursery', GuestController::class);

// Blogs
Route::apiResource('blogs', BlogController::class);
Route::post('blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
