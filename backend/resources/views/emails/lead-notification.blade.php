<x-mail::message>
# Novo Contacto Recebido

**Nome:** {{ $lead->name }}
**Email:** {{ $lead->email }}
@if($lead->phone)
**Telefone:** {{ $lead->phone }}
@endif
@if($lead->subject)
**Assunto:** {{ $lead->subject }}
@endif

**Mensagem:**
{{ $lead->message }}

@if($lead->product)
**Produto de Interesse:** {{ $lead->product->name }}
@endif

**Fonte:** {{ $lead->source }}
**Data:** {{ $lead->created_at->format('d/m/Y H:i') }}

<x-mail::button :url="config('app.url') . '/admin/leads'">
Ver no Painel
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
