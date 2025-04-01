<article>
<section>
	<div class="container">
		<?php $this->load->view('breadcrumb'); ?>
		<h1 class="d-none"><?php echo $h1_seo; ?></h1>
		<div class="row">
			<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
				<section>
					<div class="section-box-post">
						<h5 class="card-title">
							<span><?php echo isset($data_cat['name']) ? $data_cat['name'] : ''; ?></span>
						</h5>
						<hr>
						<div class="row">
							<?php echo isset($rows) ? $rows : ''; ?>
						</div>
					</div>
				</section>
				<?php if (isset($pagination) && $pagination != ''): ?>
					<div class="box-pagination">
						<nav>
							<?php echo $pagination; ?>
						</nav>
					</div>
				<?php endif; ?>
			</div>
			<?php $this->load->view('block-right'); ?>
		</div>
	</div>
</section>
</article>
