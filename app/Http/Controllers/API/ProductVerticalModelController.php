<?php

namespace App\Http\Controllers\API;

use App\Models\ProductVerticalModel;
use App\Http\Requests\StoreProductVerticalModelRequest;
use App\Http\Requests\UpdateProductVerticalModelRequest;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Resources\ProductVertical as ProductResource;
use Validator;
class ProductVerticalModelController extends BaseController
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
			$product=ProductVerticalModel::paginate(5);
			$items = ProductResource::collection($product);
			$json_data = array(
			"recordsTotal"    => $items->total(),  
			"recordsFiltered" => $items->total(), 
			"data"            => $items,
			'current_page' => $items->currentPage(),
			'next' => $items->nextPageUrl(),
			'previous' => $items->previousPageUrl(),
			'per_page' => $items->perPage(),   
			);
			return $this->sendResponse( $json_data, 'Product Vertical List successfully.');
		}catch (\Throwable $th) {
            return $this->sendError('Exception Error.', $th);  
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductVerticalModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$user_id = Auth::user()->id;

        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		try{
			DB::beginTransaction();
			$product=new ProductVerticalModel();
			$product->title=$request->title;
			$product->status=0;
			$product->added_by=$user_id;
			$product->approved_by=0;
			$product->save();
			DB::commit();
			return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
		}catch (\Throwable $th) {
            DB::rollBack();
			return $this->sendError('Exception Error.', $th);  
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductVerticalModel  $productVerticalModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductVerticalModel::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
		return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductVerticalModelRequest  $request
     * @param  \App\Models\ProductVerticalModel  $productVerticalModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        try{
			DB::beginTransaction();
			$product =ProductVerticalModel::find($id);
			$product->title=$request->title;
			$product->save();
			DB::commit();
			return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
		}catch (\Throwable $th) {
            DB::rollBack();
			return $this->sendError('Exception Error.', $th);  
            
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$product =ProductVerticalModel::findOrFail($id);
        $product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
