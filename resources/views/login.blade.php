<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0,shrink-to-fit=no">
<title>KPU DONGGALA | LOGIN</title>
<link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/login_kpu.css') }}">
<link rel="icon" href="{{ asset('img/favicon.png') }}">
<style>

.loading {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 2px solid rgba(0,0,0,.2 );
            border-radius: 50%;
            border-top-color: rgba(0,0,0,.4 );
            animation: spin 1s ease-in-out infinite;
            -webkit-animation: spin 1s ease-in-out infinite;
            left: calc(50%);
            top: calc(50%);
            position: fixed;
            z-index: 1;
        }

        @keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }
        .auth-card .image-side {
                      background: url('{{ asset('img/login.png') }}') no-repeat top!important;
                  }
        
        .logo-single {
            width: 253px;
            height: 63px;
            background: url('{{ asset('img/logohead.svg') }}') no-repeat;
            background-position: 50%;
            display: inline-block;
            margin-bottom: 60px;
        }
</style>
     
</head>
<body>
<div class="container">
  <div class="row h-100">
    <div class="mx-auto my-auto col-md-10 col-12">
      <div class="card auth-card">
      <!----><!---->
      <div class="position-relative image-side">
        <p class="text-white h2">Aplikasi Bantu Pengelolaan Data Pemilih KPU Kab. Donggala</p>
      </div>
      <div class="form-side">
        <a href="/" class="active">
          <span class="logo-single"></span>
        </a>
        <h6 class="mb-4">Masuk</h6> 
        <form class="av-tooltip tooltip-label-bottom" method="post" action="">
        @csrf
          <fieldset class="form-group" id="__BVID__27">
            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" >User</legend>
            <div>
              <input type="email" class="form-control is-valid" id="email" name="email" required> <!----><!----><!----><!---->
            </div>
          </fieldset> 
          <label>Sandi</label>
          <div role="group" class="input-group"><!---->
            <input type="password" class="form-control is-valid" id="password" name="password" required>
               <!----><!---->
      </div> 
      <div>
        
      </div> 
      <br> 
      @if(session('status'))
            <div class='alert alert-danger'>
            {{ session('message') }}
            </div>
        @endif
      <div class="d-flex justify-content-between align-items-center">
        
        <br>
        <button type="submit" class="btn btn-primary btn-lg btn-multiple-state btn-shadow">
        <span class="spinner d-inline-block">
          <span class="bounce1"></span>
          <span class="bounce2"></span>
          <span class="bounce3"></span>
        </span> 
        <span class="icon success">
          <i class="simple-icon-check"></i>
        </span> 
        <span class="icon fail">
          <i class="simple-icon-exclamation"></i>
        </span> 
        <span class="label">MASUK</span>
        </button>
        </div>
       
        </form></div><!----><!---->
        </div>
        </div>
        </div>
        </div>

</body>
</html>        