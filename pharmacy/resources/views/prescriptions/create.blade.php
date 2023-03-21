@extends('layouts.app')

@section('content')
<?php
$id = auth()->user()->id;
?>

<div class="container mt-5">
    @if(Session::has('success'))
        <div class="alert alert-success text-center">
            {{Session::get('success')}}
        </div>
    @endif
    <form  method="POST" action="{{ route('prescriptions.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-2">
            <label>Note</label>
            <textarea name="note" class="form-control  @error('note') is-invalid @enderror" name="name" id="note" rows="4"></textarea>
            @error('note')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2">
            <label>Delivery Address</label>
            <input type="text" class="form-control @error('deliveryaddress') is-invalid @enderror" name="deliveryaddress" id="deliveryaddress" value="{{ old('deliveryaddress') }}">
            @error('deliveryaddress')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2">
            <label for="delivery_time">Delivery Time:</label>
            <select name="delivery_time" id="delivery_time" class="form-select">
                <option value="10:00:00">10:00 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="14:00:00">2:00 PM</option>
                <option value="16:00:00">4:00 PM</option>
                <option value="18:00:00">6:00 PM</option>
                <option value="20:00:00">8:00 PM</option>
            </select>
            @error('delivery_time')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-2">
            <label>Upload Image</label>
            <input class="form-control" type="file" name="images[]" id="images" multiple>
            @error('images')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-2">
            <label>Delivery Address</label>
            <input type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id" value="<?php echo $id ?>">
            @error('user_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-grid mt-3">
          <input type="submit" value="Submit" class="btn btn-dark btn-block">
        </div>
    </form>
</div>
@endsection
