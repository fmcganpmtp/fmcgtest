<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Build extends Command
{
    protected $signature = 'build';
 
    protected $description = 'Create Build Operations';

    public function __construct()
    {
        parent::__construct();
    }
 
    public function handle()
    {
        $view = view('build/template/config-android')->render();
        Storage::disk('base')->put('resources/views/build/cordova-android/config.xml' , $view);
        
        $view = view('build/template/config-ios')->render();
        Storage::disk('base')->put('resources/views/build/cordova-ios/config.xml' , $view);

        $view = view('build/template/app-view-android')->render();
        Storage::disk('base')->put('resources/views/build/cordova-android/www/index.html' , $view);
       
        $view = view('build/template/app-view-ios')->render();
        Storage::disk('base')->put('resources/views/build/cordova-ios/www/index.html' , $view);

        $view = view('build/template/theme')->render();
        Storage::disk('base')->put('resources/views/build/theme.scss' , $view);
    }
}
