<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LibraryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_book_successfully()
    {
        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    /** @test */
    public function user_cannot_loan_more_than_allowed_by_plan()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('dashboard'))->assertStatus(200);
       

        // Simular autenticación
        $this->actingAs($user);

        // Crear suscripción activa básica (límite 2)
        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_name' => 'basic',
            'status' => 'active',
        ]);

        $books = Book::factory()->count(3)->create();

        // Crear préstamos hasta el límite
        foreach ($books->take(2) as $book) {
            Loan::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'loaned_at' => now(),
                'due_date' => now()->addDays(14),
            ]);
        }

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Has alcanzado el límite de préstamos permitidos por tu plan");

        // Intentar crear un préstamo que exceda el límite
        $this->attemptLoan($books[2]->id);
    }

    /** @test */
    public function it_creates_a_subscription_successfully()
    {
        $subscription = Subscription::factory()->create();

        $this->assertDatabaseHas('subscriptions', ['id' => $subscription->id]);
    }

    /** @test */
    public function it_can_change_subscription_status()
    {
        $subscription = Subscription::factory()->create(['status' => 'active']);

        $subscription->update(['status' => 'cancelled']);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function user_has_active_subscription()
    {
        $user = User::factory()->create();
         $this->actingAs($user)->get(route('dashboard'))->assertStatus(200);

        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $this->assertTrue($user->subscriptions()->where('status', 'active')->exists());
    }

    /**
     * Simula la lógica de préstamo con validaciones de plan y disponibilidad.
     * Este método debería estar en un servicio o controlador en producción.
     */
    protected function attemptLoan($bookId)
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription();

        if (!$subscription) {
            throw new \Exception("No tienes una suscripción activa para hacer préstamos");
        }

        $maxLoans = $subscription->plan_name === 'premium' ? 5 : 2;

        $currentLoans = Loan::where('user_id', $user->id)
                            ->whereNull('returned_at')
                            ->count();

        if ($currentLoans >= $maxLoans) {
            throw new \Exception("Has alcanzado el límite de préstamos permitidos por tu plan");
        }

        $bookLoaned = Loan::where('book_id', $bookId)
                          ->whereNull('returned_at')
                          ->exists();

        if ($bookLoaned) {
            throw new \Exception("El libro ya está prestado");
        }

        Loan::create([
            'user_id' => $user->id,
            'book_id' => $bookId,
            'loaned_at' => now(),
            'due_date' => now()->addDays(14),
        ]);
    }
}