@extends('layouts.app')

@section('content')
    <div class="row">


    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th width="780px">Note</th>
            <th>Address</th>
            <th>Delivery Time</th>
            <th colspan="2">Action</th>
        </tr>

        <tr>

        @foreach ($prescriptions as $prescription)
        @if($prescription->is_complete==0)
            <td>{{ $loop->iteration }}</td>
            <td>{{ $prescription->note }}</td>
            <td>{{ $prescription->deliveryaddress }}</td>
            <td>{{ $prescription->delivery_time }}</td>

            <td>
                <form action="{{ route('prescriptions.destroy',$prescription->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('quotations.create', ['prescription_id' => $prescription->id, 'user_id' => $prescription->user_id]) }}">Quotation</a>

                    {{-- <a class="btn btn-primary" href="{{ route('prescriptions.edit',$prescription->id) }}">Edit</a> --}}

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </td>

            <td>

                <form method="POST" action="{{ route('prescriptions.update',$prescription->id) }}" accept-charset="UTF-8" style="display:inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_complete" value='1' class="form-control">
                    <button type="submit" class="btn btn-primary" >mark as complete</button>
                </form>
            </td>
        </tr>

        <tr>
            <td colspan="6">
            @if ($prescription->uploadImages)
                    @foreach ($prescription->uploadImages as $image)
                        <a href="{{ asset($image->image) }}" target="_blank">
                            <img src="{{ asset($image->image) }}" alt="" style="width: 80px; height: 60px;">
                        </a>
                    @endforeach
                @else
                    <p>No images available.</p>
                @endif
            </td>
        </tr>
        @endif
        @endforeach
    </table>

@endsection

{{-- @foreach ($prescriptions as $prescription)

    <p>{{ $prescription->note }}</p>
    <p>{{ $prescription->deliveryaddress }}</p>
    <p>{{ $prescription->delivery_time }}</p>
    <p>{{ $prescription->user_id }}</p>
    <ul>
        @foreach ($prescription->images as $image)
            <li>
                <a href="{{ asset($image->url) }}" target="_blank">
                    <img src="{{ asset($image->url) }}" alt="" style="width: 200px; height: 150px;">
                </a>
            </li>
        @endforeach
    </ul>
@endforeach --}}
