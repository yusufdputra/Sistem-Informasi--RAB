@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">
      @role('admin')
      <div class="align-items-center">
        <a href="#" onclick="window.history.back()" class="btn btn-danger m-l-10 waves-light  mb-5">Kembali</a>

      </div>
      @endrole

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

      @error('harga_barang')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror


      @php
      $harga_total = 0;
      @endphp
      <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">

        <thead>
          <tr>
            <th>No.</th>
            <th>Nama barang</th>
            <th>Suplier</th>
                        <th>Untuk</th>
            <th>Nomor Hp</th>
            <th>Alamat</th>
            <th>Harga (Rp.)</th>
            <th>Kuantitas</th>
            <th>Total Harga (Rp.)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rab AS $key=>$value)

          @php
          $total = $value[0]->barang[0]->harga * $value[0]['kuantitas'];
          $harga_total = $harga_total + ($value[0]->harga_barang * $value[0]['kuantitas']);
          @endphp

          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value[0]->barang[0]->nama}}</td>
      
            <td>{{$value[0]->barang[0]->suplier[0]['nama']}}</td>
                  <td>{{$value[0]['untuk']}}</td>
            <td>{{$value[0]->barang[0]->suplier[0]['nomor_hp']}}</td>
            <td>{{$value[0]->barang[0]->suplier[0]['alamat']}}</td>
            <td>@currency($value[0]->barang[0]->harga)</td>
            <td>{{$value[0]['kuantitas']}}</td>
            <td>@currency($total)</td>

          </tr>
          @endforeach
          <tr class="header-title">
            <td style="text-align: center;" colspan="8">Total</td>
            <td>@currency($harga_total)</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection