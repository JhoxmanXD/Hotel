<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentmethods = PaymentMethod::latest()->paginate(15);
        return view('paymentmethods.index', compact('paymentmethods'));
    }

    public function create()
    {
        return view('paymentmethods.create');
    }

    public function store(PaymentMethodRequest $request)
    {
        $data = $request->validated();
        PaymentMethod::create($data);

        return redirect()
            ->route('paymentmethods.index')
            ->with('success', 'Método de pago registrado correctamente.');
    }

    public function show(PaymentMethod $paymentmethod)
    {
        return view('paymentmethods.show', compact('paymentmethod'));
    }

    public function edit(PaymentMethod $paymentmethod)
    {
        return view('paymentmethods.edit', compact('paymentmethod'));
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $paymentmethod)
    {
        $validated = $request->validated();
        $paymentmethod->update($validated);

        return redirect()
            ->route('paymentmethods.index')
            ->with('success','Método de pago actualizado correctamente.');
    }

    public function destroy(PaymentMethod $paymentmethod)
    {
        $paymentmethod->delete();

        return redirect()
            ->route('paymentmethods.index')
            ->with('success','Método de pago eliminado.');
    }
}