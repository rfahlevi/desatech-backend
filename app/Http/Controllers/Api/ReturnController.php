<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReturnResource;
use App\Models\ReturnM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Return
        $rent = ReturnM::with('books')->get();

        //return collection of rent as a resource
        return new ReturnResource(true, 'List Data Pengembalian', $rent);
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
        $validator = Validator::make($request->all(), [
            'rent_code' => 'required',
            'book_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'expired' => 'required',
            'qty' => 'required',
            'status' => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Create Return
        $rent = ReturnM::create([
            'rent_code' => $request->rent_code,
            'book_id' => $request->book_id,
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'expired' => $request->expired,
            'qty' => $request->qty,
            'status' => $request->status,
        ]);

        //Return Response
        return new ReturnResource(true, 'Data Pengembalian berhasil ditambahkan', $rent);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $return = ReturnM::find($id);
        if (is_null($return)) {
            return response()->json([
                'message' => 'Saran tidak ditemukan',
                'success' => false
            ]);
        }

        $return = ReturnM::with('books')->get();

        return response()->json([
            'data' => $return,
            'message' => 'Berhasil mendapatkan saran',
        ]);

        //Return single return as a resource
        // return new ReturnResource(true, 'Data Peminjaman ditemukan!', $return);
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
    public function update(Request $request, ReturnM $return)
    {
        //Define validation rules
        $validator = Validator::make($request->all(), [
            'rent_code' => 'required',
            'book_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'expired' => 'required',
            'qty' => 'required',
            'status' => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Update rent
        $return->update([
            'rent_code' => $request->rent_code,
            'book_id' => $request->book_id,
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'expired' => $request->expired,
            'qty' => $request->qty,
            'status' => $request->status,
        ]);

        //Return response
        return new ReturnResource(true, 'Data Peminjaman berhasil diubah', $return);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnM $return)
    {
        //Delete rent
        $return->delete();

        //Return response
        return new ReturnResource(true, 'Data Peminjaman berhasil dihapus', null);
    }
}
