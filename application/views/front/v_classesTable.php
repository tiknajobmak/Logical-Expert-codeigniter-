<thead>
    <tr>
        <th class="sort-col desc" data-col="className">Name <i class="fa fa-sort-desc"></i></th>
        <th class="sort-col desc" data-col="createdBy">Created By<i class="fa fa-sort-desc"></i></th>
        <th>Classes</th>
    </tr>
</thead>
<tbody class="table-data">
    <?php
    if (count($listData)) {
        foreach ($listData as $data) {
            echo'<tr id="tr-' . $data['classId'] . '">'
            . '<td><a class="detail-anchor" href=' . URL .'view/'. $pageLink. '/' . $data['classId'] . '>' . $data['className'] . '</a></td>'
            . '<td>' . $data['userName'] . '</td>'
            . '<td><a href="javascript:void(0)">Join Class</a></td></tr>';
        }
    } else
        echo'<tr><td colspan="6">No Records Exist</td></tr>';
    ?> 
</tbody>
<tfoot>
<tr><td colspan="2"><?php echo count($listData) ? '<div class="pagination-part">' . $links . '</div>' : ''; ?></td></tr>
</tfoot>