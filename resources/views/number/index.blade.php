@extends('layouts.app')
@section('title',"Numaralar")
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">Numara Listesi</h4>
                </div>
                <div class="card-body table-responsive">

                    <a href="{{route("number.create")}}" class="btn btn-success"><i class="material-icons">input</i>
                        Numara Yükle</a>

                    <a href="{{route("number.export")}}" class="btn btn-primary"><i class="material-icons">input</i>
                        Numaraları Dışarı AKtar</a>

                <a href="{{route("destroyAll")}}" onclick="return confim('Bütün numaraları silmek istiyormusunuz?')" class="btn btn-danger"><i class="material-icons">input</i>
                        Bütün Numaraları Sil</a>

                    <form action="{{route("number.index")}}" method="get" class=" pull-right form-inline">

                        <span class="form-inline">

                            <input type="text" name="search"
                                   value="@if(\Illuminate\Support\Facades\Input::get("search")){{\Illuminate\Support\Facades\Input::get("search")}}@endif"
                                   class="form-control" placeholder="Numara"> &nbsp;

                            <button type="submit" class="btn btn-sm btn-primary">Ara</button>
                        </span>
                    </form>


                    <table class="table table-hover">
                        <thead class="text-warning">
                        <tr>
                            <th>Numara</th>
                            <th>Gönderilmiş Mesaj Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($numbers as $number)
                            <tr>
                                <td>{{$number->number}}</td>
                                <td>{{$number->sended}}</td>
                                <td>
                                    <div class="btn-group">
                                        <form action="{{route("number.destroy",$number)}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field("delete")}}
                                            <button onclick="return confirm('Silmek istediğnize emin misiniz?');"
                                                    class="btn btn-danger btn-sm"><i
                                                        class="material-icons">remove</i> Sil
                                            </button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{$numbers->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
