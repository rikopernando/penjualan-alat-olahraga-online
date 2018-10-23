<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bank;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function all()
    {
        return Bank::all();
    }

    public function index(Request $request)
    {
        $banks = Bank::select('id','name','atas_nama','no_rek','default')
           ->where(function ($query) use ($request){
               $query->orwhere('name', 'LIKE', '%' . $request->search . '%')
               ->orwhere('atas_nama', 'LIKE', '%' . $request->search . '%')
               ->orwhere('no_rek', 'LIKE', '%' . $request->search . '%');
           })->orderBy('id','desc')->paginate(10);
        $data = [];

        foreach($banks as $bank){
            $data[] = [
                    'id' => $bank->id,
                    'name' => $bank->name,
                    'atas_nama' => $bank->atas_nama,
                    'no_rek' => $bank->no_rek,
                ];
        }

        return app(PaginateController::class)->getPagination($banks, $data, '/api/banks');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $this->validate($request,[
            'name' => 'required',
            'atas_nama' => 'required',
            'no_rek' => 'required|unique:banks',
          ]);  

          $bank = Bank::create([
              'name' => $request->name,
              'atas_nama' => $request->atas_nama,
              'no_rek' => $request->no_rek,
              'default' => 1
          ]);

          return response()->json([
            'message' => 'Success Create Bank',
            'data' => $bank
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Bank::find($id);
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
          $this->validate($request,[
            'name' => 'required',
            'atas_nama' => 'required|unique:banks,id,'.$id,
            'no_rek' => 'required',
          ]);  

          $bank = Bank::find($id);
          $bank->update([
              'name' => $request->name,
              'atas_nama' => $request->atas_nama,
              'no_rek' => $request->no_rek,
          ]);

          return $bank;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bank::destroy($id);
        return response(200);
    }
}
