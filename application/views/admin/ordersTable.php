<table class="table table-striped custom-tbl-class">
    <tr>
        <th data-col="user_id-checkbox" >
            <input type="checkbox" id="sel-all-chk"  />
        </th>
        <th class="sort-col desc" data-col="orderId">
            Order ID 
            <i class="fa fa-sort-desc"></i>
        </th>
        <th class="sort-col desc" data-col="title">
            Class Name
            <i class="fa fa-sort-desc"></i>
        </th>
        <th class="sort-col desc" data-col="content">
            User Name
            <i class="fa fa-sort-desc"></i>
        </th>
        <th class="sort-col desc" data-col="content">
            Order Time
        </th>
        <th class="sort-col desc" data-col="content">
            Order Payment Receipt Id
        </th>
        <th class="sort-col desc" data-col="content">
            Order Status
        </th>
    </tr>
    <tbody class="table-data">
        <?php
        if (count($userData)) {
            foreach ($userData as $data) {
                echo'<tr id="tr-' . $data['orderId'] . '"><td><input type="checkbox" id="chk-' . $data['orderId'] . '" class="chk-mul-del" /></td><td>' . $data['orderId'] . '</td><td>' . $data['className']. '</td><td>'.$data['userName'].'</td><td>' . $data['orderTime'] . '</td><td>'.$data['orderPaymentReciptId'].'</td><td>'.$data['orderStatus'].'</td></tr>';
            }
        } else
            echo'<tr><td colspan="6">No Orders Exist</td></tr>';
        ?> 
    </tbody>
</table>
<?php echo count($userData) ? '<div class="pagination-part">'.$links.'</div>' : ''; ?>
<input type="hidden" id="pageNumber" value="<?php echo $this->session->userdata('pageNumber'); ?>">