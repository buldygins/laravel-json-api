<?php

namespace App\Console\Commands;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class UpdateDBFromJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json-files:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read data from categories.json and products.json and update tables in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categories_path =  storage_path() . '\\categories.json';
        $category_created = 0;
        $category_skipped = 0;
        if (!file_exists($categories_path)) {
            $this->error('Нет файла с категориями!');
        } else {
            $categories = json_decode(file_get_contents($categories_path), true);
            foreach ($categories as $category) {
                $validated = Validator::make($category, (new CategoryRequest())->rules())->validate();
                try {
                    Category::create($validated);
                } catch (QueryException $e) {
                    $this->error($e->errorInfo[2]);
                    $category_skipped++;
                    continue;
                }
                $category_created++;
            }
        }

        $products_path = storage_path() . '\\products.json';
        $product_created = 0;
        $product_skipped = 0;
        if (!file_exists($products_path)) {
            $this->error('Нет файла с продктами!');
        } else {
            $products = json_decode(file_get_contents($products_path), true);
            foreach ($products as $product) {
                $validated = Validator::make($product, (new ProductRequest())->rules())->validate();
                try {
                    Product::create($validated);
                } catch (QueryException $e) {
                    $this->error($e->errorInfo[2]);
                    $product_skipped++;
                    continue;
                }
                $product_created++;
            }
        }

        $this->table(['', 'Категории', 'Продукты'],
            [
                ['Создано:', $category_created, $product_created],
                ['Пропущено:', $category_skipped, $product_skipped]
            ]);
    }
}
