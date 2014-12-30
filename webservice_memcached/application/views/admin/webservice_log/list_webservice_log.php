<?php echo $ncPageTitle . "<br><br>" . (($ncMessage != "") ? ($ncMessage . "<br><br>") : ""); ?>
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
        <td><?php echo $data->ID ?></td>
        <td><?php echo $data->Webservice ?></td>
        <td><?php echo $data->DateTime ?></td>
        <td>
            <a href="<?php echo SITEADMINURL . "/webservice_log/view_webservice_log?id=" . $data->ID ?>">View</a>
        </td>
    </tr>
    <?php $i++; } ?>
    <?php if($ncPagination != "") { ?>
    <tr><td colspan="6" align="center"><?php echo $ncPagination ?></td></tr>
    <?php } ?>
</table>