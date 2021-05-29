@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">

      @if(\Session::has('alert'))
      <div class="alert alert-danger">
        <div>{{Session::get('alert')}}</div>
      </div>
      @endif

      @if(\Session::has('success'))
      <div class="alert alert-success">
        <div>{{Session::get('success')}}</div>
      </div>
      @endif

      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">

        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Proyek</th>
            <th>Harga Total (Rp.)</th>
            <th>Tanggal Dibuat</th>
            <th>Status</th>
            <th>Detail</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rab AS $key=>$value)

          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value['nama']}}</td>
            <td>{{$harga_total[$key]}}</td>
            <td>{{date("d-M-Y, H:i ", strtotime(($value->created_at)))}} WIB</td>
            <td>
              @if($value['status'] == 0)
              Belum Di Approve Pimpinan
              @elseif ($value['status'] == 1)
              Sudah Di Approve Pimpinan <br> ({{date("d-M-Y", strtotime(($value->updated_at)))}})
              @elseif ($value['status'] == 2)
              Selesai
              @endif
            </td>
            <td>
          
            <a href="{{route('rab.detail', $value->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
            </td>
            

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection