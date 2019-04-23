<?php namespace App\Http\Controllers;

use App\Item;
use App\Checklist;
use Illuminate\Http\Request;

class ItemsController extends Controller {
    public $offset = 0;
    public $limit = 10;
    public $field = 'id';
    public $sort = 'asc';
    public $filter = '';

    public function complete_item()
    {
        $items = Item::where('is_completed',1)->get();
        if($items){
            return response()->json($items,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }

    public function incomplete_item()
    {
        $items = Item::where('is_completed',0)->get();
        if($items){
            return response()->json($items,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }

    public function item_with_checklist(Request $request)
    {
        $reqLimit = $this->limit;
        $reqOffset = $this->offset;
        $reqField = $this->field;
        $reqSort = $this->sort;
        $reqFilter = $this->filter;

        if(isset($request->limit)){
            $reqLimit = $request->limit;
        }

        if(!empty($request->offset)){
            $reqOffset = $request->offset;
        }

        if(!empty($request->field)){
            $reqField = $request->field;
        }

        if(!empty($request->sort)){
            $reqSort = $request->sort;
        }

        if(!empty($request->filter)){
            $reqFilter = $request->filter;
        }

        $items = Checklist::with(['item' => function($query) use($reqLimit,$reqOffset,$reqField,$reqSort,$reqFilter){
            $query->skip($reqOffset)
                  ->take($reqLimit)
                  ->where('name','LIKE','%'.$reqFilter.'%')
                  ->orderBy($reqField,$reqSort);
        }])->find($request->checklistid);
        if($items){
            $data = (object)array(
                'type' => 'checklists',
                'id' => $request->checklistid,
                'attributes' => $items
                );
            return response()->json($data,200);
        }
        return response()->json([
            'message' => "Error Getting Data"
        ],500);
    }
}
