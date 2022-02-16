<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\Http\Resources\ProductFormResource as ApiResource;
use App\Models\ProcductFormModel;
use App\Models\ProductFormControlsModel;
use App\Http\Controllers\API\BaseController as BaseController;

class MiniCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $product=ProcductFormModel::paginate(5);
            $items = ApiResource::collection($product);
            $json_data = array(
            "recordsTotal"    => $items->total(),  
            "recordsFiltered" => $items->total(), 
            "data"            => $items,
            'current_page' => $items->currentPage(),
            'next' => $items->nextPageUrl(),
            'previous' => $items->previousPageUrl(),
            'per_page' => $items->perPage(),   
            );
            return $this->sendResponse( $json_data, 'Product Form List successfully.');
        }catch (\Throwable $th) {
            return $this->sendError('Exception Error.', $th);  
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $input = $request->all();
        $validator=$this->validationSet($input);
        
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        try{
            DB::beginTransaction();
            $product=new ProcductFormModel();
            $product->title=$request->title;
            $product->type=$request->type;
            $product->status=0;
            $product->added_by=$user_id;
            $product->approved_by=0;
            $product->save();
            foreach($input['contorls'] as $key=>$control)
            {
                $FormControl=new ProductFormControlsModel();
                $FormControl->form_id=$product->id;
                $FormControl->control=$control['element'];
                $FormControl->is_required=$control['is_required'];
                $FormControl->save();    
            }
            
            DB::commit();
            return $this->sendResponse(new ApiResource($product), 'Product Form created successfully.');
        }catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Exception Error.', $th);  
            
        }
    }
    public function validationSet($input)
    {

        $validator = Validator::make($input, [
            'title' => 'required',
            'type' => 'required',
            'controls' => 'array'
        ]);
        return $validator;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProcductFormModel::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product Form not found.');
        }
        return $this->sendResponse(new ApiResource($product), 'Product Form retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'type' => 'required',
            'controls' => 'array'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        try{
            DB::beginTransaction();
            $product =ProcductFormModel::find($id);
            $product->title=$request->title;
            $product->type=$request->type;
            $product->save();

            ProductFormControlsModel::where('form_id',$id)->delete();
            
            foreach($input['contorls'] as $key=>$control)
            {
                $FormControl=new ProductFormControlsModel();
                $FormControl->form_id=$product->id;
                $FormControl->control=$control['element'];
                $FormControl->is_required=$control['is_required'];
                $FormControl->save();    
            }
            DB::commit();
            return $this->sendResponse(new ApiResource($product), 'Product Form updated successfully.');
        }catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Exception Error.', $th);  
            
        }
   
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            $product =ProcductFormModel::findOrFail($id);
            $product->delete();
            DB::commit();
            return $this->sendResponse([], 'Product Form deleted successfully.');
        }catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th);  
        }
    }
}
