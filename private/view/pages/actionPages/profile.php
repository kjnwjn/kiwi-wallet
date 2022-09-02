<div class="container mt-5">
	<header class="text-center bg-light text-primary py-3 my-4 rounded">
		<h3 class="display-5 font-weigh3t-bold mb-1 ">PROFILE</h3>
	</header>

	<div class="row">
		<div class="col-md-6 col-lg-8 left-content">
			<div class="table-responsive">
				<form id="form" method="POST" onSubmit="return false" novalidate>
					<table class="table editProfile">
					</table>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Upload ID image</button>
					<!-- <button class="btn btn-info btn-removeAll">Reset</button> -->
				</form>
			</div>
		</div>
		
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="modal-editProfile">
							<div class="form-group">
								<label for="idCard_front">Card image front</label>
								<input type="file" class="form-control" id="idCard_front" name="idCard_front" >
							</div>
							<div class="form-group">
								<label for="idCard_back">Card image front</label>
								<input type="file" class="form-control" id="idCard_back" name="idCard_back" >
							</div>
								
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="updateImage()">Submit</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-4 right-content">
			<div class="row">
				<div class="col-3">
					<img src="../../../../public/assest/img/1-male.jpg" alt="">
				</div>
				<div class="col-9 user-infomation">
					<a href="<?= getenv('BASE_URL') ?>profile">info</a>
					<p>user</p>
				</div>
			</div>
			<div>
				<ul class="menu menu-info">

				</ul>
			</div>
		</div>
	</div>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/main.js"> </script>

<script>
	const form = $('#form')
	const url = 'http://localhost/api/service/recharge'
	const urlUserProfile = 'http://localhost/api/account/profile/'


	function renderData(url = '') {
		fetch(url)
			.then(response => response.json())
			.then(response => {
				if (response.status == true) {
					const birthday = createdTime(response.response.birthday)
					$('.user-infomation').html(`
						<a href="#">info</a>
						<p>${response.response.fullname}</p>
					`)
					$('.menu-info').html(`
						<li class="text-center" >status: <h5 class="text-success">${response.response.role}</h5></li>
						
					`)

					$('.editProfile').html(`
					<tr>
							<td>email</td>
							<td>
								<h5 id="email" name="email">${response.response.email}</h5>
							</td>
						</tr>
						<tr>
							<td>Phone Number</td>
							<td>
								<h5 id="phoneNumber" name="phoneNumber"> ${response.response.phoneNumber}</h5>
							</td>
						</tr>

						<tr>
							<td>Full name</td>
							<td>
								<h5 id="fullname" name="fullname">${response.response.fullname}</h5>
							</td>
						</tr>

						<tr>
							<td>Gender</td>
							<td>
								<h5 id="gender" name="gender" >${response.response.gender}</h5>
							</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>
								<h5 id="address" name="address"> ${response.response.address}</h5>
							</td>
						</tr>
						<tr>
							<td>Birthday</td>
							<td>
								<h5 id="birthday" name="birthday" >${birthday}</h5>
							</td>
						</tr>
						<tr>
							<td>Card Image 1</td>
							<td>
								<img src="${response.response.idCard_front}" alt="Do not have image" width="200" height="200">
							</td>
						</tr>
						<tr>
							<td>Card Image 2</td>
							<td>
								<img src="${response.response.idCard_back}" alt="Do not have image" width="200" height="200">
							</td>
						</tr>
					
					`)
					
				}
			})
	}
	renderData(urlUserProfile)
	
	function updateImage() {
		const urlUploadImage = 'http://localhost/api/account/upload-image'
		const idCard_front = document.querySelector('#idCard_front')
		const idCard_back = document.querySelector('#idCard_back')
		var formData = new FormData();
		formData.append('idCard_front',idCard_front.files[0]);
		formData.append('idCard_back',idCard_back.files[0]);
		submitFormdata(formData,urlUploadImage);
	}
	$('.btn-removeAll').click(function() {
		$('#card_id').val('')
		$('#expiredDay').val('')
		$('#cvv').val('')
		$('#money').val('')

	})

	function createdTime(time){
        const createdTime = new Date(time * 1000)
        const createdString = createdTime.getDate() +
            "/" + (createdTime.getMonth() + 1) +
            "/" + createdTime.getFullYear() +
            " " + createdTime.getHours() +
            ":" + createdTime.getMinutes() +
            ":" + createdTime.getSeconds()
        return createdString
    }
</script>