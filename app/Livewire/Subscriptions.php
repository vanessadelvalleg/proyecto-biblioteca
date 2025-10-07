<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Subscriptions extends Component
{
    use WithPagination;

    public $paginationTheme = 'tailwind';

    public $subscription_id;
    public $plan_name;
    public $status;
    public $starts_at;
    public $ends_at;
    public $stripe_subscription_id;

    public $isEdit = false;
    public $perPage = 5;

    public function mount()
    {
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.subscriptions', [
            'subscriptions' => $subscriptions
        ]);
    }

    public function resetFields()
    {
        $this->subscription_id = null;
        $this->plan_name = '';
        $this->status = 'active';
        $this->starts_at = '';
        $this->ends_at = '';
        $this->stripe_subscription_id = '';
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'plan_name' => 'required|in:basic,premium',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);


        Subscription::create([
            'user_id' => Auth::id(),
            'plan_name' => $this->plan_name,
            'status' => 'active',
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'stripe_subscription_id' => $this->stripe_subscription_id,
        ]);

        session()->flash('message', 'Suscripción creada correctamente.');
        $this->resetFields();
    }

    public function cancel($id)
    {
        $subscription = Subscription::findOrFail($id);

        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Acción no permitida');
        }

        $subscription->status = 'cancelled';
        $subscription->save();

        session()->flash('message', 'Suscripción cancelada correctamente.');
    }

    public function simulateStripeWebhook($id, $newStatus)
    {
        $subscription = Subscription::findOrFail($id);

        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Acción no permitida');
        }

        $subscription->status = $newStatus;
        $subscription->save();

        session()->flash('message', "Webhook simulado: la suscripción ahora está '$newStatus'.");
    }

    public function statusColor($status)
    {
        return match($status) {
            'active' => 'bg-green-200 text-green-800',
            'cancelled' => 'bg-red-200 text-red-800',
            'past_due' => 'bg-yellow-200 text-yellow-800',
            default => 'bg-gray-200 text-gray-800',
        };
    }
}




