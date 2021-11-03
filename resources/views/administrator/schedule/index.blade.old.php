<!DOCTYPE html>
<html>
<head>
	<title>Tutorial Membuat CRUD Pada Laravel - www.malasngoding.com</title>
</head>
<body>

	<h2>www.malasngoding.com</h2>
	<h3>Data schedule</h3>

	<a href="/schedule/tambah"> + Tambah schedule Baru</a>
	
	<br/>
	<br/>

	<table border="1">
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Tanggal Lahir</th>
			<th>Opsi</th>
		</tr>
		@foreach($schedule as $p)
		<tr>
			<td>{{ $p->nama }}</td>
			<td>{{ $p->alamat }}</td>
			<td>{{ $p->tgllhr }}</td>
			<td>
				<a href="/schedule/edit/{{ $p->id }}">Edit</a>
				|
				<a href="/schedule/hapus/{{ $p->id }}">Hapus</a>
			</td>
		</tr>
		@endforeach
	</table>


</body>
</html>