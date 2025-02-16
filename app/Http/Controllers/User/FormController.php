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
            // if(FormSubmission::where('form_id',$decryptedFormId)->exists()){
            //     return redirect()->route('user.form.edit',$form);
            // }else{
            // }
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

    public function edit(Request $request,$form)
    {
        // $formSubmission = FormSubmission::where('token', $token)->firstOrFail();
        // dd($form);
        $decryptedFormId = jsdecode_userdata($form);

        $formSubmission = FormSubmission::where('form_id', $decryptedFormId)->firstOrFail();

        $formData = json_decode($formSubmission->form_data, true);

        $formResults = FormData::where('id',$formSubmission->form_id)->first();
        $formStructure = $formResults->fields ?? [];
        return view('user.form.edit', compact('formStructure', 'formData', 'form'));
    }

    /**
     * here is the coed for the update form data
    */

    public function update(Request $request, $form)
    {
        // Retrieve the existing form submission
        // $formSubmission = FormSubmission::where('token', $token)->firstOrFail();
        $decryptedFormId = jsdecode_userdata($form);

        $formSubmission = FormSubmission::where('form_id', $decryptedFormId)->firstOrFail();

        $validatedData = $request->validate([
            '*.required' => 'nullable',
        ]);

        $formSubmission->update([
            'form_data' => json_encode($request->all()),
        ]);

        // Respond with success
        return response()->json(['success' => true, 'message' => 'Form updated successfully!']);
    }

}
