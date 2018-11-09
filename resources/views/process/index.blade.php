@extends('layouts.app')
@section('title',"İşlemler")
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">İşlem Listesi</h4>
                </div>
                <div class="card-body table-responsive">

                    <a href="{{route("process.create")}}" class="btn btn-success"><i class="material-icons">input</i>
                        Yeni İşlem</a>

                    <table class="table table-hover">
                        <thead class="text-warning">
                        <tr>
                            <th>İşlem</th>
                            <th>Mesaj</th>
                            <th>Toplam Numara</th>
                            <th>Gönderilmiş Numara Sayısı</th>
                            <th>İşlemdeki Numara Sayısı</th>
                            <th>Durum</th>
                            <th>Oluşturma</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($processes as $process)
                            <tr>
                                <td>{{$process->name}}</td>
                                <td>{{$process->message}}</td>
                                <td>{{$process->processNumbers()->count()}}</td>
                                <td>{{$process->processNumbers()->where("sent",1)->count()}}</td>
                                <td>{{$process->processNumbers()->where("sent",-1)->count()}}</td>
                                <td>{{$process->active ? "Aktif":"Pasif"}}</td>
                                <td>{{$process->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route("process.changeActive",$process)}}" class="btn @if($process->active) btn-warning @else btn-success @endif  btn-sm">@if($process->active) Pasif Et @else Aktif Et @endif</a>
                                        <a href="{{route("processNumber",$process)}}" class="btn btn-info  btn-sm">Numara Tanımla</a>
                                        <form action="{{route("process.destroy",$process)}}" method="post">
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
                    {{$processes->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
