@extends('master')
@section('title','Penetapan')
@section('content_name','Penetapan')
@section('css_link')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('js_link_tambahan')
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jquery-form/jquery.form.js') }}"></script>
@endsection
@section('content')
<div class="card">
     <div class="card-header">
      @if(!empty($kd_kec))
        {{ $kd_kec }} /
        {{ $kd_kel }}
      @endif  
        <div class="form-inline form-group">
            <label for=""></label>
            <select class="custom-select" name="combo_kec" id="combo_kec">
                @foreach ($kecamatan_data as $item)
                    <option value="{{ $item->kd_kec }}">{{$item->nama }}</option>
                @endforeach
            </select>&nbsp;
            <select class="custom-select" name="combo_kel" id="combo_kel"></select>&nbsp;
            <select class="custom-select" name="combo_tps" id="combo_tps"></select>&nbsp;
            <a id="btn_filter" class="btn btn-primary" href="#" role="button" >Filter</a>&nbsp;
            <a id="btn_import" class="btn btn-success" href="#" role="button" data-toggle="modal" data-target="#modal_import">Import Data</a>
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
                        <th>Kecamatan</th>
                        <th>Desa/Kel</th>
                        <th>TPS</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      
                      
        </table>
</div>    

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Dp4 Csv <span id="kode_kecx"> </span> / <span id="kode_kelx"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="post" action="penetapan/import" id="fdp4_upload" enctype="multipart/form-data"> 
         @csrf
            <div class="form-group">
                <label for="file">Pilih File CSV</label>
                <input type="file" class="form-control-file" id="file" name="file">
                <input type="hidden" name="kd_kec" id="kd_kec">
                <input type="hidden" name="nama_kec" id="nama_kec">
                <input type="hidden" name="kd_kel" id="kd_kel">
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
   $(function () {
     
     @if(!empty($kd_kec))
     $('.loading').hide();
        $("#combo_kec").val("{{ $kd_kec }}");
        $("#kode_kecx").html($("#combo_kec option:selected" ).text());
        $("#kd_kec").val({{ $kd_kec }}); 
        $.ajax({
              dataType: 'json',
              data : {'kd_kec' : {{ $kd_kec }},'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'penetapan/get_kel',
              success: function(datax) {
                    $("#combo_kel").empty();
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_kel").append('<option value=' + value.kd_kel_des + '>' + value.nama + '</option>');
                    });
                    $("#combo_kel").val({{ $kd_kel }});
                    $("#kd_kel").val({{ $kd_kel }});
                    $("#kode_kelx").html($("#combo_kel option:selected" ).text());
              }
            });
        
     
     @else
     $('.loading').hide();
     if($("#kd_kec").val()==""){      
     $("#combo_kec").val({{ $kecamatan_data->first()->kd_kec }}); 
     $("#kd_kec").val({{ $kecamatan_data->first()->kd_kec }}); 
     $("#kode_kecx").html($("#combo_kec option:selected" ).text());
     $.ajax({
              dataType: 'json',
              data : {'kd_kec' : {{ $kecamatan_data->first()->kd_kec }},'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'penetapan/get_kel',
              success: function(datax) {
                    $("#combo_kel").empty();
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_kel").append('<option value=' + value.kd_kel_des + '>' + value.nama + '</option>');
                    });
                    $("#kd_kel").val($('#combo_kel option:first').val());
                    
                    $("#kode_kelx").html($("#combo_kel option:selected" ).text());
              }
            });
       }
      @endif
     
     
     
    $("#table").DataTable({
      processing:true,
      serverSide:true,
      ajax :{
        @if(!empty($kd_kec))
         data:{'kd_kec':{{ $kd_kec }},'kd_kel':{{ $kd_kel }}},
         @endif
         url : 'penetapan/json'
         
      },
      columns : [
        {data : 'id',name:'id'},
        {data : 'nkk',name:'nkk'},
        {data : 'nik',name:'nik'},
        {data : 'nama',name:'nama'},
        {data : 'tempat_lahir',name:'tempat_lahir'},
        {data : 'tgl_lahir',name:'tgl_lahir'},
        {data : 'jenis_kelamin',name:'jenis_kelamin'},
        {data : 'kd_kec',name:'kd_kec'},
        {data : 'kd_kel',name:'kd_kel'},
        {data : 'tps',name:'tps'} 
      ]
     });
     $("#combo_kec").change(function(){
            
            $("#kd_kec").val($(this).val());
            var kd_kec = $(this).val();
             $("#kode_kecx").html($("#combo_kec option:selected" ).text());
             
             $.ajax({
              dataType: 'json',
              data : {'kd_kec' : kd_kec,'_token':"{{ csrf_token() }}"},
              method: "POST",
              url: 'penetapan/get_kel',
              success: function(datax) {
                    $("#combo_kel").empty();
                    $.each(datax,function(key, value) 
                    {
                        $("#combo_kel").append('<option value=' + value.kd_kel_des + '>' + value.nama + '</option>');
                    });
                     $("#kd_kel").val($('#combo_kel option:first').val());
                    $("#kode_kelx").html($("#combo_kel option:selected" ).text());
              }
            });
     });
      $("#combo_kel").change(function(){
            
            $("#kd_kel").val($(this).val());
            var kd_kel = $(this).val();
             $("#kode_kelx").html($("#combo_kel option:selected" ).text());
      });
     $("#btn_proses").click(function(){
         $('#fdp4_upload').submit();
     });
     $('#btn_filter').click(function(){
         var kd_kec = $('#combo_kec').val();
         var kd_kel = $('#combo_kel').val();
         location.href="penetapan?kd_kec="+kd_kec+"&kd_kel="+kd_kel;
         
     })
   });
</script>
@endsection

