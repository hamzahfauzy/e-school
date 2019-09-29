<!DOCTYPE html>
<html>
<head>
	<title>Virtual Classroom</title>
	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>
<body>
	<div class="bg">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="custom-panel">
						<center>
							<h2>Test</h2>
							<a href="/virtual-classroom/finish/{{$virtualClassroom->id}}">Kelas Selesai</a>
						</center>
					</div>
				</div>
				<div class="col-sm-12 col-md-3">
					<div class="custom-panel left-panel">
						<div class="custom-panel panel-header">
							<h4 align="center">Live Chat</h4>
						</div>
						<div class="custom-panel panel-body panel-chat panel-scroll">
							<div class="container">
							  <img src="https://www.w3schools.com/w3images/bandmember.jpg" alt="Avatar">
							  <p>Hello. How are you today?</p>
							  <span class="time-right">11:00</span>
							</div>

							<div class="container darker">
							  <img src="https://www.w3schools.com/w3images/avatar_g2.jpg" alt="Avatar" class="right">
							  <p>Hey! I'm fine. Thanks for asking!</p>
							  <span class="time-left">11:01</span>
							</div>

							<div class="container">
							  <img src="https://www.w3schools.com/w3images/bandmember.jpg" alt="Avatar">
							  <p>Sweet! So, what do you wanna do today?</p>
							  <span class="time-right">11:02</span>
							</div>

							<div class="container darker">
							  <img src="https://www.w3schools.com/w3images/avatar_g2.jpg" alt="Avatar" class="right">
							  <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
							  <span class="time-left">11:05</span>
							</div>
						</div>
						<div class="messagebox" style="border-radius: 30px;border: 2px solid #eaeaea;margin:5px;">
							<input type="text" class="form-control message-text" placeholder="Message Here...">
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="custom-panel center-panel">
						<div class="custom-panel panel-header">
							<h4 align="center">Digital Board</h4>
						</div>
						<div class="custom-panel panel-body">
							<iframe class="digital-frame" frameborder="0" src="{{$virtualClassroom->file_url}}"></iframe>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-3">
					<div class="custom-panel right-panel">
						<div class="custom-panel panel-header">
							<h4 align="center">Absensi Kehadiran</h4>
						</div>
						<div class="custom-panel panel-body panel-scroll">
							<ul>
								<li>Siswa 1</li>
								<li>Siswa 2</li>
								<li>Siswa 3</li>
								<li>Siswa 4</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
								<li>Siswa 5</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>