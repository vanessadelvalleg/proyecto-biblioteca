<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class Books extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $title, $author, $isbn, $published_year, $available_copies = 1, $total_copies = 1, $book_id;
    public $isEdit = false;
    public $search = '';
    public $perPage = 5;

    public function mount()
    {
       if (!Auth::check()) {
            abort(403, 'Acceso no autorizado');
        }
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
    $cacheKey = 'books_list_' . md5($this->search . '_' . $this->page);

    $books = Cache::remember($cacheKey, now()->addMinutes(15), function () {
        return Book::query()
            ->where(function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                      ->orWhere('author', 'like', "%{$this->search}%")
                      ->orWhere('isbn', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
    });

    return view('livewire.books', ['books' => $books]);
    }

    public function resetFields()
    {
        $this->book_id = null;
        $this->title = '';
        $this->author = '';
        $this->isbn = '';
        $this->published_year = '';
        $this->available_copies = 1;
        $this->total_copies = 1;
        $this->isEdit = false;
    }

    public function store()
    {
        if (!Auth::check()) abort(403, 'Acción no permitida');

        $this->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'isbn'             => 'required|string|max:255|unique:books,isbn,' . $this->book_id,
            'published_year'   => 'nullable|integer',
            'available_copies' => 'nullable|integer|min:0',
            'total_copies'     => 'nullable|integer|min:0',
        ]);

        Book::updateOrCreate(
            ['id' => $this->book_id],
            [
                'title'            => $this->title,
                'author'           => $this->author,
                'isbn'             => $this->isbn,
                'published_year'   => $this->published_year,
                'available_copies' => $this->available_copies,
                'total_copies'     => $this->total_copies,
            ]
        );
        Cache::flush();
        session()->flash('message', $this->book_id ? 'Libro actualizado correctamente.' : 'Libro creado correctamente.');

        $this->resetFields();
        $this->resetPage();
    }

    public function edit($id)
    {
        if (!Auth::check()) abort(403, 'Acción no permitida');

        $book = Book::findOrFail($id);
        $this->book_id = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->isbn = $book->isbn;
        $this->published_year = $book->published_year;
        $this->available_copies = $book->available_copies;
        $this->total_copies = $book->total_copies;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        if (!Auth::check()) abort(403, 'Acción no permitida');

        Book::find($id)?->delete();
                Cache::flush();
        session()->flash('message', 'Libro eliminado correctamente.');
        $this->resetPage();
    }
}

