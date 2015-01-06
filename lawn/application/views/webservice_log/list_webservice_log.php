<?php echo $xtPageTitle . "<br><br>" . (($xtMessage != "") ? ($xtMessage . "<br><br>") : ""); ?>
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
        <td><?php echo $data->xtID ?></td>
        <td><?php echo $data->xtWebservice ?></td>
        <td><?php echo $data->xtDateTime ?></td>
        <td>
            <a href="<?php echo SITEURL . "/webservice_log/view_webservice_log?id=" . $data->xtID ?>">View</a>
        </td>
    </tr>
    <?php $i++; } ?>
    <?php if($xtPagination != "") { ?>
    <tr><td colspan="6" align="center"><?php echo $xtPagination ?></td></tr>
    <?php } ?>
</table>