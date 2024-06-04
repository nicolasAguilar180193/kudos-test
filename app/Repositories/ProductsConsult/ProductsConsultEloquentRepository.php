<?php 

namespace App\Repositories\ProductsConsult;

use App\Models\ProductsConsult;
use Illuminate\Database\Eloquent\Collection;

class ProductsConsultEloquentRepository implements IProductsConsultRepository
{
    public function store(array $data): void
    {
        ProductsConsult::create([
            'name' => $data['name'],
            'results' => $data['results'],
        ]);
    }

    public function getAll(): Collection
    {
        return ProductsConsult::all();
    }

    public function getLastByName(string $name): Collection
    {
        return ProductsConsult::orderBy('id', 'desc')
            ->where('name', $name)
            ->take(1)->get();
    }
}
