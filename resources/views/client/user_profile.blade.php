@extends('client.layout')
@section('tieudetrang')
Thông tin người dùng
@endsection
@section('noidungchinh')
		<!-- Start Product Section -->
		<div class="product-section">
			<div class="container">
				<div class="row">

					<!-- Start Column 1 -->
					<div class="col">
						<div class="user_left rounded">
							<div class="d-flex flex-column justify-content-center align-items-center">
								<div>
									<img src="{{ asset('storage/' . Auth::user()->image_url) }}" class="avatar_left"></img>
								</div>
								<div>
									<p class="user_profile_name">{{ Auth::user()->name}} <br> <label class="user_profile_name_label">Sửa hồ sơ</label> </p>
								</div>
							</div>
							
							<div class="user_profile_group">
								<ul class="user_list"> 
									<li class="list_item">
										<a class="user_profile_item" href="">
											<i class="fa-solid fa-user"></i>
											Tài khoản của tôi
										</a>
									</li>
									<li class="list_item">
										<a class="user_profile_item" href="">
											<i class="fa-solid fa-cart-shopping"></i>
											Lịch sử đơn hàng
										</a>
									</li>
									<li class="list_item">
										<a class="user_profile_item" href="">
											<i class="fa-solid fa-cart-shopping"></i>
											Giỏ hàng của tôi
										</a>
									</li>
								</ul>
							</div>
						</div>
							
					</div> 

					<!-- End Column 1 -->

					<!-- Start Column 2 -->
					<div class="col">
						<div class="user_right rounded">
							<form action="/change-info" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-8">
										<h3 class="user_profile_h3">Hồ Sơ Của Tôi</h3>
										<!-- <h5 class="user_profile_h5">Quản lý thông tin hồ sơ để bảo mật tài khoản</h5> -->
											<div class="form-group">
												<label for="exampleInputName">Tên</label>
												<input type="text" class="form-control" id="exampleInputName" aria-describedby="emailHelp" placeholder="Nhập tên" value=" {{ Auth::user()->name }}">
											</div>
											<div class="form-group">
												<label for="exampleInputEmail1">Email</label>
												<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập email" value="{{ Auth::user()->email }}">
											</div>
											<div class="form-group mt-4">
												<button type="submit" class="btn btn-primary rounded">Cập nhật</button>
												<a href="/logout" class="btn btn-primary rounded">
													Đăng xuất
												</a>
											</div>
									</div>
									<div class="col-4 user_profile_right text-center d-flex flex-column justify-content-center align-items-center">
										<div class="d-flex justify-content-center"><img src="{{ asset('storage/' . Auth::user()->image_url) }}" class="avatar_right text-center"></img></div>
										<input type="file" name="file_image" id="file-input">
										<label id="file-input-label" for="file-input">Chọn ảnh</label>
										<p style="font-size: 10px; color: black;">Dung lượng file tối đa 1MB <label for="">Định dạng:.. JPG, PNG</label> </p>
									</div>
								</div>
							</form>
						</div>
					</div> 
					<!-- End Column 2 -->


				</div>
				<div class="user_rightmobi">
					<div class="row">
						<div class="col-8">
							<h3 class="user_profile_h3">Hồ Sơ Của Tôi</h3>
							<h5 class="user_profile_h5">Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>

								<div class="user_profile_infomation col-12 row">
									<div class="form_infomation_left col-4">
										<p class="user_profile_name_label">tên đăng nhập</p>
										<p class="user_profile_name_label">Tên</p>
										<p class="user_profile_name_label">Email</p>
										<p class="user_profile_name_label">Số điện thoại</p>
										<p class="user_profile_name_label">Giới tính</p>
										<p class="user_profile_name_label">Ngày sinh</p>
									</div>

									<div class="form_infomation_right col-8">
										<p class="user_profile_name_label">Account name</p>
										<input type="name" class="form_input">
										<p style="padding-top: 10px;" class="user_profile_name_label">Account@gmail.com <label> <a style="color: blue; padding-left: 5px;" href="">Thay đổi</a></label></p>
										<p class="user_profile_name_label">090909*** <label> <a style="color: blue; padding-left: 5px;" href="">Thay đổi</a></label></p>
										<button style="border: none; background-color: rgb(193, 193, 193);" class="user_profile_name_label btn-sex">Nam</button>
										<button style="border: none; background-color: rgb(193, 193, 193);" class="user_profile_name_label btn-sex">Nữ</button>
									<button style="border: none; background-color: rgb(193, 193, 193);" class="user_profile_name_label btn-sex">Khác</button>
									<div class="select_information">
										<select class="form_select">
											<option selected>1</option>
											<option value="1">One</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
										<select class="form_select">
											<option selected>1</option>
											<option value="1">One</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
										<select class="form_select">
											<option selected>1</option>
											<option value="1">One</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
									</div>
									<button class="btn_submit" type="submit">Lưu</button>
								</div>
								
							</div>
						</div>
						
						<div class="col-4 user_profile_right">
							<div class="avatar_right"></div>
							<input type="file" id="file-input">
							<label id="file-input-label" for="file-input">Chọn ảnh</label>
							<p style="font-size: 10px; color: black;">Dung lượng file tối đa 1MB <label for="">Định dạng:.. JPG, PNG</label> </p>
							
						</div>
					</div>
				</div>

			<div class="user_right_mobile">
				<h3 class="user_profile_h3">Hồ Sơ Của Tôi</h3>
				<h5 class="user_profile_h5">Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>
				<div class=" user_profile_right">
					<div class="avatar_right"></div>
					<input type="file" id="file-input">
					<label id="file-input-label" for="file-input">Chọn ảnh</label>
					<p style="font-size: 10px; color: black;">Dung lượng file tối đa 1MB <label for="">Định dạng:.. JPG, PNG</label> </p>
					
				</div>
				<div class="form_infomation_left">
					<p class="user_profile_name_label">tên đăng nhập</p><span class="user_profile_name_label">Account name</span><br>	
					<p class="user_profile_name_label">Tên</p><input type="name" class="form_input"><br>
					<p class="user_profile_name_label">Email</p><p style="padding-top: 10px;" class="user_profile_name_label">Account@gmail.com <label> <a style="color: blue; padding-left: 5px;" href="">Thay đổi</a></label></p><br>
					<p class="user_profile_name_label">Số điện thoại</p><p class="user_profile_name_label">090909*** <label> <a style="color: blue; padding-left: 5px;" href="">Thay đổi</a></label></p><br>
					<p class="user_profile_name_label">Giới tính</p><button style="border: none; background-color: rgb(193, 193, 193);" class="user_profile_name_label btn-sex">Nam</button>
					<button style="border: none; background-color: rgb(193, 193, 193);" class="user_profile_name_label btn-sex">Nữ</button>
					<button style="border: none; background-color: rgb(193, 193, 193);" class="user_profile_name_label btn-sex">Khác</button><br>
					<p class="user_profile_name_label">Ngày sinh</p>
					<div class="select_information">
						<select class="form_select">
							<option selected>1</option>
							<option value="1">One</option>
							<option value="2">Two</option>
							<option value="3">Three</option>
						</select>
						<select class="form_select">
							<option selected>1</option>
							<option value="1">One</option>
							<option value="2">Two</option>
							<option value="3">Three</option>
						</select>
						<select class="form_select">
							<option selected>1</option>
							<option value="1">One</option>
							<option value="2">Two</option>
							<option value="3">Three</option>
						</select>
					</div>
					<button class="btn_submit" type="submit">Lưu</button>
				</div>
			</div>
			</div>
		</div>
		<!-- End Product Section -->
@endsection