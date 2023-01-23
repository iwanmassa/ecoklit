@extends('master')
@section('title','TPS Manager')
@section('content_name','TPS Manager')
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
         <h3 class="card-title"></h3>
     </div>
     <div class="card-body">
          <table class="table" style='font-size:12px'>
            <thead>
                <tr>
                    <th>Desa</th>
                    <th>TPS</th>
                </tr>
            </thead>
            <tbody>
             @foreach ($kel_tps as $item )
                <tr>
                    <td >{{ $item['nama'] }}</td>
                    <td>
                    <table class="table" style='' id="tabletps_{{ $item['kel_des'] }}">
                        <tbody>
                         @foreach ($item['tps'] as $item_tps)
                             
                         
                            <tr>
                                <td><span id='tps{{ $item_tps['no_tps']}}' tambahan=false id_tps='{{ $item_tps['no_tps'] }}'>{{ $item_tps['no_tps']}}</span>
                                </td>
                                <td>@if($item_tps['sts']==0)
                                <a heff="#" id_tps='{{ $item_tps['id'] }}' class="btn btn-primary">Aktifkan</a>
                                @else
                                <a heff="#" id_tps='{{ $item_tps['id'] }}' class="btn btn-danger">Disable</a>
                                @endif
                                </td>
                                <td>
                                @if($item_tps['sts']==0)
                                        <a heff="#" id_tps='{{ $item_tps['id'] }}' class="btn btn-danger">Hapus</a>
                                @endif
                                </td>
                            </tr>
                         @endforeach
                         </tbody>
                    </table>
                    </td>
                   
                </tr>
              
              @endforeach
                
              
            </tbody>
          </table>
         
    </div>      
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

