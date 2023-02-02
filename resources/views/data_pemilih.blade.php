@extends('master')
@section('title','Daftar Pemilih')
@section('content_name','Daftar Pemilih')
@section('css_link')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('js_link_tambahan')
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
@section('content')
<div class="card">
     <div class="card-header">
         <h3 class="card-title">DataTable with minimal features & hover style</h3>
     </div>
     <div class="card-body">
        <table id="table" class="table table-bordered table-hover" style='font-size:12px'>
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>NKK</th>
                        <th>NIK</th>
                        <th>NAMA</th>
                        <th>TEMPAT LAHIR</th>
                        <th>TGL LAHIR</th>
                        <th>J.Kelamin</th>
                        <th>TPS</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      
                      
        </table>
</div>        
@endsection
@section('script_js_tambahan')
<script>
   $(function () {
    $('.loading').hide();
    $("#table").DataTable({
      processing:true,
      serverSide:true,
      ajax :'datapemilih/json',
      columns : [
        {data : 'id',name:'id'},
        {data : 'nkk',name:'nkk'},
        {data : 'nik',name:'nik'},
        {data : 'nama',name:'nama'},
        {data : 'tempat_lahir',name:'tempat_lahir'},
        {data : 'tgl_lahir',name:'tgl_lahir'},
        {data : 'jenis_kelamin',name:'jenis_kelamin'},
        {data : 'tps',name:'tps'} 
      ]
    });
   });
</script>
@endsection

