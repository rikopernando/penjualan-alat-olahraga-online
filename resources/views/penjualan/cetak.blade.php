<!DOCTYPE doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style type="text/css">
th,td{
	padding: 1px;
}


.table1, .th, .td {
	border: 1px solid black;
	font-size: 15px;
	font: verdana;
}


</style>
<body>

	<div class="container">
		<div class="row"><!--row1-->
			<div class="col-sm-2"></div><!--penutup colsm2-->
			<div class="col-sm-8">
				<center> 
                    <h3> <b>Satria Shop</b> </h3> 
					<p>
                        Bandar Lampung
                        <br>
						No.Telp : 0214-41414-3423
                     </p>
                    <h4> <b>Laporan Penjualan Periode {{$dari_tanggal}} Sampai {{$sampai_tanggal}}</b> </h4> 
                 </center>
		    </div><!--penutup colsm5-->
				</div><!--penutup row1-->
					<br>
					<table class="table table-bordered">
						<thead>
							<th class="table1"> ID Order </th>
							<th class="table1"> <center> Pelanggan </center> </th>
							<th class="table1"> <center> Waktu </center> </th>
							<th class="table1"> <center> Total </center> </th>
							<th class="table1"> <center> Status</center> </th>
						</thead>
						<tbody>
                          @foreach ($penjualan as $penjualan)
							<tr>
							<td class='table1'>{{$penjualan['id']}} </td>
							<td class='table1'>{{$penjualan['pelanggan']}} </td>
							<td class='table1'>{{$penjualan['waktu']}} </td>
							<td class='table1' align='right'>{{$penjualan['total']}}</td>
							<td class='table1'>{{$penjualan['status_pesanan']}}</td>
							</tr>
                          @endforeach
						</tbody>
					</table>
						<br>	
						<div class="row">
							<div class="col-sm-8">
								<p><b>Petugas, <br><br><br> <p>{{Auth::User()->name}}</p></b></p>
							</div> <!--/ col-sm-6-->
							<div class="col-sm-4">
								<table>
								<tbody>
								  <tr>
									<td width="50%">
                                        <p><b>Total Keseluruhan</b></p>
                                    </td>
                                    <td> :&nbsp;</td>
                                    <td class="text-right">
                                        <p><b>Rp. {{$total}}</b></p>
                                    </td>
                                   </tr>
								</tbody>
								</table>
							</div> <!--/ col-sm-6-->
							</div>
					</body>
					<!--   Core JS Files   -->
					<script src="{{ asset('js/app.js?v=26')}}" type="text/javascript"></script>

					<script>
						$(document).ready(function(){
							window.print();
						});
					</script>
					@yield('scripts')
					</html>

