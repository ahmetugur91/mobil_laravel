@extends('layouts.app')
@section('title',"Numara Tanımla")
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">"{{$process->name}}" İşlemi İçin Numara Tanımla</h4>
                </div>
                <div class="card-body">
                    <form action="{{route("processNumber.post",$process)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label>Seçim Tipi</label>
                            <select class="form-control" name="type">
                                <option value="rastgele">Rastgele Bu İşleme Eklenmemiş Numaralar</option>
                                <option value="enaz">En Az Mesaj Gönderilmiş Numaralar</option>
                                <option value="enfazla">En Fazla Mesaj Gönderilmiş Numaralar</option>
                                <option value="enson">En Son Eklenmiş Numaralar</option>
                                <option value="ilk">İlk Eklenmiş Numaralar</option>
                            </select>
                        </div>

                        <div class="form-group">
                          <label>x Adet Numara Ekle</label>
                            <input class="form-control" type="number" name="amount" value="0" min="0" >
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Tanımla</button>
                        </div>

                    </form>
                </div>

            </div>

            <div class="card">
                <div class="card-header card-header-danger">
                    <h4 class="card-title">"{{$process->name}}" İşleminden Numara Sil</h4>
                </div>
                <div class="card-body">
                    <form action="{{route("processNumberDelete.post",$process)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label>Seçim Tipi</label>
                            <select class="form-control" name="type">
                                <option value="rastgele">Rastgele Bu İşleme Eklenmiş Numaralar</option>
                                <option value="enaz">En Az Mesaj Gönderilmiş Numaralar</option>
                                <option value="enfazla">En Fazla Mesaj Gönderilmiş Numaralar</option>
                                <option value="enson">En Son Eklenmiş Numaralar</option>
                                <option value="ilk">İlk Eklenmiş Numaralar</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>x Adet Numara Sil</label>
                            <input class="form-control" type="number" name="amount" value="0" min="0" >
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Sil</button>
                        </div>

                    </form>
                </div>

            </div>



        </div>
    </div>
@endsection
