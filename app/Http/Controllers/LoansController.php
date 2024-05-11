<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoansController extends Controller
{
    public function index()
    {
        $loans = Loans::all();
        return response()->json($loans);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'desc' => 'required',
            'total_amount' => 'required',
        ]);
        $loans = Loans::create($data);
        return response()->json($loans, 201);
    }

    public function show($id)
    {
        $loans = Loans::findOrFail($id);
        return response()->json($loans);
    }

    public function update(Request $request,$id)
    {
        try
        {
            $loans = Loans::findOrFail($id);
            $data = $request->validate([
                'client_name' => 'required|string|max:255',
                'desc' => 'required',
                'total_amount' => 'required',
            ]);
            $loans->update($data);
            return response()->json($loans);
        } catch(ModelNotFoundException $e){
             return response()->json([
                'error' => 'Loans not found',
                'message' => 'The Loans with the specified ID does not exist.',
            ], 404);
        }
    }

    public function destroy($id)
    {
        try
        {
            $loans = Loans::findOrFail($id);
            $loans->delete();
            return response()->json([
                'message'=>'Loans deleted successfully.'
            ], 200);
        } catch(ModelNotFoundException $e){
             return response()->json([
                'error' => 'Loans not found',
                'message' => 'The Loans with the specified ID does not exist.',
            ], 404);
        }
    }
}
