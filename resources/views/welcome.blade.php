<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CashFree Payment Gateway</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
       
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="container">
            <h1>CashFree Payment Gateway</h1>
            <hr>
            @if($errors->any())
               <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                   
               </div>
            @endif
            <form method="POST" name="pay_now" action="{{route('payment.pay')}}">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div> 
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Phone No.</label>
                            <input type="number" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control">
                        </div>
                    </div> 
                    <div class="col-lg-12">
                        <div class="form-group">
                           
                            <input type="submit" name="submit" class="btn btn-primary btn-block" value="Pay Now">
                        </div>
                    </div>                                                            
                </div>
                
            </form>
        </div>
    </body>
</html>
