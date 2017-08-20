<?php

// prj_id
// per_id
// gjm_total

?>
<?php if ($t_gaji_master->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_gaji_master->TableCaption() ?></h4> -->
<table id="tbl_t_gaji_mastermaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_gaji_master->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_gaji_master->prj_id->Visible) { // prj_id ?>
		<tr id="r_prj_id">
			<td><?php echo $t_gaji_master->prj_id->FldCaption() ?></td>
			<td<?php echo $t_gaji_master->prj_id->CellAttributes() ?>>
<span id="el_t_gaji_master_prj_id">
<span<?php echo $t_gaji_master->prj_id->ViewAttributes() ?>>
<?php echo $t_gaji_master->prj_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_gaji_master->per_id->Visible) { // per_id ?>
		<tr id="r_per_id">
			<td><?php echo $t_gaji_master->per_id->FldCaption() ?></td>
			<td<?php echo $t_gaji_master->per_id->CellAttributes() ?>>
<span id="el_t_gaji_master_per_id">
<span<?php echo $t_gaji_master->per_id->ViewAttributes() ?>>
<?php echo $t_gaji_master->per_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_gaji_master->gjm_total->Visible) { // gjm_total ?>
		<tr id="r_gjm_total">
			<td><?php echo $t_gaji_master->gjm_total->FldCaption() ?></td>
			<td<?php echo $t_gaji_master->gjm_total->CellAttributes() ?>>
<span id="el_t_gaji_master_gjm_total">
<span<?php echo $t_gaji_master->gjm_total->ViewAttributes() ?>>
<?php echo $t_gaji_master->gjm_total->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
