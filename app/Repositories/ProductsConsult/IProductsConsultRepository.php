<?php 

namespace App\Repositories\ProductsConsult;

use Illuminate\Support\Collection;

interface IProductsConsultRepository
{
    public function store(array $data): void;

    public function getAll(): Collection;

    public function getLastByName(string $name): Collection;
}