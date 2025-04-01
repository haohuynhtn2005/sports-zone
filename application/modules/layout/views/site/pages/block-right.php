<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 block-right">
	<div class="container">
		<div class="row">
			<div class="card mb-35 col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
				<div class="card-body">
					<h5 class="card-title">
						<span>FANPAGE</span>
					</h5>
					<div class="embed-responsive embed-responsive-4by3">
						<?php echo isset($fb_page) ? $fb_page : ''; ?>
					</div>
				</div>
			</div>
			<div class="card mb-35 col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12 block-support">
				<div class="card-body">
					<h5 class="card-title">
						<span><?php echo isset($info_support_none['title']) ? $info_support_none['title'] : ''; ?></span>
					</h5>
					<?php echo isset($info_support_none['content']) ? $info_support_none['content'] : ''; ?>
				</div>
			</div>
			<div class="card mb-35 col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12">
				<div class="card-body">
					<h5 class="card-title">
						<span>THỐNG KÊ</span>
					</h5>
					<span>Tổng truy cập:  <span id="total"></span><br>
					<span>Đang online: <span id="online"></span>
				</div>
			</div>
			<div class="card mb-35 col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 block-products_featured">
				<div class="card-body">
					<h5 class="card-title">
						<span>SẢN PHẨM</span>
					</h5>
					<?php echo isset($products_featured) ? $products_featured : ''; ?>
				</div>
			</div>
			<div class="card mb-35 col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card-body">
					<h5 class="card-title">
						<span>TIN TỨC</span>
					</h5>
					<?php echo isset($posts_featured) ? $posts_featured : ''; ?>
				</div>
			</div>
		</div>
	</div>
</div>
