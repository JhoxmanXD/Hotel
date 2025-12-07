<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\Registration;
use App\Models\PaymentMethod;

class InvoiceController extends Controller
{
    public function index()
    {
        // Cargamos relaciones para mostrarlas en tabla
        $invoices = Invoice::with(['registration.client', 'registration.room', 'paymentMethod'])
            ->latest()
            ->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        // Para el select de reservation/registration y métodos de pago
        $registrations  = Registration::with(['client','room.roomType'])
            ->orderByDesc('id')
            ->get();

        $paymentmethods = PaymentMethod::orderBy('name')->get();

        return view('invoices.create', compact('registrations','paymentmethods'));
    }

    public function store(InvoiceRequest $request)
    {
        $data = $request->validated();
        Invoice::create($data);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Factura registrada correctamente.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['registration.client','registration.room.roomType','paymentMethod']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $registrations  = Registration::with(['client','room.roomType'])
            ->orderByDesc('id')
            ->get();
        $paymentmethods = PaymentMethod::orderBy('name')->get();

        return view('invoices.edit', compact('invoice','registrations','paymentmethods'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();
        $invoice->update($data);

        return redirect()
            ->route('invoices.index')
            ->with('success','Factura actualizada correctamente.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success','Factura eliminada.');
    }
}