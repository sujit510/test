<?php echo $ncPageTitle . "<br><br>" . (($ncMessage != "") ? ($ncMessage . "<br><br>") : ""); ?>
<?php echo form_button("ncAdd", "Add", " onclick=\"window.location.href='" . SITEADMINURL . "/user/manage_user'\"") ?>
<!--Display headers-->
<table id="list_table" border="1">
    <tr>
        <th>#</th>
    <?php foreach($ncTableHeaders as $ncHeaderData) { ?>
        <th><?php echo $ncHeaderData ?></th>
    <?php } ?>
        <th>Action</th>
    </tr>
    
    <?php $i = 1; foreach($ncListData as $data) { ?>
    <tr>
        <td><?php echo $data->ID;//$i ?></td>
        <td><?php echo $data->UserFirstName . " " . $data->UserLastName ?></td>
        <td><?php echo $data->UserEmail ?></td>
        <td><?php echo $data->UserContactNumber ?></td>
        <td><?php echo implode(",", $data->ncUserRole)//echo $ncRolesArray[$data->ncUserRole] ?></td>
        <td>
            <a href="<?php echo SITEADMINURL . "/user/manage_user?id=" . base64_encode($data->ID) ?>">Edit</a>
            <a href="javascript:void(0)" onclick="if(confirm('Are you sure you want to delete this?')) window.location.href='<?php echo SITEADMINURL . "/user/delete_user?id=" . base64_encode($data->ID) ?>';">Delete</a>
        </td>
    </tr>
    <?php $i++; } ?>
    <?php if($ncPagination != "") { ?>
    <tr><td colspan="6" align="center"><?php echo $ncPagination ?></td></tr>
    <?php } ?>
</table>