@extends('layouts.app')
@section('title',"Yeni İşlem")
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">Yeni İşlem</h4>
                </div>
                <div class="card-body">
                    <form action="{{route("process.store")}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}


                        <div class="form-group">
                          <label>İşlem Adı</label>
                            <input class="form-control" type="text" name="name"  required>
                        </div>

                        <div class="form-group">
                            <label>Mesaj (154 karakter) | 6 Karakter rezerve</label>
                            <input class="form-control" type="text" name="message"  maxlength="154" required>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Yükle</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
