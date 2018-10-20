@extends('layouts.app')
@section('title',"Numara Yükle")
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">Numara Yükle</h4>
                </div>
                <div class="card-body">
                    <form action="{{route("number.store")}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}


                        <div class="form-group">
                            <textarea class="form-control" name="list" rows="10"
                                      placeholder="Numara Listesi Giriniz"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Txt dosyasından yükle</label>
                            <input type="file" name="file" class="form-control" >
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
