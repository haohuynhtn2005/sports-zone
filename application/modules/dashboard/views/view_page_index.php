<h4 class="text-capitalize">Thông tin hệ thống</h4>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-cubes"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Dự án</span>
                <span class="info-box-number"><?php echo number_format($num_projects); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-edit"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Nội dung</span>
                <span class="info-box-number"><?php echo number_format($num_posts); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-file"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Trang tĩnh</span>
                <span class="info-box-number"><?php echo number_format($num_pages); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-envelope"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Liên hệ</span>
                <span class="info-box-number"><?php echo number_format($num_contact); ?></span>
            </div>
        </div>
    </div>
</div>