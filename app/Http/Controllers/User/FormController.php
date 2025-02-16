<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FormData;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index(){
        dd("here");
    }

    /**
     *  This is function for show the form for all user
    */
    public function showForm(Request $request, $form)
    {
        try {
            $decryptedFormId = jsdecode_userdata($form);
            
            $form = FormData::findOrFail($decryptedFormId);
            
            return view('user.form.show_form', compact('form'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid form link');
        }
    }

    /**
     * here stotre the data of a user 
    */

    public function store(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'form_id' => 'required',
            '*.required' => 'nullable',
        ]);
    
        FormSubmission::create([
            'form_id' => jsdecode_userdata($validatedData['form_id']),
            'token' => Str::random(32),
            'form_data' => json_encode($request->all()),
        ]);
    
        return response()->json(['success' => true, 'message' => 'Form submitted successfully!']);
    }

    /**
     * here is the code for edit 
    */

    public function edit(Request $request,$token)
    {
        $formSubmission = FormSubmission::where('token', $token)->firstOrFail();

        $formData = json_decode($formSubmission->form_data, true);
    
        $form = FormData::where('id',$formSubmission->form_id)->first();
        $formStructure = $form->fields ?? [];
        return view('user.form.edit', compact('formStructure', 'formData', 'token'));
    }

    /**
     * here is the coed for the update form data
    */
    
    public function update(Request $request, $token)
    {
        // Retrieve the existing form submission
        $formSubmission = FormSubmission::where('token', $token)->firstOrFail();
    
        // Dynamic validation: You can add custom rules here if needed
        $validatedData = $request->validate([
            '*.required' => 'nullable', // Placeholder for field-specific validation
        ]);
    
        // Update the form submission with new form data
        $formSubmission->update([
            'form_data' => json_encode($request->all()), // Encode the entire request as JSON
        ]);
    
        // Respond with success
        return response()->json(['success' => true, 'message' => 'Form updated successfully!']);
    }
    
}
