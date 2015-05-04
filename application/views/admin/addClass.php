<script>
    jQuery(function() {
        jQuery("#startDate").datepicker({
            minDate: 0,
            dateFormat: 'yy-mm-dd',
            onClose: function(selectedDate) {
                // Set the minDate of end date greater then start date
                jQuery("#endDate").datepicker("option", "minDate", selectedDate);
            }
        });


        jQuery("#endDate").datepicker({
            dateFormat: 'yy-mm-dd'
        });

    });

</script>
<script language="javascript" type="text/javascript">
    jQuery(document).ready(function(){
        videondemand(jQuery('[name="classType"]').val());
        privateHide();
    });
    function randomString(showId)
    {
        var count = 0;
        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var string_length = 16;
        var randomstring = '';
        for (var i = 0; i < string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }
        jQuery('#'+showId).val(randomstring);
    }
    function videondemand(val){
        
        if(val == 'videoondemand'){
            jQuery('.videondemand').hide();
            jQuery('#startDate').val('');
            jQuery('#endDate').val('');
        }
        else
            jQuery('.videondemand').show(); 
    }
    function privateHide(){
        if(jQuery("#private").is(':checked')){
            jQuery(".privateKey").show();
            
        }
        else{
            jQuery(".privateKey").hide();
            jQuery("#privatePassCode").val('');
        }
    }
</script>

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
                    <?php echo form_open(ADMIN_URL . $formUrl); ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="frm_add_row">
                            <?php echo form_label('Class Name :'); ?> <?php echo form_error('className'); ?>
                            <?php echo form_input(array('id' => 'className', 'name' => 'className'), set_value('className', (isset($result['className'])) ? $result['className'] : '')); ?>
                        </div>
                        <div class="frm_add_row ">
                            <?php echo form_label('Class Type :'); ?> <?php echo form_error('classType'); ?>
                            <?php $options = array('-1' => '--Select Class Type--' , 'classroom' => 'Class Room', 'videoondemand' => 'Video On Demand'); ?>
                            <?php echo form_dropdown('classType', $options , set_value('classType' , (isset($result['classType'])) ? $result['classType'] : ''),  'onchange="videondemand(this.value)"'); ?>
                        </div>
                        <div class="frm_add_row videondemand" >
                            <div class="frm_add_row">
                                <?php echo form_label('Start Date :'); ?> <?php echo form_error('startDate'); ?>
                                <?php echo form_input(array('id' => 'startDate', 'name' => 'startDate'), set_value('startDate', (isset($result['startDate'])) ? $result['startDate'] : '')); ?>
                            </div>
                            <div class="frm_add_row">
                                <?php echo form_label('End Date :'); ?> <?php echo form_error('endDate'); ?>
                                <?php echo form_input(array('id' => 'endDate', 'name' => 'endDate'), set_value('endDate', (isset($result['endDate'])) ? $result['endDate'] : '')); ?>
                            </div>
                        </div>
                        <div class="frm_add_row">
                            <?php echo form_label('Duration (in hours):'); ?> <?php echo form_error('duration'); ?>
                            <?php echo form_input(array('id' => 'duration', 'name' => 'duration'), set_value('duration', (isset($result['duration'])) ? $result['duration'] : '')); ?>
                        </div>
                        <div class="frm_add_row">
                            <?php echo form_label('Time :'); ?> <?php echo form_error('time'); ?>
                            <?php
                            $start = strtotime('12:00am');
                            $end = strtotime('11:59pm');
                            $time['-1'] = '--Select Time--';
                            for ($i = $start; $i <= $end; $i += 900) {
                                $time[date('g:i a', $i)] = date('g:i a', $i);
                            }
                            ?>
                            <?php echo form_dropdown('time', $time , set_value('time' , (isset($result['time'])) ? $result['time'] : '')); ?>
                        </div>
                       
                        <div class="frm_add_row">
                            <?php echo form_label('Private :'); ?> <?php echo form_error('private'); ?>
                            <?php echo form_checkbox('private', '1', set_value('private', (isset($result['private']) && $result['private'] == 1 ) ? TRUE : FALSE) , 'onclick="privateHide();" id="private"'); ?>
                            <!--<input type="checkbox" name="private" id="private" value="1" onclick="privateHide();" <?php echo set_checkbox('private', '1' , set_value('private' , (isset($result['private']) && $result['private'] == 1 ) ? TRUE : FALSE)); ?>/>-->
                        </div>
                        <div class="frm_add_row privateKey">
                             
                            <?php echo form_label('Private Key :'); ?> <?php echo form_error('privatePassCode'); ?>
                            <input type="text" name="privatePassCode" id="privatePassCode" value="<?php echo set_value('privatePassCode', (isset($result['privatePassCode'])) ? $result['privatePassCode'] : '') ?>" readonly  >
                            <span id="add_data" class="cust_button" onclick="randomString('privatePassCode')">Generate Key</span>
                        </div>

                        <div class="frm_add_row">
                            <?php echo form_label('Payment Type :'); ?> <?php echo form_error('paymentType'); ?>
                            <?php $options = array('-1' => '--Select Payment Type--', 'recuring' => 'Recuring', 'fullpayment' => 'Full Payment'); ?>
                            <?php echo form_dropdown('paymentType', $options , set_value('paymentType',(isset($result['paymentType'])) ? $result['paymentType'] : '')); ?>
                        </div>
                        <div class="frm_add_row" >
                            <?php echo form_label('Price'); ?> <?php echo form_error('price'); ?>
                            <input type="text" name="price" value="<?php echo set_value('price', (isset($result['price'])) ? $result['price'] : '') ?>" >
                        </div>
                        <div class="frm_add_row" >
                            <?php echo form_label('Max. Attendee'); ?> <?php echo form_error('attendee'); ?>
                            <input type="text" name="attendee" value="<?php echo set_value('attendee', (isset($result['attendee'])) ? $result['attendee'] : '') ?>" >
                        </div>
                        <div class="frm_add_row">
                            <?php echo form_submit(array('id' => 'submit', 'value' => $submitButton)); ?>
                            <?php echo form_submit(array('id' => 'cancel', 'url' => 'classes/' . $cid, 'value' => 'Cancel')); ?>
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
