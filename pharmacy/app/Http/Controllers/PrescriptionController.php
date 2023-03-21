<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Image;
use Storage;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():View
    {
        // $prescriptions = Prescription::all();
        $prescriptions = Prescription::with('uploadImages')->get();
        return view('prescriptions.index',compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():View
    {
        return view('prescriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'note' => 'nullable',
            'deliveryaddress' => 'required',
            'delivery_time' => 'required|in:10:00:00,12:00:00,14:00:00,16:00:00,18:00:00,20:00:00',
            'user_id' => 'required',
            'is_complete' => 'nullable',

        ]);

        $prescription = new Prescription;
        $prescription->note = $request->note;
        $prescription->deliveryaddress = $request->deliveryaddress;
        $prescription->delivery_time = $request->delivery_time;
        $prescription->user_id = $request->user_id;

        $prescription->save();


        if($request->hasFile('images'))
        {
            $uploadPath = 'uploads/prescriptions/';
            $i=1;
            foreach($request->file('images') as $imageFile)
            {
                $extention = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.
                '.'.$extention;
                $imageFile->move($uploadPath,$filename);
                $finalImagePathName = $uploadPath.$filename;

                $image = new Image;
                $image->image = $finalImagePathName;
                $image->prescription_id = $prescription->id;
                $image->save();


            }
        }

           return redirect()->route('prescriptions.create')
           ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function show(Prescription $prescription)
    {
        //  return view('incomplete')->with('prescriptions', $prescription);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function edit(Prescription $prescription): View
    {

        return view('prescriptions.edit')->with('prescriptions', $prescription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prescription $prescription): RedirectResponse
    {
        $request->validate([
            'note' => 'nullable',
            'deliveryaddress' => 'nullable',
            'delivery_time' => 'nullable',
            'user_id' => 'nullable',
            'is_complete' => 'nullable',

        ]);

        $prescription->update($request->all());

        return redirect()->route('prescriptions.index')
                        ->with('success','Marked as complete!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescription $prescription): RedirectResponse
    {
        $prescription->uploadImages()->delete();
        $prescription->delete();
        return redirect()->route('prescriptions.index')
                        ->with('success','Prescription deleted successfully');
    }
}
