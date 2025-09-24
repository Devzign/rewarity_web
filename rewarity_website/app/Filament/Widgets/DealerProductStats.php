<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Collection;

class DealerProductStats extends BaseWidget
{
    protected function getCards(): array
    {
        $user = auth()->user();

        if (! $user || strcasecmp((string) $user->user_type, 'dealer') !== 0) {
            return [];
        }

        /** @var Collection<int, Product> $products */
        $products = Product::query()
            ->where('dealer_id', $user->id)
            ->get();

        $total = $products->count();
        $inStock = $products->filter(fn (Product $product): bool => $product->current_stock > $product->low_stock_alert)->count();
        $lowStock = $products->filter(fn (Product $product): bool => $product->current_stock > 0 && $product->current_stock <= $product->low_stock_alert)->count();
        $outOfStock = $products->filter(fn (Product $product): bool => $product->current_stock <= 0)->count();

        return [
            Card::make('Total Products', $total)
                ->icon('heroicon-o-archive-box')
                ->description('Items you manage'),
            Card::make('Healthy Stock', $inStock)
                ->icon('heroicon-o-check-circle')
                ->description('Above alert level')
                ->color('success'),
            Card::make('Low Stock', $lowStock)
                ->icon('heroicon-o-exclamation-triangle')
                ->description('Needs restock soon')
                ->color('warning'),
            Card::make('Out of Stock', $outOfStock)
                ->icon('heroicon-o-x-circle')
                ->description('No inventory left')
                ->color('danger'),
        ];
    }
}
