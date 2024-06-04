<?php

namespace App\Services;

use App\Exceptions\VtexApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductsService
{
    private const API_URL = 'https://newsport.vtexcommercestable.com.br/api/catalog_system/pub/products/';

    private const MAX_PAGE_SIZE = 49;

    public function __construct(
        private int $page_size = self::MAX_PAGE_SIZE
    ) {
        if ($this->page_size > self::MAX_PAGE_SIZE || $this->page_size < 1) {
            $this->page_size = self::MAX_PAGE_SIZE;
        }
    }

    public function getSearchCount(string $input): int
    {
        $total = 0;

        $from = 0;
        
        do {
            $response = Http::get(self::API_URL . 'search/' . $input, [
                '_from' => $from,
                '_to' => $from + $this->page_size,
            ]);
            
            if($response->failed()) {
                Log::error('VTEX API Error: ' . $response->body());
                throw new VtexApiException();
            }

            $actual_count = $response->collect()->count();
            
            $total += $actual_count;
            
            $from += $this->page_size + 1;

        } while ($response->status() === 206);

        return $total;
    }

}