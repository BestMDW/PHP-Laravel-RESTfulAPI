<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $userQuantity = 200;
    protected $categoriesQuantity = 30;
    protected $productsQuantity = 1000;
    protected $transactionsQuantity = 1000;

    /******************************************************************************************************************/

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        factory(User::class, $this->userQuantity)->create();

        factory(Category::class, $this->categoriesQuantity)->create();

        factory(Product::class, $this->productsQuantity)->create()->each(function($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });

        factory(Transaction::class, $this->transactionsQuantity)->create();
    }
}
