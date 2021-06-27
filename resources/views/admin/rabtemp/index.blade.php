@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card-box table-responsive">
      @role('admin')
      <div class="align-items-center">
        <a href="{{route('rab.index')}}"  class="btn btn-danger m-l-10 waves-light  mb-5">Kembali</a>
        <a href="#tambah-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-primary m-l-10 waves-light  mb-5">Tambah</a>
        <a href="#selesai-modal" data-animation="sign" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success m-l-10 waves-light selesai  mb-5">Selesai</a>

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
      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">

        <thead>
          <tr>
            <th>No.</th>
            <th>Nama barang</th>
            <th>Suplier</th>
            <th>Harga (Rp.)</th>
            <th>Kuantitas</th>
            <th>Total Harga (Rp.)</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rab AS $key=>$value)
          @php
          $harga_total = $harga_total + ($value->harga_barang * $value['kuantitas']);
          @endphp

          <tr>
            <td>{{$key+1}}</td>
            <td>{{$value->barang[0]->nama}}</td>
            <td>{{$value->barang[0]->suplier[0]['nama']}}</td>
            <td>{{$value->harga_barang}}</td>
            <td>{{$value['kuantitas']}}</td>
            <td>{{$value->barang[0]->harga * $value['kuantitas']}}</td>
            <td>
              <a href="#edit-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-nama="{{$value['nama']}}" data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-success btn-sm modal_edit"><i class="fa fa-edit"></i></a>
              <a href="#hapus-modal" data-animation="sign" data-plugin="custommodal" data-id='{{$value->id}}' data-overlaySpeed="100" data-overlayColor="#36404a" class="btn btn-danger btn-sm hapus"><i class="fa fa-trash"></i></a>


            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <input type="hidden" id="harga_total" value="{{$harga_total}}">
    </div>
  </div>
</div>
<!-- end row -->
<div id="tambah-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Tambah Data RAB</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('rabtemp.store')}}" method="POST">
        {{csrf_field()}}

        <div class="form-group">
          <label for="">Kategori Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="kategori" name="kategori">
              <option disabled selected>Pilih..</option>

              @foreach ($kategori as $key=>$value)
              <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Nama barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="nama_barang" name="nama_barang">
              <option disabled selected>Pilih..</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Nama suplier - Harga Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="nama_suplier" name="nama_suplier">
              <option disabled selected>Pilih..</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <!-- <label for="">Harga Barang</label> -->
          <div class="col-xs-12">
            <input class="form-control" type="hidden" readonly id="harga_barang" autocomplete="off" name="harga_barang" required="" placeholder="Harga Barang">
          </div>
        </div>

        <div class="form-group">
          <label for="">Kuantitas Barang</label>
          <div class="col-xs-12">
            <input class="form-control" min="0" type="number" autocomplete="off" name="kuantitas" required="" placeholder="Kuantitas Barang">
          </div>
        </div>

        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Tambah</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<div id="edit-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Edit Barang RAB </h4>
    </div>
    <div class="p-20 text-left">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('rabtemp.update')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="id" id="edit_id">

        <div class="form-group">
          <label for="">Kategori Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="edit_kategori" name="kategori">
              <option disabled selected>Pilih..</option>

              @foreach ($kategori as $key=>$value)
              <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Nama barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="edit_nama_barang" name="nama_barang">
              <option disabled selected>Pilih..</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Nama suplier - Harga Barang</label>
          <div class="col-xs-12">
            <select required class="form-control" id="edit_nama_suplier" name="nama_suplier">
              <option disabled selected>Pilih..</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <!-- <label for="">Harga Barang</label> -->
          <div class="col-xs-12">
            <input class="form-control" min="0" type="hidden" readonly id="edit_harga_barang" autocomplete="off" name="harga_barang" required="" placeholder="Harga Barang">
          </div>
        </div>


        <div class="form-group">
          <label for="">Kuantitas Barang</label>
          <div class="col-xs-12">
            <input class="form-control" min="0" type="number" id="edit_kuantitas" autocomplete="off" name="kuantitas" required="" placeholder="Kuantitas Barang">
          </div>
        </div>

        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light ubah_button" type="submit">Ubah</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<div id="hapus-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Hapus barang</h4>
    </div>
    <div class="p-20">

      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('rabtemp.hapus')}}" method="POST">
        {{csrf_field()}}
        <div>
          <input type="hidden" id='id_hapus' name='id'>
          <h5 id="exampleModalLabel">Apakah anda yakin ingin mengapus barang ini?</h5>
        </div>

        <div class="form-group text-center m-t-30">
          <div class="col-xs-6">
            <button type="button" onclick="Custombox.close();" class="   btn btn-primary btn-bordred btn-block waves-effect waves-light">Tidak</button>
            <button class="btn btn-danger btn-bordred btn-block waves-effect waves-light" type="submit">Hapus</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<div id="selesai-modal" class="modal-demo">
  <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
  </button>

  <div class="custom-modal-text">

    <div class="text-center">
      <h4 class="text-uppercase font-bold mb-0">Simpan Sebagai RAB Baru</h4>
    </div>
    <div class="p-20 text-left">
      <form class="form-horizontal m-t-20" enctype="multipart/form-data" action="{{route('rabtemp.selesai')}}" method="POST">
        {{csrf_field()}}


        <div class="form-group">
          <label>Nama Proyek RAB</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" autocomplete="off" name="nama" required="" placeholder="Nama Proyek">
          </div>
        </div>

        <div class="form-group">
          <label>Harga Total Proyek (Rp.)</label>
          <div class="col-xs-12">
            <input class="form-control" type="text" readonly autocomplete="off" name="harga_total" id="total" required="" placeholder="Harga Total">
          </div>
        </div>

        <div class="form-group text-center m-t-30">
          <div class="col-xs-12">
            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light" type="submit">Tambah</button>
          </div>
        </div>


      </form>

    </div>
  </div>

</div>

<script type="text/javascript">
  // ajax untuk tambah baru
  // get data nama barang by kategori
  document.getElementById('kategori').addEventListener("change", function() {
    $('#nama_barang').html('')
    $.ajax({
      url: '{{url("GetBarangByKategori")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        var opt_barang_empt = new Option('Pilih..')
        $('#nama_barang').append(opt_barang_empt)

        data.forEach(element => {
          var opt_barang = new Option(element['nama'], element['nama'])
          // add to option nama_barang
          $('#nama_barang').append(opt_barang)
        });

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // get data nama suplier by nama barang
  document.getElementById('nama_barang').addEventListener("change", function() {
    $('#nama_suplier').html('')
    $.ajax({
      url: '{{url("GetSuplierByNamaBarang")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        var opt_suplier_empt = new Option('Pilih..')
        $('#nama_suplier').append(opt_suplier_empt)
        data.forEach(element => {
          var opt_barang = new Option(element['suplier'][0]['nama'] + ' - Rp. '+ element['harga'], element['id'])
          // add to option nama_barang
          $('#nama_suplier').append(opt_barang)

        });

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // get data harga barang by nama barang dan nama suplier
  document.getElementById('nama_suplier').addEventListener("change", function() {
    $('#harga_barang').html('')

    $.ajax({

      url: '{{url("GetBarangById")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#harga_barang').val(data['harga'])
      },
      error: function(data) {
        $('#harga_barang').val('')
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // =============end ajax tambah================

  // ajax untuk edit
  $('.modal_edit').click(function() {
    var id = $(this).data('id');
    $('#edit_id').val(id)
    $('#edit_nama_barang').html('')
    $('#edit_nama_suplier').html('')
    $('#edit_harga_barang').html('')
    $.ajax({
      url: '{{url("rabtemp/edit")}}/' + id,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#edit_id').val(id)
        $('#edit_kuantitas').val(data['rabTemp']['kuantitas'])
        $('#edit_kategori').val(data['barang'][0]['id_kategori'])
        // harga barang
        $('#edit_harga_barang').val(data['rabTemp']['harga_barang'])

        // list nama barang
        var opt_barang_empt = new Option('Pilih..')
        $('#edit_nama_barang').append(opt_barang_empt)
        data['barangs'].forEach(element => {
          console.log(element);
          var opt_barang = new Option(element['nama'], element['nama'])
          // add to option nama_barang
          $('#edit_nama_barang').append(opt_barang)
        });
        $('#edit_nama_barang').val(data['barang'][0]['nama'])

        // list nama suplier
        var opt_supl_empt = new Option('Pilih..')
        $('#edit_nama_suplier').append(opt_supl_empt)
        data['supliers'].forEach(element => {

          var opt_suplier = new Option(element['suplier'][0]['nama'] + ' - Rp. '+ element['harga'], element['id'])
          // add to option suplier
          $('#edit_nama_suplier').append(opt_suplier)
        });
        $('#edit_nama_suplier').val(data['barang'][0]['id'])

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })

  });

  // get data nama barang by kategori
  document.getElementById('edit_kategori').addEventListener("change", function() {
    $('#edit_nama_barang').html('')
    $('#edit_harga_barang').val('')
    $.ajax({
      url: '{{url("GetBarangByKategori")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        var opt_barang_empt = new Option('Pilih..')
        $('#edit_nama_barang').append(opt_barang_empt)

        data.forEach(element => {
          var opt_barang = new Option(element['nama'], element['nama'])
          // add to option nama_barang
          $('#edit_nama_barang').append(opt_barang)
        });

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // get data nama suplier by nama barang
  document.getElementById('edit_nama_barang').addEventListener("change", function() {
    $('#edit_nama_suplier').html('')
    $('#edit_harga_barang').val('')
    $.ajax({
      url: '{{url("GetSuplierByNamaBarang")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        var opt_suplier_empt = new Option('Pilih..')
        $('#edit_nama_suplier').append(opt_suplier_empt)
        data.forEach(element => {
          var opt_barang = new Option(element['suplier'][0]['nama'] + ' - Rp. '+ element['harga'], element['id'])
          // add to option nama_barang
          $('#edit_nama_suplier').append(opt_barang)

        });

      },
      error: function(data) {
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  // get data harga barang by nama barang dan nama suplier
  document.getElementById('edit_nama_suplier').addEventListener("change", function() {
    $('#edit_harga_barang').html('')

    $.ajax({
      url: '{{url("GetBarangById")}}/' + this.value,
      type: 'GET',
      dataType: 'json',
      success: 'success',
      success: function(data) {
        $('#edit_harga_barang').val(data['harga'])

      },
      error: function(data) {
        $('#edit_harga_barang').val('')
        toastr.error('Gagal memanggil data! ')
      }
    })
  })

  $('.hapus').click(function() {
    var id = $(this).data('id');
    $('#id_hapus').val(id);
  });


  $('.selesai').click(function() {
    var harga = document.getElementById('harga_total').value
    $('#total').val(harga);
  });
</script>
@endsection