<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Thông báo lỗi không tìm thấy trang yêu cầu - 404 Not Found</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url() . 'assets/modules/errors/css/error404.css'; ?>" />
    </head>
    <body>
        <div class="container">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <div class="logo">
                    <h1>OPPS, Error 404!</h1>
                </div>
                <div class="clearfix"></div>
                <br />
                <br />
                <p class="text-muted">Trang yêu cầu không tìm thấy, xin vui lòng thử lại sau.</p>
                <div class="clearfix"></div>
                <br />
                <div class="col-lg-6  col-lg-offset-3">
                    <div class="btn-group btn-group-justified">
                        <a href="<?php echo base_url(); ?>" class="btn btn-success"><span class="glyphicon glyphicon-home"></span> Về trang chủ</a> 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>