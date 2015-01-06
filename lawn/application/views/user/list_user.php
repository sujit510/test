<?php echo $xtPageTitle . "<br><br>" . (($xtMessage != "") ? ($xtMessage . "<br><br>") : ""); ?>
<?php echo form_button("xtAdd", "Add", " onclick=\"window.location.href='" . SITEURL . "/user/manage_user'\"") ?>
<!--Display headers-->
<table id="list_table" border="1">
    <tr>
        <th>#</th>
    <?php foreach($xtTableHeaders as $xtHeaderData) { ?>
        <th><?php echo $xtHeaderData ?></th>
    <?php } ?>
        <th>Action</th>
    </tr>
    
    <?php $i = 1; foreach($xtListData as $data) { ?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $data->xtUserFirstName . " " . $data->xtUserLastName ?></td>
        <td><?php echo $data->xtUserEmail ?></td>
        <td><?php echo $data->xtUserContactNumber ?></td>
        <td><?php echo $xtRolesArray[$data->xtUserRole] ?></td>
        <td>
            <a href="<?php echo SITEURL . "/user/manage_user?id=" . base64_encode($data->xtUserID) ?>">Edit</a>
            <a href="javascript:voide(0)" onclick="if(confirm('Are you sure you want to delete this?')) window.location.href='<?php echo SITEURL . "/user/delete_user?id=" . base64_encode($data->xtUserID) ?>';">Delete</a>
        </td>
    </tr>
    <?php $i++; } ?>
    <?php if($xtPagination != "") { ?>
    <tr><td colspan="6" align="center"><?php echo $xtPagination ?></td></tr>
    <?php } ?>
</table>