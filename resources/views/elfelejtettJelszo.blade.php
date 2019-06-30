<!DOCTYPE html>
<html lang="hu">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FIEK_OPIBUS</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="/assets/fontawesome-free/css/all.min.css rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            @if(empty($code) && !isset($info)) 
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Email cím megadása jelszó visszaállításához</h1>
                  </div>
                  <form action="#" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input class="form-control" name="email" placeholder="Email cím">
                        </div>
                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Küldés">

                  </form>
                </div>
              </div>
            </div>
            @elseif(isset($info) && $info == "sikeres")
            <div class="row">
                    <div class="col-lg-12">
                      <div class="p-5">
                        <div class="text-center">
                          <h1 class="h4 text-gray-900 mb-4">Sikeres visszaállítás</h1>
                        </div>
                        <p>A jelszavadat sikeresen visszaállítottad!</p>
                        <p>A jelszavad: changeme</p>
                        <p>Kérünk, hogy minél előbb változtasd meg a jelszavadat a fiókod biztonságának érdekében!</p>
                      </div>
                    </div>
                  </div>
            @endif
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="/assets/jquery/jquery.min.js"></script>
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/assets/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/assets/js/sb-admin-2.min.js"></script>


</body>

</html>
