<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    public function index()
    {
        //Get Rent
        $rent = Rent::with('books')->get();

        //return collection of rent as a resource
        return new RentResource(true, 'List Data Peminjaman', $rent);
    }

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

        //Create Rent
        $rent = Rent::create([
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
        return new RentResource(true, 'Data Peminjaman berhasil ditambahkan', $rent);
    }

    public function show(Rent $rent)
    {
        //Return single rent as a resource
        return new RentResource(true, 'Data Peminjaman ditemukan!', $rent);
    }

    public function update(Request $request, Rent $rent)
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
        $rent->update([
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
        return new RentResource(true, 'Data Peminjaman berhasil diubah', $rent);
    }

    public function destroy(Rent $rent)
    {
        //Delete rent
        $rent->delete();

        //Return response
        return new RentResource(true, 'Data Peminjaman berhasil dihapus', null);
    }
}
