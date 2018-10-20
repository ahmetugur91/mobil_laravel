<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>Admin Giriş</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>


    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">


    <link href="/assets/css/material-dashboard.min.css?v=2.0.2" rel="stylesheet"/>
    <link href="/assets/demo/demo.css" rel="stylesheet"/>


</head>

<body class="off-canvas-sidebar">


<div class="wrapper wrapper-full-page">


    <div class="" filter-color="blue">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="container">
            <div class="col-md-8 ml-auto mr-auto">
                <form class="form" method="post" action="{{ route('login') }}">
                    {{csrf_field()}}
                    <div class="card card-login card-hidden">
                        <div class="card-header card-header-info text-center">
                            <h4 class="card-title">Yönetim Paneli</h4>
                        </div>
                        <div class="card-body ">


                            <span class="bmd-form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="Email...">
              </div>
            </span>
                            <span class="bmd-form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Şifre...">
              </div>
            </span>
                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit" class="btn btn-success btn-block">Giriş Yap</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>


</div>


</body>

</html>
