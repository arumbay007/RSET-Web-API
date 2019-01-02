<?php

//fetch.php

$api_url = "http://localhost/rest/api/test_api.php?action=fetch_all"; // sesuaikan dengan tempat file php anda disimpan

$client = curl_init($api_url);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);

$result = json_decode($response);

$output = '';

if(count($result) > 0)
{
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$row->judul.'</td>
			<td>'.$row->pengarang.'</td>
			<td>'.$row->penerbit.'</td>
			<td>'.$row->tahun_terbit.'</td>
			<td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->id.'"> Ubah </button></td>
			<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->id.'"> Hapus </button></td>
		</tr>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center"> Data Tidak Di Temukan </td>
	</tr>
	';
}

echo $output;

?>