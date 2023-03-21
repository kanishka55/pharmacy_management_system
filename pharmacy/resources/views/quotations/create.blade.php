@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Bill Reciept in Laravel</title>
      <style>
        .result{
         color:red;
        }
        td
        {
          text-align:center;
        }
      </style>
   </head>
   <body>

        @csrf
      <section class="mt-3">
         <div class="container-fluid">
         <h4 class="text-center" style="color:green"> Pharmacy New Quatations </h4>

         <div class="row">
            <div class="col-md-5  mt-4 ">
               <table class="table" style="background-color:#e0e0e0;" >

                  <thead>
                     <tr>
                        <th>No.</th>
                        <th>Medicine Items</th>
                        <th style="width: 18%">Qty</th>
                        <th style="width: 20%">Price</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td scope="row">1</td>
                        <td style="width:60%">

                            <select name="drug_id" id="drug_id" class="form-control">
                                <option value="">-- Select a drug --</option>
                                @foreach ($drugs as $drug)
                                    <option id={{ $drug->id }}  value={{ $drug->drug_name }} data-id="{{ $drug->id }}" class="drug_id custom-select">
                                        {{ $drug->drug_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width:5px;">
                          <input type="number" id="qty" min="0" value="1" class="form-control">
                        </td>
                        <td>
                           <h6 class="mt-1" name ="price" id="price" ></h6>
                        </td>
                        <td><button id="add" class="btn btn-success">Add</button></td>
                     </tr>

                     <tr>
                     </tr>

                  </tbody>
               </table>
               <div role="alert" id="errorMsg" class="mt-5" >
                 <!-- Error msg  -->
              </div>
            </div>
            <div class="col-md-7  mt-4" style="background-color:#f5f5f5;">
            <form action="{{ route('quotations.store') }}" method="POST" id="myForm">
                @csrf
               <div class="p-4">
                  <div class="text-center">
                     <h4>Receipt</h4>
                  </div>

                  <div class="row">
                     </span>
                     <p id="prescription_id">{{ $prescription_id }}</p>
                     <p id="user_id">{{ $user_id }}</p>
                     <table id="receipt_bill" class="table">
                        <thead>
                           <tr>
                              <th> No.</th>
                              <th>Product Name</th>
                              <th>Product ID</th>
                              <th>Quantity</th>
                              <th class="text-center">Price</th>
                              <th class="text-center">Total</th>
                           </tr>
                        </thead>
                        <tbody id="new" >

                        </tbody>
                        <tr>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                           <td class="text-right text-dark" >
                                <h5><strong>Sub Total:  ₹ </strong></h5>

                           </td>
                           <td class="text-center text-dark" >
                              <h5> <strong><span id="subTotal"></strong></h5>

                           </td>
                        </tr>

                     </table>
                  </div>
               </div>
               <input type="submit" value="Submit" class="btn btn-dark ">
            </form>
            </div>
         </div>
      </section>

   </body>
</html>
<script>
    $(document).ready(function(){
        $('#drug_id').on('change', function() {
            var drugId = $(this).find(':selected').attr('id');

            // Make an AJAX request to get the drug price
            $.ajax({
                url: '/quotations/getPrice/' + drugId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Update the price in the h5 tag
                    $('#price').text(response.unit_price);
                    //console.log(response.unit_price);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });


        //add to cart
        var count = 1;
        $('#add').on('click',function(){

            var name = $('#drug_id').val();
            var id = $('#drug_id option:selected').data('id');
            //console.log(id);
            var qty = $('#qty').val();
            var price = $('#price').text();

            if(qty == 0)
            {
                var erroMsg =  '<span class="alert alert-danger ml-5">Minimum Qty should be 1 or More than 1</span>';
                $('#errorMsg').html(erroMsg).fadeOut(9000);
            }
            else
            {
                billFunction(); // Below Function passing here
            }


            function billFunction()
            {
                var total = 0;

                $("#receipt_bill").each(function () {
                var total =  price*qty;
                var subTotal = 0;
                subTotal += parseInt(total);

                var table =   '<tr><td>'+ count +'</td><td>'+ name + '</td><td>'+ id + '</td><td>' + qty + '</td><td>' + price + '</td><td><strong><input type="hidden" id="total" value="'+total+'">' +total+ '</strong></td></tr>';
                $('#new').append(table)

                    // Code for Sub Total of drugs
                    var total = 0;
                    $('tbody tr td:last-child').each(function() {
                        var value = parseInt($('#total', this).val());
                        if (!isNaN(value)) {
                            total += value;
                        }
                    });
                    $('#subTotal').text(total);


                    // Code for Total Payment Amount

                    var Subtotal = $('#subTotal').text();


                    var totalPayment = parseFloat(Subtotal)
                    $('#totalPayment').text(totalPayment.toFixed(2));
                    //console.log(totalPayment);

                });
                count++;
            }
        });

    });
 </script>

 <script>
    $(document).ready(function() {
        $('#myForm').submit(function(e) {
            e.preventDefault(); // prevent form submission

            // get form data
            var prescription_id = {{ $prescription_id }};
            var user_id = {{ $user_id }};
            var total_amount = parseFloat($('#subTotal').text());
            console.log(total_amount);
            console.log(typeof total_amount);
            var csrf_token = $('meta[name="csrf-token"]').attr('content'); // get CSRF token


            var quotationData = [];

            $('#new tr').each(function() {
                var drug_id = parseInt($(this).find('td:nth-child(3)').text());
                var quantity = parseInt($(this).find('td:nth-child(4)').text());
                var amount = $(this).find('td:nth-child(6) input').val();

                quotationData.push({drug_id: drug_id, quantity: quantity, amount: amount});
            });

            // send form data to server using Ajax
            $.ajax({
            url: '{{ route('quotations.store') }}', // replace with your server-side script URL
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf_token // add CSRF token to headers
            },
            data: {
                user_id: user_id,
                prescription_id: prescription_id,
                total_amount: total_amount,
                quotationData: quotationData,

            },
            success: function(response) {
                // handle successful response from server
                console.log(response);
                window.location.reload(); // reload the page after successful response
            },
            error: function(xhr, status, error) {
                // handle error response from server
                console.log(xhr.responseText);
            }
            });
        });
});

 </script>

@endsection


