<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <section id="project" class="t-center sm-py styled-portfolio">
        <div class="container t-center sm-pb ">
            <h2 class=" uppercase"><?php echo isset($info_projects_has_been_constructed_none['title']) ? $info_projects_has_been_constructed_none['title'] : ''; ?></h2>
            <div class="title-strips-over dark xs-mb"></div>
            <div class="t-justify">
                <?php echo isset($info_projects_has_been_constructed_none['content']) ? $info_projects_has_been_constructed_none['content'] : ''; ?>
            </div>
        </div>
        <div id="portfolio-items" class="cbp cbp-l-grid-work container">
            <?php
            foreach ($data as $key => $value):
                $data_id = $value['id'];
                $data_title = $value['name'];
                $data_address = $value['address'];
                $data_link = site_url($this->config->item('url_projects') . '/' . $value['alias'] . '-' . $data_id);
                $data_image = array(
                  'src' => get_media('projects', $value['image'], 'no-image.png', '360x270x1'),
                  'alt' => ''
                );
            ?>
            <div class="cbp-item identity print graphic animated" data-animation="fadeInUp" data-animation-delay="<?php echo ($key * 100); ?>">
                <a href="<?php echo $data_link; ?>" class="cbp-caption">
                    <div class="cbp-caption-defaultWrap">
                        <img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>">
                    </div>
                    <div class="cbp-caption-activeWrap"></div>
                </a>
                <a href="<?php echo $data_link; ?>" class="no-lightbox cbp-l-grid-work-title"><?php echo $data_title; ?></a>
                <div class="cbp-l-grid-work-desc font-15 mini-mt"><?php echo $data_address; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>