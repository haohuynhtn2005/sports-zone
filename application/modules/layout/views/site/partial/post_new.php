<?php if (isset($data) && is_array($data) && !empty($data)):?>
<div class="box-list-categories">
    <div class="box-list-categories">
        <div class="block-wapper--title">
            <h3>Tin tức mới</h3>
        </div>
        <ul class="block-list-categories--content">
            <?php foreach ($data as $value):
          $data_id = $value['id'];
          $data_title = $value['title'];
          $data_hometext = $value['hometext'];
          $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
          $data_image = array(
            'src' => get_image(get_module_path('posts') . $value['homeimgfile'], get_module_path('posts') . 'no-image.png'),
            'alt' => $value['homeimgalt']
          );
          ?>

            <li>
                <h3 class="title">
                    <a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a>
                </h3>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>