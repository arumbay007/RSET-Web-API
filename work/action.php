<?php

//action.php

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'insert')
	{
		$form_data = array(
			'judul' 		=>	$_POST['judul'],
			'pengarang'		=>	$_POST['pengarang'],
			'penerbit'		=>	$_POST['penerbit'],
			'tahun_terbit'	=>	$_POST['tahun_terbit']
		);
		$api_url = "http://localhost/rest/api/test_api.php?action=insert";  // sesuaikan dengan tempat file php anda disimpan
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_POST, true);
		curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		curl_close($client);
		$result = json_decode($response, true);
		foreach($result as $keys => $values)
		{
			if($result[$keys]['success'] == '1')
			{
				echo 'insert';
			}
			else
			{
				echo 'error';
			}
		}
	}

	if($_POST["action"] == 'fetch_single')
	{
		$id = $_POST["id"];
		$api_url = "http://localhost/rest/api/test_api.php?action=fetch_single&id=".$id."";  //change this url as per your folder path for api folder
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		echo $response;
	}
	if($_POST["action"] == 'update')
	{
		$form_data = array(
			'judul' 		=>	$_POST['judul'],
			'pengarang'		=>	$_POST['pengarang'],
			'penerbit'		=>	$_POST['penerbit'],
			'tahun_terbit'	=>	$_POST['tahun_terbit'],
			'id'			=>	$_POST['hidden_id']
		);
		$api_url = "http://localhost/rest/api/test_api.php?action=update";  // sesuaikan dengan tempat file php anda disimpan
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_POST, true);
		curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		curl_close($client);
		$result = json_decode($response, true);
		foreach($result as $keys => $values)
		{
			if($result[$keys]['success'] == '1')
			{
				echo 'update';
			}
			else
			{
				echo 'error';
			}
		}
	}
	if($_POST["action"] == 'delete')
	{
		$id = $_POST['id'];
		$api_url = "http://localhost/rest/api/test_api.php?action=delete&id=".$id.""; // sesuaikan dengan tempat file php anda disimpan
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		echo $response;
	}
}


?>