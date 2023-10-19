<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\TrainingRequested\Create as TrainingRequestedCreate;
use App\Http\Livewire\TrainingRequested\Index as TrainingRequestedIndex;
use App\Http\Livewire\TrainingRequested\Show as TrainingRequestedShow;
use App\Http\Livewire\TrainingRequested\View\Fmlds006 as TrainingRequestedLDS006;
use App\Http\Livewire\TrainingRequested\View\Fmlds008 as TrainingRequestedLDS008;
use App\Http\Livewire\TrainingRequested\View\Fmlds009 as TrainingRequestedLDS009;
use App\Http\Livewire\TrainingRequested\ApprovedIndex as TrainingRequestedApprovedIndex;
use App\Http\Livewire\TrainingRequested\ApprovedShow as TrainingRequestedApprovedShow;

use App\Http\Livewire\DocumentRequested\Create as DocumentRequestedCreate;
use App\Http\Livewire\DocumentRequested\Index as DocumentRequestedIndex;
use App\Http\Livewire\DocumentRequested\Show as DocumentRequestedShow;

use App\Http\Livewire\Document\Index as DocumentIndex;
use App\Http\Livewire\Document\Show as DocumentShow;

use App\Http\Livewire\Record\Index as RecordIndex;
use App\Http\Livewire\Record\Show as RecordShow;

use App\Http\Livewire\User\Create as UserCreate;
use App\Http\Livewire\User\Index as UserIndex;
use App\Http\Livewire\User\Show as UserShow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->name('home');
Route::view('/ma', 'home')->name('ma');
// Route::view('/', 'close')->name('home');

Route::middleware('guest')->group(function () {

    Route::get('login', Login::class)
    ->name('login');

    // Route::get('register', Register::class)
    // ->name('register');
});

Route::get('password/reset', Email::class)
->name('password.request');

Route::get('password/reset/{token}', Reset::class)
->name('password.reset');

Route::middleware('auth')->group(function () {
    // Route::view('/', 'dashboard')->name('dashboard');

    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::get('logout', LogoutController::class)
        ->name('logout');
});


Route::middleware('auth')->group(function () {

    // training
    Route::name('training.')->prefix('training')->group(function (){
        // all training approved
        Route::get('/', TrainingRequestedApprovedIndex::class )->name('index');

        Route::name('request.')->prefix('request')->group(function (){
            // create new training request
            Route::get('create', TrainingRequestedCreate::class)->name('create');
            Route::get('edit/{id}', TrainingRequestedCreate::class)->name('edit');
            // edit training request

            // show all training request
            Route::get('index', TrainingRequestedIndex::class)->name('index');
            // show all my training request
            Route::get('index/{id}', TrainingRequestedIndex::class)->name('myIndex');

            // show single training request
            Route::get('show/{id}', TrainingRequestedShow::class)->name('show');

            // show 006 008 009
            Route::get('show/lds-006/{id}', TrainingRequestedLDS006::class)->name('show-006');
            Route::get('show/lds-008/{id}', TrainingRequestedLDS008::class)->name('show-008');
            Route::get('show/lds-009/{id}', TrainingRequestedLDS009::class)->name('show-009');
        });

        // show single training qpproved
        Route::get('/show/{id}', TrainingRequestedApprovedShow::class )->name('show');
    });


    // document
    Route::name('document.')->prefix('document')->group(function (){

        // all training approved
        Route::get('/', DocumentIndex::class )->name('index');

        Route::name('request.')->prefix('request')->group(function (){

            // create new training request
            Route::get('create', DocumentRequestedCreate::class)->name('create');
            Route::get('edit/{id}', DocumentRequestedCreate::class)->name('edit');
            // edit training request


            // show all training request
            Route::get('index', DocumentRequestedIndex::class)->name('index');
            // show all my training request
            Route::get('index/{id}', DocumentRequestedIndex::class)->name('myIndex');

            // show single training request
            Route::get('show/{id}', DocumentRequestedShow::class)->name('show');
        });

        // show single training qpproved
        Route::get('/show/{id}', DocumentShow::class )->name('show');
    });

    // document
    Route::name('record.')->prefix('record')->group(function (){
        // all training approved
        Route::get('/', RecordIndex::class )->name('index');
        // show single training qpproved
        Route::get('/show/{id}', RecordShow::class )->name('show');
    });


    Route::name('user.')->prefix('user')->group(function (){
        // all training approved
        Route::get('/', UserIndex::class )->name('index');
        // show single training qpproved
        Route::get('/create', UserCreate::class )->name('create');
        // show single training qpproved
        Route::get('/edit/{id}', UserCreate::class )->name('edit');
        // show single training qpproved
        Route::get('/{id}', UserShow::class )->name('show');
    });

    
    Route::name('admin.')->prefix('admin')->group(function (){
        Route::get('/toggle', function(){
            $permission=Auth::user()->permissions->firstWhere('parmission_name','admin');
            $allowance=$permission->allowance;
            $permission->allowance = !$allowance;
            // dd($allowance,$permission);
            $permission->save();
            return redirect()->back();
        } )->name('toggle');
    });
});
