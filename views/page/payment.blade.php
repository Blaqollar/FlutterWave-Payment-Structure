<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta email="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Flutterwave payment page</title>
  </head>
  <body>
    <div class="container">
        <div class="header mt-2 px-5 text-center bg-primary py-5 text-white">
            <h1>Pay for Product</h1>
        </div>
        <div class="main">
            <form id="makePaymentform">
                @csrf  
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="name" name="name" id="name" class="form-control" required placeholder="Enter full name">
                        </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" required class="form-control" id="email" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" placeholder="Enter amount" id="amount" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="phone">Phone number</label>
                        <input type="phone" name="phone" placeholder="Enter number" id="phone" class="form-control">
                    </div>
                </div>
                <div class="form-group mt-2">
  <button type="submit" class="btn btn-primary">Pay Now</button>
</form>
        </div>
    </div> 

    
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
     <script src="https://checkout.flutterwave.com/v3.js"></script> 
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    

<script>
    $(function () {
        $("#makePaymentform").submit(function (e) {
            e.preventDefault();
            var name = $("#name").val();
            var email = $("#email").val();
            var number = $("#phone").val();
            var amount = $("#amount").val();

            makePayment(amount,email,number,name)
        });
    });

  function makePayment(amount,email,phone_number,name) {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-4ea4700d546508d2a573fdce13dcc73b-X",
      tx_ref: "RX1_{{substr(rand(0,time()),0,7)}}",
      amount,
      currency: "NGN",
      country: "NG",
      payment_options: " ",
      customer: {
        email,
        phone_number,
        name,
      },
      callback: function (data) {
          var transaction_id = data.transaction_id;
          //Make Ajax request
          var _token = $("input[name='_token']").val();
        $.ajax({
            type:"POST",
            url:"{{URL::to('verify-payment')}}",
            data:{
                transaction_id,
                _token
            },
            success: function (respons) {
                console.log(response);
            }

        })
      },
      onclose: function() {
        // close modal
      },
      customizations: {
        title: "My cart",
        description: "Payment for items in cart",
        logo: "data:image/png;base64,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",
      },
    });
  }
</script>
  </body>
</html>