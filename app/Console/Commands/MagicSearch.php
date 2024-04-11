<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Product;

class MagicSearch extends Command
{
    protected $signature = 'magic-search';
 
    protected $description = 'Create Magic Search Operations';

    public function __construct()
    {
        parent::__construct();
    }
 
    public function handle()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

       $products =  Product::all();
 
       foreach($products as $product){

            $keyword = $product->name;
            
            if($product->category && $product->category->name){
                $keyword .= ' '.  Str::singular($product->category->name);
            }
             
            if($product->brand && $product->brand->name){
                $keyword .= ' '. $product->brand->name;
            }
 
            $combinations = new \Combinations( array_unique ( explode(' ', $keyword) ) );

            $product->update([
                'magic_search' => $combinations->generate()
            ]);
       }

       $this->info( 'Done' );
    }
}
