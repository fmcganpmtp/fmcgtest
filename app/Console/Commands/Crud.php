<?php

namespace App\Console\Commands;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Crud extends Command
{
    protected $signature = 'make:crud {input} {--method=traditional}';
 
    protected $description = 'Create CRUD Operations';

    public function __construct()
    {
        parent::__construct();
    }
 
    public function handle()
    {

        $input  = $this->argument('input');
        $method = $this->option('method');
 
        if($method != 'ajax') {
            $method = 'traditional';
        }
        
        $response = $this->generate($input, $method);
        
        $this->info(str_pad('', 140 , ' '));
        $this->info('CRUD Created Successfully.');
        $this->info(str_pad('', 140 , ' '));
        $this->comment( $response );     
        $this->info(str_pad('', 140 , ' '));
    }

    public static function generate($input, $method)
    {
        $input = Str::of($input)->replace('-', ' ')->replace('_', ' ');

        $singular = Str::singular(ucwords($input));
        $plural = Str::plural(ucwords($input));
        $class = Str::of( ucwords($singular) )->replace(' ', '');
        $table = Str::of( Str::lower($plural) )->replace(' ', '_');
        $variable = Str::of( Str::camel($singular) )->replace(' ', '');
        $slug = Str::of( Str::lower($singular) )->replace(' ', '-');
        $route = Str::of( Str::lower($singular) )->replace(' ', '.');
        $columns = Crud::getColumns($table);
        $items = Crud::getItems($table, $columns);
        $references = Crud::getReferences($table);
 
        $model = view('backend/crud/' . $method . '/model', compact('singular', 'plural', 'class', 'table', 'variable', 'slug', 'route', 'columns', 'items', 'references'))->render();        
        $model = '<?php ' . PHP_EOL . $model;
        $model = preg_replace("/[\r\n]+/", "\n", $model);
        Storage::disk('base')->put('app/' . $class . '.php', $model);
        
        $controller = view('backend/crud/' . $method . '/controller', compact('singular', 'plural', 'class', 'table', 'variable', 'slug', 'route', 'columns', 'items', 'references'))->render();
        $controller = '<?php ' . PHP_EOL . $controller;
        $controller = preg_replace("/[\r\n]+/", "\n", $controller);
        Storage::disk('base')->put('app/Http/Controllers/' . $class . 'Controller.php', $controller);
 
        $files = Storage::disk('base')->allFiles('resources/views/backend/crud/' . $method . '/view');
 
        foreach($files as $file){
 
            $view = view(Str::of( $file )->replace('resources/views/', '')->replace('.blade.php', ''), compact('singular', 'plural', 'class', 'table', 'variable', 'slug', 'route', 'columns', 'items', 'references'))->render();

            $view = Str::of($view)->replace('___', '@')->replace('__[', '{{')->replace(']__', '}}');    
 
            $view = preg_replace("/[\r\n]+/", "\n", $view);

            Storage::disk('base')->put('resources/views/backend/' . $slug . '/' . Str::of( $file )->replace('resources/views/backend/crud/' . $method . '/view/', ''), $view);
        }
 
        $routes = view('backend/crud/' . $method . '/route', compact('singular', 'plural', 'class', 'table', 'variable', 'slug', 'route', 'columns', 'items', 'references'))->render();

        $routes = Str::of($routes)->replace('__[', '{')->replace(']__', '}');    

        return $routes;
 
    }

    public static function getLabel($name)
    {   
        return ucwords( str_replace('_', ' ', $name ) );
    }

    public static function getModel($table)
    {   
        return Str::ucfirst( Str::singular(  Str::camel( $table ) ) );
    }
    
    public static function getColumns($table)
    {   
        $items = DB::select(DB::raw('SHOW COLUMNS FROM ' . $table));
 
        $column = [];
        foreach($items as $item){
            $data = Crud::filterColumn($item);
            if($data){
                $column[] = $data;
            }
        }

        return $column;
    }
    
    public static function filterColumn($item)
    {   

        foreach(['INT', 'BIGINT', 'TINYINT', 'SMALLINT', 'MEDIUMINT'] as $key => $value){
            if (strpos(strtoupper($item->Type), $value) !== false) {
                return [
                    'label' => Crud::getLabel( $item->Field ),
                    'name' =>  $item->Field,
                    'type' => 'integer', 
                    'length' => null, 
                    'required' => $item->Null == 'NO' ? true : false
                ];
            }
        }

        foreach(['VARCHAR', 'CHAR'] as $key => $value){
            if (strpos(strtoupper($item->Type), $value) !== false) {
                $match = false;
                $length = null; 
                preg_match('#\((.*?)\)#', $item->Type, $match);
                if($match){
                    $length = $match[1] ?? null;
                }

                $type = 'text';

                if (strpos($item->Field, 'email') !== false) {
                    $type = 'email';
                }elseif(strpos($item->Field, 'mobile') !== false){
                    $type = 'mobile';
                }

                return [
                    'label' => Crud::getLabel( $item->Field ),
                    'name' =>  $item->Field,
                    'type' =>  $type, 
                    'length' => $length, 
                    'required' => $item->Null == 'NO' ? true : false
                ];
            }
        }


        foreach(['DECIMAL', 'FLOAT', 'DOUBLE'] as $key => $value){
            if (strpos(strtoupper($item->Type), $value) !== false) {
                $match = false;
                $length = null; 
                preg_match('#\((.*?)\)#', $item->Type, $match);
                if($match){
                    $length = $match[1] ?? null;
                }

                $type = 'decimal';

                return [
                    'label' => Crud::getLabel( $item->Field ),
                    'name' =>  $item->Field,
                    'type' =>  $type, 
                    'length' => $length, 
                    'required' => $item->Null == 'NO' ? true : false
                ];
            }
        }

        foreach(['TEXT', 'LONGTEXT', 'MEDIUMTEXT', 'TINYTEXT'] as $key => $value){
            if (strpos(strtoupper($item->Type), $value) !== false) {
                $type = 'textarea';

                if (strpos($item->Field, 'image') !== false) {
                    $type = 'image';
                }

                return [
                    'label' => Crud::getLabel( $item->Field ),
                    'name' =>  $item->Field,
                    'type' =>  $type, 
                    'length' => null, 
                    'required' => $item->Null == 'NO' ? true : false
                ];
            }
        }

        return false;
    }

    public static function getItems($table, $columns)
    {   
        $references =  DB::table( 'INFORMATION_SCHEMA.KEY_COLUMN_USAGE' )
        ->select(['COLUMN_NAME'])
        ->where('REFERENCED_TABLE_SCHEMA', env('DB_DATABASE'))
        ->where('TABLE_NAME', $table)
        ->get()
        ->toArray();

        $relations = [];
        foreach($references as $reference){ 
            $relations[] =  $reference->COLUMN_NAME;
        }

        $items = [];
        foreach($columns as $column){ 
            if(!in_array($column['name'], $relations)){
                $items[] =  $column;
            }
        }

        return $items;
    }

    public static function getReferences($table)
    {   
        $references =  DB::table( 'INFORMATION_SCHEMA.KEY_COLUMN_USAGE' )
        ->select(['COLUMN_NAME', 'REFERENCED_TABLE_NAME','REFERENCED_COLUMN_NAME'])
        ->where('REFERENCED_TABLE_SCHEMA', env('DB_DATABASE'))
        ->where('TABLE_NAME', $table)
        ->get();

        $relations = [];
        foreach($references as $reference){
            $referenceItems = Crud::getColumns($reference->REFERENCED_TABLE_NAME);
            $name = $referenceItems[1]['name'] ?? null;
 
            if($name){
                $relations[$reference->COLUMN_NAME] = [
                    'table'  => $reference->REFERENCED_TABLE_NAME,
                    'model'  => Crud::getModel( $reference->REFERENCED_TABLE_NAME ),
                    'column'  => $reference->REFERENCED_COLUMN_NAME,
                    'identity' => Str::singular($reference->REFERENCED_TABLE_NAME) . '_' . $name,
                    'variable' => Str::of( Str::camel( $reference->REFERENCED_TABLE_NAME ))->replace(' ', ''),
                    'singular' => Str::singular( Str::of( Str::camel( $reference->REFERENCED_TABLE_NAME ))->replace(' ', '') ),
                    'name' => $name,
                    'label' => ucwords( Str::of( Str::singular($reference->REFERENCED_TABLE_NAME) )->replace('_', ' ') )   . ' ' .  $referenceItems[1]['label'] ?? '',
                ];
            }

        }

        return $relations;
    }   

}
