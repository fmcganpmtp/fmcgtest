namespace App\Http\Controllers;
use Validator;
use App\{{ $class }};
@foreach($references as $reference)
use App\{{ $reference['model'] }};
@endforeach
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class {{ $class }}Controller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

@foreach($references as $referenceKey => $reference)
        ${{ $reference['variable'] }} = {{ $reference['model'] }}::all();
@endforeach

        return view('backend/{{$slug}}/index', compact( @foreach($references as $referenceKey => $reference) '{{ $reference['variable'] }}', @endforeach 'search' ));
    }
 
    function list({{ $class }} ${{ $variable }}) 
    {
        $query = ${{ $variable }};
        $query = $query->select(
@foreach($references as $referenceKey => $reference)
        '{{ $reference['table'] }}.{{ $reference['name'] }} as {{ $reference['identity'] }}', 
@endforeach
@php $counter = 1; @endphp
@foreach($items as $item)
@if( count($items) == $counter)
        '{{ $table }}.{{ $item['name'] }}'    
@else
        '{{ $table }}.{{ $item['name'] }}',     
@endif
@php $counter++; @endphp
@endforeach
        );
@foreach($references as $referenceKey => $reference)
        $query = $query->leftJoin('{{ $reference['table'] }}', '{{ $reference['table'] }}.{{ $reference['column'] }}', '=', '{{ $table }}.{{ $referenceKey }}');
@endforeach
        $data = $this->datatable(
            $query,

            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
@foreach($items as $item)
                    $query->orWhere('{{ $table }}.{{ $item['name'] }}', 'LIKE', "%{$search}%");  
@endforeach

@foreach($references as $referenceKey => $reference)
                    $query->orWhere('{{ $reference['table'] }}.{{ $reference['name'] }}', 'LIKE', "%{$search}%");  
@endforeach
                }
            },

            function ($rows, $totalFiltered, $totalData) {
                $data = [];

                $start = request('start') ?? 0;
                $order = request('order.0.dir') ?? 'desc';
                $count = $totalFiltered - $start;
                $start = $start + 1;

                foreach ($rows as $row) {
                    $data[] = [
                    'id' => $order == 'desc' ? $start++ : $count--, 
@foreach($items as $item)
@if($item['name']  != 'id')
                    '{{ $item['name'] }}' => $row->{{ $item['name'] }},
@endif
@endforeach
@foreach($references as $referenceKey => $reference)
                    '{{ $reference['identity'] }}' => $row->{{ $reference['identity'] }},
@endforeach

                    'actions' => view('backend/{{$slug}}/actions', compact('row'))->render(),
                    ];
                }

                return $data;
            }
        );

        return response()->json($data);
    }
 
    public function store(Request $request)
    {

        $validator = Validator::make(request()->all(), [
@foreach($columns as $column)
@if($column['name']!='id')
            '{{$column['name']}}' => [ {!! crudValidator($column) !!} ],
@endif
@endforeach
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();

        try {

            $input = $request->only([@foreach($columns as $column)@if($column['name'] != 'id' && $column['type'] != 'image')'{{$column['name']}}', @endif @endforeach]);
 
@foreach($columns as $column)@if($column['type'] == 'image')
            
            if($request->hasFile('{{$column['name']}}')){ 
                $input['{{$column['name']}}'] = Storage::disk('public')->putFile('{{$slug}}', $request->file('{{$column['name']}}'));
            }
@endif @endforeach

            {{ $class }}::create($input);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => '{{ $singular }}',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }

        DB::commit();

        return response()->json([
            'reset' => true,
            'modal' => [
                'hide' => '#create-form',
            ],
            'alert' => [
                'icon' => 'success',
                'title' => '{{ $singular }}',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit({{ $class }} ${{ $variable}})
    {
@foreach($references as $referenceKey => $reference)
        ${{ $reference['variable'] }} = {{ $reference['model'] }}::all();
@endforeach
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/{{$slug}}/edit', compact( @foreach($references as $referenceKey => $reference) '{{ $reference['variable'] }}', @endforeach '{{ $variable}}' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, {{ $class }} ${{ $variable}})
    {

        $validator = Validator::make(request()->all(), [
@foreach($columns as $column)
@if($column['name']!='id')
            '{{$column['name']}}' => [ {!! crudValidator($column) !!} ],
@endif
@endforeach
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();

        try {

            $input = $request->only([@foreach($columns as $column)@if($column['name'] != 'id' && $column['type'] != 'image')'{{$column['name']}}', @endif @endforeach]);
 
@foreach($columns as $column)@if($column['type'] == 'image')
            
            if($request->hasFile('{{$column['name']}}')){ 
                $input['{{$column['name']}}'] = Storage::disk('public')->putFile('{{$slug}}', $request->file('{{$column['name']}}'));
            }
@endif @endforeach

            ${{ $variable}}->update($input);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => '{{ $singular }}',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }

        DB::commit();

        return response()->json([
            'reset' => true,
            'modal' => [
                'hide' => '#edit-form',
            ],
            'alert' => [
                'icon' => 'success',
                'title' => '{{ $singular }}',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy({{ $class }} ${{ $variable}})
    {
        try {

            ${{ $variable}}->delete();

        } catch (\Exception $e) {

            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => '{{ $singular }}',
                    'text' => '{{ $singular }} can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => '{{ $singular }}',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }

}
