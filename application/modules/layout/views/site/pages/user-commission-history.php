<article>
  	<section class="user-manager-page">
	    <div class="container">
	      	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12">
		          	<div class="account-structure-page_main-content">
                        <div class="account-change-email">
            				<h2 class="account-structure-page_title">Lịch sử hoa hồng</h2>
            				<div class="box-devision-col-mobile">
            					<?php if(isset($rows) && is_array($rows) && !empty($rows)): ?>
            			        <div class="table-responsive">
            			            <table class="table table-striped table-bordered table-hover">
            			                <thead>
            			                    <tr>
                                                <th>#ID</th>
                                                <th>Hoạt động</th>
                                                <th class="text-right">Giá trị</th>
                                                <th class="text-right">Phần trăm</th>
                                                <th class="text-right">Hoa hồng</th>
                                                <th class="text-center">Thời gian</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th>Ghi chú</th>
            			                    </tr>
            			                </thead>
            			                  <tbody>
            			                    <?php foreach ($rows as $row): ?>
            			                        <tr>
            			                            <td class="text-right"><?php echo $row['id']; ?></td>
                                                    <td>
                                                        <?php echo display_label(display_value_array($this->config->item('users_modules_commission'), $row['action']), display_value_array($this->config->item('users_modules_commission_label'), $row['action'])); ?>
                                                        <?php if(in_array($row['action'], array('BUY', 'SUB_BUY', 'BUY_TRAVEL', 'SUB_BUY_TRAVEL'))): ?>
                                                        <p>
                                                            <?php if(in_array($row['action'], array('BUY', 'SUB_BUY'))){
                                                                echo display_label('#ID-HOTEL-' . $row['order_code'], 'info');
                                                            }else{
                                                                echo display_label('#ID-TOUR-' . $row['order_code_travel'], 'primary');
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php endif; ?>
                                                        <?php
                                                        if(isset($row['note']) && trim($row['note']) != ''){
                                                            echo "<br/>" . display_label($row['note'], 'warning');
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-right"><?php echo '+' . formatRice($row['value_cost']); ?></td>
                                                    <td class="text-right"><?php echo $row['percent']; ?></td>
                                                    <td class="text-right"><?php echo '+' . formatRice($row['value']); ?></td>
                                                    <td class="text-center"><?php echo display_date($row['created']); ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        if($row['status'] == 1){
                                                            echo display_label('Khả dụng');
                                                        }elseif($row['status'] == 0){
                                                            echo display_label('Đã yêu cầu', 'warning');
                                                        }else{
                                                            echo display_label('Đã hủy yêu cầu', 'danger');
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['message']; ?></td>
            			                        </tr>
            			                    <?php endforeach; ?>
            			                </tbody>
            			            </table>
            			        </div>
            					<?php else: ?>
                                    <p>Không có lịch sử hoa hồng nào!</p>
                                <?php endif; ?>
            				</div>
            				<div class="clearfix"></div>
            				<div class="box-pagination">
            					<?php if (isset($pagination) && $pagination != ''): ?>
            						<?php echo $pagination; ?>
            					<?php endif; ?>
            				</div>
                        </div>
		          	</div>
		        </div>
	      	</div>
	    </div>
  	</section>
</article>