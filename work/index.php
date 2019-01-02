<!DOCTYPE html>
<html>
	<head>
		<title> Data Buku </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<br />
			
			<h2> Data Buku | REST Web API </h2> <hr /> 
			<br />
			<div align="left" style="margin-bottom:5px;">
				<button type="button" name="add_button" id="add_button" class="btn btn-success btn-sm"> Tambah Data Buku </button>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th> Judul Buku </th>
							<th> Pengarang </th>
							<th> Penerbit </th>
							<th> Tahun Terbit </th>
							<th> Ubah </th>
							<th> Hapus </th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</body>
</html>

<div id="apicrudModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="api_crud_form">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title"> Tambah </h4>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
			        	<label> Judul Buku </label>
			        	<input type="text" name="judul" id="judul" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label> Pengarang </label>
			        	<input type="text" name="pengarang" id="pengarang" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label> Penerbit </label>
			        	<input type="text" name="penerbit" id="penerbit" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label> Tahun Terbit </label>
			        	<input type="date" name="tahun_terbit" id="tahun_terbit" class="form-control" />
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<input type="hidden" name="hidden_id" id="hidden_id" />
			    	<input type="hidden" name="action" id="action" value="Tambah" />
			    	<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Tambah" />
			    	<button type="button" class="btn btn-default" data-dismiss="modal"> Tutup </button>
	      		</div>
			</form>
		</div>
  	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){

	fetch_data();

	function fetch_data()
	{
		$.ajax({
			url:"fetch.php",
			success:function(data)
			{
				$('tbody').html(data);
			}
		})
	}

	$('#add_button').click(function(){
		$('#action').val('insert');
		$('#button_action').val('Insert');
		$('.modal-title').text('Tambah Data Baru');
		$('#apicrudModal').modal('show');
	});

	$('#api_crud_form').on('submit', function(event){
		event.preventDefault();
		if($('#judul').val() == '')
		{
			alert("Masukkan Judul Buku");
		}
		else if($('#pengarang').val() == '')
		{
			alert("Masukkan Pengarang");
		}
		else if($('#penerbit').val() == '')
		{
			alert("Masukkan Penerbit");
		}
		else if($('#tahun_terbit').val() == '')
		{
			alert("Masukkan Tahun Terbit");
		}
		else
		{
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					fetch_data();
					$('#api_crud_form')[0].reset();
					$('#apicrudModal').modal('hide');
					if(data == 'insert')
					{
						alert("Data Berhasil Di Tambah");
					}
					if(data == 'update')
					{
						alert("Data Berhasil Di Perbahrui");
					}
				}
			});
		}
	});

	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#hidden_id').val(id);
				$('#judul').val(data.judul);
				$('#pengarang').val(data.pengarang);
				$('#penerbit').val(data.penerbit);
				$('#tahun_terbit').val(data.tahun_terbit);
				$('#action').val('update');
				$('#button_action').val('Update');
				$('.modal-title').text('Edit Data');
				$('#apicrudModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = 'delete';
		if(confirm("Apakah Anda Yakin Menghapus Data ini ?"))
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data)
				{
					fetch_data();
					alert("Data Berhasil Di Hapus");
				}
			});
		}
	});

});
</script>