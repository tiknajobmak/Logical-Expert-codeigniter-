<!-- content-part starts -->
<div class="content-part">
    <div class="container-fluid">
        <!-- row starts -->
        <div class="row">
            <!-- content -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4><?php echo ($heading) ? $heading : '' ?></h4>
                <!-- first-part starts -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frm_add_user">
                <div class="message"><?php echo $this->session->flashdata('msg'); ?></div>

                    <?php echo form_open(ADMIN_URL . $formUrl); ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="frm_add_row">
                            <?php echo form_label('Contact Email :'); ?> <?php echo form_error('contactEmail'); ?>
                            <?php echo form_input(array('id' => 'contactEmail', 'name' => 'contactEmail'), set_value('contactEmail', (isset($result['contactEmail'])) ? $result['contactEmail'] : '')); ?>
                        </div>
                        <div class="frm_add_row">
                            <?php echo form_label('Payment Gateway API key :'); ?> <?php echo form_error('gatewayApi'); ?>
                            <?php echo form_input(array('id' => 'gatewayApi', 'name' => 'gatewayApi'), set_value('gatewayApi', (isset($result['gatewayApi'])) ? $result['gatewayApi'] : '')); ?>
                        </div>
                        <div class="frm_add_row">
                            <?php echo form_submit(array('id' => 'submit', 'value' => $submitButton)); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!-- first-part ends -->
            </div>
            <!-- row ends -->
        </div>
    </div>
    <!-- content-part ends -->
</div>
<!-- right-content ends -->
<div class="clearfix"></div>
</div>
<!-- fullbody ends -->
</body>
</html>
