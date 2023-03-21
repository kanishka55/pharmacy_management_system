@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

@foreach($quotations as $quotation)
    <div class="card border-success" style="margin: 25px 300px;">
        <div class="card-header" style="background-color:#58D68D;">
            <h6>Quotation ID: {{ $quotation->id }}</h6>
        </div>
        <div class="card-body" style="background-color:#ECF0F1;">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Medicine Name</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">quantity</th>
                    <th scope="col">Price</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($quotation->drugs as $drug)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $drug->drug_name }}</td>
                            <td>{{ $drug->unit_price }}</td>
                            <td>{{ $drug->pivot->quantity }}</td>
                            <td>{{ $drug->pivot->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="card-footer" style="background-color:#58D68D;">
            <div class="row">
                <div class="col-md-8">
                    <h6>Total Amount: {{ $quotation->total_amount }}</h6>
                </div>
                <div class="col-md-4 text-right mr-auto">
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
