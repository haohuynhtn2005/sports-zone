<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <section id="values" class="values section">

    <div class="container section-title" data-aos="fade-up">
        <h2>Lĩnh vực hoạt động</h2>
        <p>Tổ chức sự kiện thể thao chuyên nghiệp<br></p>
    </div>

    <div class="container">

        <div class="row gy-4">
            <?php foreach ($data as $key => $value):

                $data_id = $value['id'];
                $data_title = word_limiter($value['title'], 15);
                $data_hometext = word_limiter($value['hometext'], 15);
                $data_link = site_url(
                    $value['categories']['alias'] .
                        '/' .
                        $value['alias'] .
                        '-' .
                        $data_id
                );
                $data_image = [
                    'src' => get_media(
                        'posts',
                        $value['homeimgfile'],
                        'no-image-thumb.png',
                        '360x270x1'
                    ),
                    'alt' => $value['homeimgalt'],
                ];
                ?>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <img 
                            src="<?php echo $data_image['src']; ?>" 
                            alt="<?php echo $data_title; ?>"
                            class="img-fluid" 
                            >
                        <h3><?php echo $data_title; ?></h3>
                        <p><?php echo $data_hometext; ?></p>
                    </div>
                </div>
            <?php
            endforeach; ?>
        </div>

    </div>
<?php endif; ?>
