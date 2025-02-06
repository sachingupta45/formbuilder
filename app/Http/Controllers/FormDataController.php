<?php

namespace App\Http\Controllers;

use auth;
use App\Models\FormData;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms=FormData::all(['id','name','created_at']);
       return view('admin.form.index',compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form=[];
        return view('admin.form.add',compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->toArray());
        try {
            if(!auth()->check())
            {
                return response()->json([
                    'success' => false,
                    'errors' => 'no any auth found'
                ], 401); 
            }

            $validator = Validator::make($request->all(), [
                'form_structure' => ['required'],
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); // 422 Unprocessable Entity (Validation Error)
            }
            $data=[
                'user_id'=>auth()->id(),
                'name'=>'sachin',
                'fields'=>$request->form_structure,
            ];
            // FormData::create($data);
            FormData::updateOrCreate(
                ['id'=>$request->previous_form_id],
                $data
            );
            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully!',
                'redirect'=>route('form.index'),
            ]);
        } catch (\Exception $th) {
            return response()->json(['success'=>false,'message'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FormData $form)
    {
        return view('admin.form.view',compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormData $form)
    {
        return view('admin.form.add',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormData $formData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormData $formData)
    {
        //
    }
}
