<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Quotation;
use App\Models\Quotation_drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::with('drugs')->get();

        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$drugs = Drug::all();
        $drugs = DB::table('drugs')->get();

    $prescription_id = $request->input('prescription_id');
    $user_id = $request->input('user_id');

    return view('quotations.create', compact('prescription_id', 'user_id', 'drugs'));

    }


    public function getPrice($id)
    {
        $drug = Drug::find($id);

        if ($drug) {
            return response()->json(['unit_price' => $drug->unit_price]);
        } else {
            return response()->json(['error' => 'Drug not found.'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required',
            'user_id' => 'required',
            'total_amount' => 'required',
            'is_accept' => 'nullable',
            'is_reject' => 'nullable',

        ]);

        // create a new Quotation model and set its attributes
        $quotation = new Quotation;
        $quotation->prescription_id = $request->prescription_id;
        $quotation->user_id = $request->user_id;
        $quotation->total_amount = $request->total_amount;

        // save the model to the database
        $quotation->save();

        foreach ($request->quotationData as $item) {
            $quotationDrug = new Quotation_drug;
            $quotationDrug->quotation_id = $quotation->id;
            $quotationDrug->drug_id = $item['drug_id'];
            $quotationDrug->quantity = $item['quantity'];
            $quotationDrug->amount = $item['amount'];
            $quotationDrug->save();
        }



        // return a response indicating success
        return response()->json(['success' => true]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
