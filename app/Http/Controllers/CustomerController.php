<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = auth()->user()->customers()
            ->withCount('invoices')
            ->latest()
            ->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function show(\App\Models\Customer $customer)
    {
        if ($customer->user_id !== auth()->id()) {
            abort(403);
        }
        
        $customer->load(['invoices' => function($query) {
            $query->latest();
        }]);
        
        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $customer = auth()->user()->customers()->create($validated);

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'customer' => $customer,
                'message' => 'Customer created successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Customer created successfully.');
    }

    public function update(Request $request, \App\Models\Customer $customer)
    {
        if ($customer->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->back()->with('success', 'Customer updated successfully.');
    }

    public function destroy(\App\Models\Customer $customer)
    {
        if ($customer->user_id !== auth()->id()) {
            abort(403);
        }

        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }
}
