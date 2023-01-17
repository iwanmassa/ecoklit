@extends('master')
@section('title','DP4')
@section('content_name','DP4')
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
      
        <div class="form-inline form-group">
            <label for=""></label>
            <select class="custom-select" name="combo_kec" id="combo_kec">
                @foreach ($kecamatan_data as $item)
                    <option value="{{ $item->kd_kec }}">{{$item->nama }}</option>
                @endforeach
            </select>&nbsp;
            <select class="custom-select" name="combo_kel" id="combo_kel"></select>&nbsp;
            <select class="custom-select" name="combo_tps" id="combo_tps"></select>&nbsp;
            
            <a name="" id="btn_filter" class="btn btn-primary" href="#" role="button" >Filter</a>&nbsp;
            <a name="" id="btn_settps2019" class="btn btn-primary" href="#" role="button" >Set TPS 2019</a>&nbsp;
            <a name="" id="btn_import" class="btn btn-primary" href="#" role="button" data-toggle="modal" data-target="#modal_import">Import Data</a>&nbsp;
            
        </div>
        @if(isset($status))
            <div class="alert alert-primary" role="alert">
            {{ $status }}
            </div>
        @endif
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
                         <th>Alamat</th>
                         <th>RT</th>
                         <th>RW</th>
                        <th>TPS</th>
                        <th>TPS NEW</th>
                        <th>KET</th>                        
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      
                      
        </table>
</div>    
{{-- Summary --}}
<br>
<div class="card">
     <div class="card-header">
      <H3>Ringkasan Data :</h3>   
     </div>
     <div class="card-body">
     <div class="row">
     <div class="col-4">
        <h4>TPS PEMILU 2019</h4>
        <table id="table_summary" class="table table-bordered table-hover" style='font-size:12px'>
                      <thead>
                      <tr>
                        <th colspan="2">DPTHP2 2019</th>
                      </tr>
                      <tr>
                        <th>No TPS</th>
                        <th>Jumlah Pemilih</th>        
             
                      </tr>
                      </thead>
                      <tbody>
                      @if(!empty($sum_tps_2019))
                      @foreach ($sum_tps_2019 as $item)

                        <tr>    <td>{{ $item->tps }}</td><td>{{$item->total }}</td> </tr>
                      @endforeach
                      @endif
                      </tbody>
                      
                      
        </table>
        </div>
        <div class="col-4">
        <h4>TPS PEMILU 2024</h4>
        <table id="table_summary" class="table table-bordered table-hover" style='font-size:12px'>
                      <thead>
                      <tr>
                        <th colspan="2">DP4 2023</th>
                      </tr>
                      <tr>
                        <th>No TPS</th>
                        <th>Jumlah Pemilih</th>        
             
                      </tr>
                      </thead>
                      <tbody>
                      @if(!empty($sum_tps_2024))
                      @foreach ($sum_tps_2024 as $item)

                        <tr>    <td>{{ $item->tps_new }}</td><td>{{$item->total }}</td> </tr>
                      @endforeach
                      @endif
                      </tbody>
                      
                      
        </table>
        </div>
        </div>
</div>  
{{-- End Summary --}}

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Dp4 Csv <span id="kode_kecx"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="post" action="dp4/import" id="fdp4_upload" enctype="multipart/form-data"> 
         @csrf
            <div class="form-group">
                <label for="file">Pilih File CSV</label>
                <input type="file" class="form-control-file" id="file" name="file">
                <input type="hidden" name="kd_kec" id="kd_kec">
                <input type="hidden" name="nama_kec" id="nama_kec">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_proses">Proses</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script_js_tambahan')
<script>
   $(document).ready(function () {
    $('.loading').hide();

    {{-- Jika Sesi Telah Ada  --}}
     @if(isset($sesi["kd_kec"]))
        $("#combo_kec").val("{{ $sesi['kd_kec'] }}");
        $.ajax({
              dataType: 'json',
              data : {'kd_kec' : {{ $sesi['kd_kec'] }},'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'dp4/get_kel',
              success: function(datax) {
                    $("#combo_kel").empty();
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_kel").append('<option value=' + value.kd_kel_des + '>' + value.nama + '</option>');
                    });
                    $("#combo_kel").val("{{ $sesi['kd_kel'] }}");
                    $("#kd_kel").val("{{ $sesi['kd_kel'] }}");
                    $.ajax({
                        dataType: 'json',
                        data : {'kd_kec' : {{ $sesi['kd_kec'] }},'kd_kel' : {{ $sesi['kd_kel'] }},'_token':"{{ csrf_token() }}"},
                        method: "POST",
                        url: 'dp4/get_tps',
                        success: function(datax_tps) {
                          $("#combo_tps").empty();
                          $("#combo_tps").append('<option value=ALL>ALL</option>');
                          $.each(datax_tps,function(key, value) 
                          {
                              $("#combo_tps").append('<option value=' + value.tps_new + '>' + value.tps_new + '</option>');
                          });
                          $("#combo_tps").val('{{ $sesi['tps'] }}');
                        }
                    });
              }
            });
        $("#table").DataTable({
      processing:true,
      serverSide:true,
       ajax :{
        @if(!empty($kd_kec))
            @if($tps=="ALL")
               data:{'kd_kec':'{{ $kd_kec }}','kd_kel':'{{ $kd_kel }}'},
            @else
               data:{'kd_kec':'{{ $kd_kec }}','kd_kel':'{{ $kd_kel }}','tps':'{{ $tps }}'},
            @endif   
         @endif
         url : 'dp4/json'
         
      },
      columns : [
        {data : 'id',name:'id'},
        {data : 'nkk',name:'nkk'},
        {data : 'nik',name:'nik'},
        {data : 'nama',name:'nama'},
        {data : 'tempat_lahir',name:'tempat_lahir'},
        {data : 'tgl_lahir',name:'tgl_lahir'},
        {data : 'jenis_kelamin',name:'jenis_kelamin'},
        {data : 'alamat',name:'alamat'},
        {data : 'rt',name:'rt'},
        {data : 'rw',name:'rw'},
        {data : 'tps',name:'tps'},
        {data : 'tps_new',name:'tps_new'}, 
         {data : 'ket',name:'ket'} 
      ]
     });
     
     @else
     {{-- Jika Sesi Belum Ada --}}
      
     $("#combo_kec").val($('#combo_kec option:first').val());
     
     //set hidden kd_kec di form modal
     $("#kd_kec").val("{{ $kecamatan_data->first()->kd_kec }}"); 
     
     //ambil data kel/desa
     $.ajax({
              dataType: 'json',
              data : {'kd_kec' : {{ $kecamatan_data->first()->kd_kec }},'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'dp4/get_kel',
              success: function(datax) {
                    $("#combo_kel").empty();
                    $("#combo_kel").append('<option value=ALL>ALL</option>');
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_kel").append('<option value=' + value.kd_kel_des + '>' + value.nama + '</option>');
                    });
                    $("#kd_kel").val($('#combo_kel option:first').val());
                    $("#combo_kel").val($('#combo_kel option:first').val());
                    //ambil data tps
                    $.ajax({
                        dataType: 'json',
                        data : {'kd_kec' : {{ $kecamatan_data->first()->kd_kec }},'kd_kel':$('#combo_kel option:first').val(),'_token':"{{ csrf_token() }}"},
                        method: "POST",
                        url: 'dp4/get_tps',
                        success: function(datax_tps) {
                          $("#combo_tps").empty();
                          $("#combo_tps").append('<option value=ALL>ALL</option>');
                          $.each(datax_tps,function(key, value) 
                          {
                              $("#combo_tps").append('<option value=' + value.tps_new + '>' + value.tps_new + '</option>');
                          });
                        }
                    });
              }
            });
            $("#table").DataTable({
                processing:true,
                serverSide:true,
                ajax :{
                       data:{'kd_kec':$('#combo_kec').val()},
                       url : 'dp4/json'
                  
                },
                columns : [
                  {data : 'id',name:'id'},
                  {data : 'nkk',name:'nkk'},
                  {data : 'nik',name:'nik'},
                  {data : 'nama',name:'nama'},
                  {data : 'tempat_lahir',name:'tempat_lahir'},
                  {data : 'tgl_lahir',name:'tgl_lahir'},
                  {data : 'jenis_kelamin',name:'jenis_kelamin'},
                  {data : 'alamat',name:'alamat'},
                  {data : 'rt',name:'rt'},
                  {data : 'rw',name:'rw'},
                  {data : 'tps',name:'tps'},
                  {data : 'tps_new',name:'tps_new'}, 
                  {data : 'ket',name:'ket'} 
                ]
          });
      @endif
    
     $("#combo_kec").change(function(){
            $("#kd_kec").val($(this).val());
            $("#kode_kecx").html($(this).val());
            var kd_kec = $(this).val();
            $.ajax({
              dataType: 'json',
              data : {'kd_kec' : kd_kec,'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'dp4/get_kel',
              success: function(datax) {
                    $("#combo_kel").empty();
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_kel").append('<option value=' + value.kd_kel_des + '>' + value.nama + '</option>');
                    });
                     $("#kd_kel").val($('#combo_kel option:first').val());
              }
            });
     });
         $("#combo_kel").change(function(){
            $("#kd_kel").val($(this).val());
            $("#kode_kelx").html($(this).val());
            var kd_kec = $('#combo_kec').val();
            var kd_kel = $(this).val();
            $.ajax({
              dataType: 'json',
              data : {'kd_kec' : kd_kec,'kd_kel' : kd_kel,'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'dp4/get_tps',
              success: function(datax) {
                    $("#combo_tps").empty();
                    $("#combo_tps").append('<option value=ALL>ALL</option>');
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_tps").append('<option value=' + value.tps_new + '>' + value.tps_new + '</option>');
                    });
                     $("#combo_tps").val("ALL");
              }
            });
     });
     $("#btn_proses").click(function(){
         $('#fdp4_upload').submit();
     });
   });
   $('#btn_filter').click(function(){
         var kd_kec = $('#combo_kec').val();
         var kd_kel = $('#combo_kel').val();
         var tps = $('#combo_tps').val();
         $.ajax({
                        dataType: 'json',
                        data: {'kd_kec' : kd_kec,'kd_kel' : kd_kel,'tps' : tps},
                        url: 'dp4/set_filter_table'
          });

         //$('#table').DataTable().ajax.reload();
         location.reload();
        
         
     })
     $('#btn_settps2019').click(function(){
         var kd_kec = $('#combo_kec').val();
         var kd_kel = $('#combo_kel').val();
          $.ajax({
              dataType: 'json',
              data : {'kd_kec' : kd_kec,'kd_kel' : kd_kel,'_token':"{{ csrf_token() }}"},
              method: "POST",
              beforeSend: function() {
                $('.loading').show();
              },
              url: 'dp4/gettps2019',
              success: function(datax) {
                     $('.loading').hide();
                     //alert(datax.pesan);
                     location.href="dp4/"+kd_kec+"/"+kd_kel;
              }
          });

        
         
     })
</script>
@endsection
