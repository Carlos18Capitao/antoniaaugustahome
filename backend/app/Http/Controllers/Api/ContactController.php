<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __construct(
        private readonly LeadService $leadService
    ) {}

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $lead = $this->leadService->create($request->validated());

        return response()->json([
            'message' => 'Mensagem enviada com sucesso. Entraremos em contacto brevemente.',
            'data' => $lead,
        ], 201);
    }
}
