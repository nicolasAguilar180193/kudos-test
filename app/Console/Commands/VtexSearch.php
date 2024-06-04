<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductsService;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use App\Repositories\ProductsConsult\IProductsConsultRepository;


class VtexSearch extends Command implements PromptsForMissingInput
{
    protected $signature = '
        vtex:search 
        {input : El nombre del producto que quieres buscar} 
        {--last : Mostrar solo el ultimo resultado}
    ';

    protected $description = 'Buscar productos en VTEX API';


    public function __construct(
        private IProductsConsultRepository $productsConsultRepository,
        private ProductsService $productsService
    ) {
        parent::__construct();
    }


    public function handle()
    {        
        $user_input = $this->argument('input');

        $this->info('Realizando consulta...');

        try {
            $result_search_count = $this->productsService->getSearchCount($user_input);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->productsConsultRepository->store([
            'name' => $user_input, 
            'results' => $result_search_count
        ]);
    
        $this->showProductsConsultsTable();
    }


    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'input' => 'Ingresa el nombre del producto que quieres buscar',
        ];
    }


    protected function showProductsConsultsTable()
    {
        $headers = ['id', 'name', 'results', 'created_at', 'updated_at'];

        if($this->option('last')) {
            $consults = $this->productsConsultRepository
                ->getLastByName($this->argument('input'));
        } else {
            $consults = $this->productsConsultRepository->getAll();
        }

        $this->table($headers, $consults->toArray());
    }
}
