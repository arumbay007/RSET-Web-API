<?php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=buku", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM tabel_buku ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["judul"]))
		{
			$form_data = array(
				':judul'		=>	$_POST["judul"],
				':pengarang'	=>	$_POST["pengarang"],
				':penerbit'		=>	$_POST["penerbit"],
				':tahun_terbit'	=>	$_POST["tahun_terbit"]
			);
			$query = "
			INSERT INTO tabel_buku 
			(judul, pengarang, penerbit, tahun_terbit) VALUES 
			(:judul, :pengarang, :penerbit, :tahun_terbit)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM tabel_buku WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['judul'] = $row['judul'];
				$data['pengarang'] = $row['pengarang'];
				$data['penerbit'] = $row['penerbit'];
				$data['tahun_terbit'] = $row['tahun_terbit'];
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["judul"]))
		{
			$form_data = array(
				':judul'	=>	$_POST['judul'],
				':pengarang'	=>	$_POST['pengarang'],
				':penerbit'	=>	$_POST['penerbit'],
				':tahun_terbit'	=>	$_POST['tahun_terbit'],
				':id'			=>	$_POST['id']
			);
			$query = "
			UPDATE tabel_buku 
			SET judul = :judul, pengarang = :pengarang, penerbit = :penerbit, tahun_terbit = :tahun_terbit 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM tabel_buku WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>