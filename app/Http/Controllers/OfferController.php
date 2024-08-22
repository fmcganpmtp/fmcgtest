<?php 
namespace App\Http\Controllers;
use Validator;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class OfferController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        return view('backend/offer/index', compact(  'search' ));
    }
 
    function list(Offer $offer) 
    {
        $query = $offer;
        $query = $query->select(
        'offers.id',     
        'offers.name',     
        'offers.image'    
        );
        $data = $this->datatable(
            $query,
            function ($query) {
                $search = request('search.value') ?? '';
                if (!empty($search)) {
                    $query->orWhere('offers.id', 'LIKE', "%{$search}%");  
                    $query->orWhere('offers.name', 'LIKE', "%{$search}%");  
                    $query->orWhere('offers.image', 'LIKE', "%{$search}%");  
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
                    'name' => $row->name,
                    'image' => $row->image,
                    'actions' => view('backend/offer/actions', compact('row'))->render(),
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
            'name' => [ 'required', 'max:100' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',   ]);
 
              
            if($request->hasFile('image')){ 
                $input['image'] = Storage::disk('public')->putFile('offer', $request->file('image'));
            }
 
            Offer::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Offer',
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
                'title' => 'Offer',
                'text' => 'Created successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function edit(Offer $offer)
    {
 
        return response()->json([
            'jquery' => [
                [
                    'element' => '#edit-form .modal-content',
                    'method' => 'html',
                    'value' => view('backend/offer/edit', compact(  'offer' ))->render(),
                ],
            ],
            'init' => ['#edit-form .modal-content'],
            'modal' => [
                'show' => '#edit-form'
            ]
        ]);
    }
 
    public function update(Request $request, Offer $offer)
    {
        $validator = Validator::make(request()->all(), [
            'name' => [ 'required', 'max:100' ],
            'image' => [ 'nullable', 'file', 'image', 'max: 10240' ],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            $input = $request->only([ 'name',   ]);
 
              
            if($request->hasFile('image')){ 
                $input['image'] = Storage::disk('public')->putFile('offer', $request->file('image'));
            }
 
            $offer->update($input);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Offer',
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
                'title' => 'Offer',
                'text' => 'Updated successfully.',
            ],
            'datatable' => [
                'reload' => true,
            ],
        ]);
    }
 
    public function destroy(Offer $offer)
    {
        try {
            $offer->delete();
        } catch (\Exception $e) {
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Offer',
                    'text' => 'Offer can\'t be deleted! as it is in use',
                ],
            ]);
        }
        return response()->json([
            'datatable' => [
                'reload' => true,
            ],
            'alert' => [
                'icon' => 'success',
                'title' => 'Offer',
                'text' => 'Deleted successfully.',
            ],
        ]);
    }
}
