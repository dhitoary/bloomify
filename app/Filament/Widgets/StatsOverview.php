<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::count())
                ->description('Produk dalam katalog')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Kategori', Category::count())
                ->description('Kategori produk')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info'),

            Stat::make('Stok Total', Product::sum('stock'))
                ->description('Unit tersedia')
                ->descriptionIcon('heroicon-m-inbox-stack')
                ->color('warning'),

            Stat::make('Total Pesanan', Order::count())
                ->description('Semua pesanan')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
        ];
    }
}
