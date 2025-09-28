<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'dealer_id' => $request->integer('dealer_id'),
            'search' => $request->string('search')->toString(),
            'date_from' => $request->date('date_from'),
            'date_to' => $request->date('date_to'),
        ];

        /** @var LengthAwarePaginator $purchases */
        $purchases = Purchase::with(['product', 'dealer'])
            ->when($filters['dealer_id'], fn (Builder $query) => $query->where('dealer_id', $filters['dealer_id']))
            ->when($filters['search'], function (Builder $query) use ($filters): void {
                $query->where(function (Builder $subQuery) use ($filters): void {
                    $subQuery->where('seller_name', 'like', "%{$filters['search']}%")
                        ->orWhereHas('product', fn (Builder $productQuery) => $productQuery->where('product_name', 'like', "%{$filters['search']}%"));
                });
            })
            ->when($filters['date_from'], fn (Builder $query) => $query->whereDate('purchase_date', '>=', $filters['date_from']))
            ->when($filters['date_to'], fn (Builder $query) => $query->whereDate('purchase_date', '<=', $filters['date_to']))
            ->orderByDesc('purchase_date')
            ->paginate(15)
            ->withQueryString();

        $dealers = User::query()
            ->whereRaw('LOWER(user_type) = ?', ['dealer'])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.purchases.index', [
            'purchases' => $purchases,
            'dealers' => $dealers,
            'filters' => $filters,
            'pageHeading' => 'Purchases',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('admin.purchases.show', [
            'purchase' => $purchase->loadMissing(['product', 'dealer']),
            'pageHeading' => 'Purchase Details',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        abort(404);
    }
}
