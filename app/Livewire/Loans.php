<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Loan;
use App\Models\Book;
use Carbon\Carbon;
use App\Events\LibroPrestado;

use Illuminate\Support\Facades\Auth;
class Loans extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $loan_id, $book_id, $loaned_at, $due_date, $returned_at;
    public $isEdit = false;
    public $search = '';
    public $perPage = 5;
    public $books;

    public function mount()
    {
        $this->books = Book::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $loans = Loan::with('book')
            ->where('user_id', Auth::id())
            ->whereHas('book', function ($q) {
                $q->where('title', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.loans', ['loans' => $loans]);
    }

    public function resetFields()
    {
        $this->loan_id = null;
        $this->book_id = '';
        $this->loaned_at = '';
        $this->due_date = '';
        $this->returned_at = '';
        $this->isEdit = false;
    }

public function store()
{
    if (!Auth::check()) {
        return abort(403, 'Acción no permitida');
    }

    $this->validate([
        'book_id' => 'required|exists:books,id',
        'loaned_at' => 'required|date',
    ]);

    $user = Auth::user();

  
    $subscription = $user->subscriptions()->where('status', 'active')->latest('starts_at')->first();

 
    $maxLoans = ($subscription && $subscription->plan_name === 'premium') ? 5 : 2;


    $activeLoans = Loan::where('user_id', $user->id)
                        ->whereNull('returned_at')
                        ->count();

    if ($activeLoans >= $maxLoans) {
        session()->flash('error', "Has alcanzado el límite de préstamos de tu plan ($maxLoans libros).");
        return;
    }


    $bookLoaned = Loan::where('book_id', $this->book_id)
                        ->whereNull('returned_at')
                        ->exists();

    if ($bookLoaned) {
        session()->flash('error', 'Este libro ya está prestado a otro usuario.');
        return;
    }


    $loanDate = Carbon::parse($this->loaned_at);
    $dueDate = $loanDate->copy()->addDays(14);

    $loan =Loan::updateOrCreate(
        ['id' => $this->loan_id],
        [
            'user_id' => $user->id,
            'book_id' => $this->book_id,
            'loaned_at' => $loanDate,
            'due_date' => $dueDate,
            'returned_at' => $this->returned_at ?: null,
        ]
    );

    event(new LibroPrestado($loan));


    session()->flash('message', $this->loan_id ? 'Préstamo actualizado correctamente.' : 'Préstamo creado correctamente.');

    $this->resetFields();
}


    public function edit($id)
    {
        $loan = Loan::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $this->loan_id = $loan->id;
        $this->book_id = $loan->book_id;
        $this->loaned_at = $loan->loaned_at->format('Y-m-d');
        $this->due_date = $loan->due_date->format('Y-m-d');
        $this->returned_at = $loan->returned_at ? $loan->returned_at->format('Y-m-d') : '';
        $this->isEdit = true;
    }

    public function delete($id)
    {
        $loan = Loan::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $loan->delete();

        session()->flash('message', 'Préstamo eliminado correctamente.');
        $this->resetPage();
    }

    public function markReturned($id)
    {
        $loan = Loan::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $loan->returned_at = now();
        $loan->save();

        session()->flash('message', 'Préstamo marcado como devuelto');
    }


}

