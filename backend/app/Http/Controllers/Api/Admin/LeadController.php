<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct(
        private readonly LeadService $leadService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'search']);
        $leads = $this->leadService->list($filters, $request->integer('per_page', 15));

        return response()->json($leads);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->leadService->find($id),
        ]);
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:new,contacted,converted,archived',
            'notes' => 'nullable|string|max:5000',
        ]);

        $lead = $this->leadService->updateStatus(
            $id,
            $request->input('status'),
            $request->input('notes')
        );

        return response()->json([
            'message' => 'Estado do contacto atualizado.',
            'data' => $lead,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->leadService->delete($id);
        return response()->json(['message' => 'Contacto eliminado com sucesso.']);
    }
}
