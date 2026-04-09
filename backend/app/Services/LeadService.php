<?php

namespace App\Services;

use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

class LeadService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Lead::with('product')->recent();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): Lead
    {
        return Lead::with('product')->findOrFail($id);
    }

    public function create(array $data): Lead
    {
        $lead = Lead::create($data);

        // Send notification email
        try {
            Mail::to(config('mail.from.address'))->send(new NewLeadNotification($lead));
        } catch (\Exception $e) {
            report($e);
        }

        return $lead;
    }

    public function updateStatus(int $id, string $status, ?string $notes = null): Lead
    {
        $lead = Lead::findOrFail($id);
        $lead->update([
            'status' => $status,
            'notes' => $notes ?? $lead->notes,
        ]);

        return $lead->fresh();
    }

    public function delete(int $id): void
    {
        Lead::findOrFail($id)->delete();
    }

    public function getNewCount(): int
    {
        return Lead::new()->count();
    }
}
