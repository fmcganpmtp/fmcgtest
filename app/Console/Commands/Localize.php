<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class Localize extends Command
{
    protected $signature = 'localize';
 
    protected $description = 'Create Localize Operations';

    public function __construct()
    {
        parent::__construct();
    }
 
    public function handle()
    {
        $data = [];

        $files = Storage::disk('base')->allFiles('resources/views/mobile');
 
        foreach($files as $file){
            $content = Storage::disk('base')->get($file);

            $data = array_merge ( $data, findBetween($content, '__(\'', '\')'));

            $data = array_merge ( $data, findBetween($content, '__( \'', '\' )'));

            $data = array_merge ( $data, findBetween($content, '__( \'', '\')'));

            $data = array_merge ( $data, findBetween($content, '__(\'', '\' )'));

            $data = array_unique ($data );
        }

        $content = Storage::disk('base')->get('app/Http/Controllers/MobileController.php');
        $data = array_unique (array_merge ( $data, findBetween($content, '__(\'', '\')') ));

        foreach($data as $text){
            $this->info( json_encode($text) );
        }
 

    //    $data = Storage::disk('base')->get('resources/lang/ml.json');
       

    //    foreach(json_decode ($data) as $key => $value){
    //     $this->info( $key );
    //    }

    }
}
