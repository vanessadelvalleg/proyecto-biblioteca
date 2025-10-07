<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Books;
use App\Livewire\Loans;
use App\Livewire\Subscriptions;

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');



Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/books', Books::class)->name('books.index');
    Route::get('/subscriptions', Subscriptions::class)->name('subscriptions.index');
    Route::get('/loans', Loans::class)->name('loans.index');

    Route::post('/logout', Login::class)->name('logout');

});