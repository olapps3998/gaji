<?php

// Create page object
if (!isset($t_gaji_detail_grid)) $t_gaji_detail_grid = new ct_gaji_detail_grid();

// Page init
$t_gaji_detail_grid->Page_Init();

// Page main
$t_gaji_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_gaji_detail_grid->Page_Render();
?>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_gaji_detailgrid = new ew_Form("ft_gaji_detailgrid", "grid");
ft_gaji_detailgrid.FormKeyCountName = '<?php echo $t_gaji_detail_grid->FormKeyCountName ?>';

// Validate form
ft_gaji_detailgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_peg_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->peg_id->FldCaption(), $t_gaji_detail->peg_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_mn");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_mn->FldCaption(), $t_gaji_detail->b_mn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_mn");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_mn->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_b_sn");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_sn->FldCaption(), $t_gaji_detail->b_sn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_sn");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_sn->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_b_sl");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_sl->FldCaption(), $t_gaji_detail->b_sl->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_sl");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_sl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_b_rb");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_rb->FldCaption(), $t_gaji_detail->b_rb->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_rb");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_rb->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_b_km");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_km->FldCaption(), $t_gaji_detail->b_km->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_km");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_km->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_b_jm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_jm->FldCaption(), $t_gaji_detail->b_jm->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_jm");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_jm->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_b_sb");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->b_sb->FldCaption(), $t_gaji_detail->b_sb->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_sb");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->b_sb->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_mn");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_mn->FldCaption(), $t_gaji_detail->l_mn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_mn");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_mn->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_sn");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_sn->FldCaption(), $t_gaji_detail->l_sn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_sn");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_sn->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_sl");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_sl->FldCaption(), $t_gaji_detail->l_sl->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_sl");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_sl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_rb");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_rb->FldCaption(), $t_gaji_detail->l_rb->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_rb");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_rb->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_km");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_km->FldCaption(), $t_gaji_detail->l_km->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_km");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_km->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_jm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_jm->FldCaption(), $t_gaji_detail->l_jm->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_jm");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_jm->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_l_sb");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_detail->l_sb->FldCaption(), $t_gaji_detail->l_sb->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_l_sb");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_detail->l_sb->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_gaji_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "peg_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_mn", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_sn", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_sl", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_rb", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_km", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_jm", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_sb", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_mn", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_sn", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_sl", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_rb", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_km", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_jm", false)) return false;
	if (ew_ValueChanged(fobj, infix, "l_sb", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_gaji_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_gaji_detailgrid.ValidateRequired = true;
<?php } else { ?>
ft_gaji_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_gaji_detailgrid.Lists["x_peg_id"] = {"LinkField":"x_peg_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_peg_nama","x_peg_jabatan","x_peg_upah",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_pegawai"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t_gaji_detail->CurrentAction == "gridadd") {
	if ($t_gaji_detail->CurrentMode == "copy") {
		$bSelectLimit = $t_gaji_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_gaji_detail_grid->TotalRecs = $t_gaji_detail->SelectRecordCount();
			$t_gaji_detail_grid->Recordset = $t_gaji_detail_grid->LoadRecordset($t_gaji_detail_grid->StartRec-1, $t_gaji_detail_grid->DisplayRecs);
		} else {
			if ($t_gaji_detail_grid->Recordset = $t_gaji_detail_grid->LoadRecordset())
				$t_gaji_detail_grid->TotalRecs = $t_gaji_detail_grid->Recordset->RecordCount();
		}
		$t_gaji_detail_grid->StartRec = 1;
		$t_gaji_detail_grid->DisplayRecs = $t_gaji_detail_grid->TotalRecs;
	} else {
		$t_gaji_detail->CurrentFilter = "0=1";
		$t_gaji_detail_grid->StartRec = 1;
		$t_gaji_detail_grid->DisplayRecs = $t_gaji_detail->GridAddRowCount;
	}
	$t_gaji_detail_grid->TotalRecs = $t_gaji_detail_grid->DisplayRecs;
	$t_gaji_detail_grid->StopRec = $t_gaji_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_gaji_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_gaji_detail_grid->TotalRecs <= 0)
			$t_gaji_detail_grid->TotalRecs = $t_gaji_detail->SelectRecordCount();
	} else {
		if (!$t_gaji_detail_grid->Recordset && ($t_gaji_detail_grid->Recordset = $t_gaji_detail_grid->LoadRecordset()))
			$t_gaji_detail_grid->TotalRecs = $t_gaji_detail_grid->Recordset->RecordCount();
	}
	$t_gaji_detail_grid->StartRec = 1;
	$t_gaji_detail_grid->DisplayRecs = $t_gaji_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_gaji_detail_grid->Recordset = $t_gaji_detail_grid->LoadRecordset($t_gaji_detail_grid->StartRec-1, $t_gaji_detail_grid->DisplayRecs);

	// Set no record found message
	if ($t_gaji_detail->CurrentAction == "" && $t_gaji_detail_grid->TotalRecs == 0) {
		if ($t_gaji_detail_grid->SearchWhere == "0=101")
			$t_gaji_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_gaji_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_gaji_detail_grid->RenderOtherOptions();
?>
<?php $t_gaji_detail_grid->ShowPageHeader(); ?>
<?php
$t_gaji_detail_grid->ShowMessage();
?>
<?php if ($t_gaji_detail_grid->TotalRecs > 0 || $t_gaji_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_gaji_detail">
<div id="ft_gaji_detailgrid" class="ewForm form-inline">
<?php if ($t_gaji_detail_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($t_gaji_detail_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t_gaji_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t_gaji_detailgrid" class="table ewTable">
<?php echo $t_gaji_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_gaji_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_gaji_detail_grid->RenderListOptions();

// Render list options (header, left)
$t_gaji_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->peg_id) == "") { ?>
		<th data-name="peg_id"><div id="elh_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->peg_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="peg_id"><div><div id="elh_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->peg_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->peg_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->peg_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_mn) == "") { ?>
		<th data-name="b_mn"><div id="elh_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_mn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_mn"><div><div id="elh_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_mn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_mn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_mn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_sn) == "") { ?>
		<th data-name="b_sn"><div id="elh_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_sn"><div><div id="elh_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_sn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_sn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_sl) == "") { ?>
		<th data-name="b_sl"><div id="elh_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_sl"><div><div id="elh_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_sl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_sl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_rb) == "") { ?>
		<th data-name="b_rb"><div id="elh_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_rb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_rb"><div><div id="elh_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_rb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_rb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_rb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_km) == "") { ?>
		<th data-name="b_km"><div id="elh_t_gaji_detail_b_km" class="t_gaji_detail_b_km"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_km->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_km"><div><div id="elh_t_gaji_detail_b_km" class="t_gaji_detail_b_km">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_km->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_km->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_km->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_jm) == "") { ?>
		<th data-name="b_jm"><div id="elh_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_jm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_jm"><div><div id="elh_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_jm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_jm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_jm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_sb) == "") { ?>
		<th data-name="b_sb"><div id="elh_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_sb"><div><div id="elh_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_sb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_sb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_mn) == "") { ?>
		<th data-name="l_mn"><div id="elh_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_mn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_mn"><div><div id="elh_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_mn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_mn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_mn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_sn) == "") { ?>
		<th data-name="l_sn"><div id="elh_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_sn"><div><div id="elh_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_sn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_sn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_sl) == "") { ?>
		<th data-name="l_sl"><div id="elh_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_sl"><div><div id="elh_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_sl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_sl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_rb) == "") { ?>
		<th data-name="l_rb"><div id="elh_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_rb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_rb"><div><div id="elh_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_rb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_rb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_rb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_km) == "") { ?>
		<th data-name="l_km"><div id="elh_t_gaji_detail_l_km" class="t_gaji_detail_l_km"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_km->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_km"><div><div id="elh_t_gaji_detail_l_km" class="t_gaji_detail_l_km">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_km->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_km->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_km->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_jm) == "") { ?>
		<th data-name="l_jm"><div id="elh_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_jm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_jm"><div><div id="elh_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_jm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_jm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_jm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_sb) == "") { ?>
		<th data-name="l_sb"><div id="elh_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_sb"><div><div id="elh_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_sb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_sb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_gaji_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_gaji_detail_grid->StartRec = 1;
$t_gaji_detail_grid->StopRec = $t_gaji_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_gaji_detail_grid->FormKeyCountName) && ($t_gaji_detail->CurrentAction == "gridadd" || $t_gaji_detail->CurrentAction == "gridedit" || $t_gaji_detail->CurrentAction == "F")) {
		$t_gaji_detail_grid->KeyCount = $objForm->GetValue($t_gaji_detail_grid->FormKeyCountName);
		$t_gaji_detail_grid->StopRec = $t_gaji_detail_grid->StartRec + $t_gaji_detail_grid->KeyCount - 1;
	}
}
$t_gaji_detail_grid->RecCnt = $t_gaji_detail_grid->StartRec - 1;
if ($t_gaji_detail_grid->Recordset && !$t_gaji_detail_grid->Recordset->EOF) {
	$t_gaji_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_gaji_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_gaji_detail_grid->StartRec > 1)
		$t_gaji_detail_grid->Recordset->Move($t_gaji_detail_grid->StartRec - 1);
} elseif (!$t_gaji_detail->AllowAddDeleteRow && $t_gaji_detail_grid->StopRec == 0) {
	$t_gaji_detail_grid->StopRec = $t_gaji_detail->GridAddRowCount;
}

// Initialize aggregate
$t_gaji_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_gaji_detail->ResetAttrs();
$t_gaji_detail_grid->RenderRow();
if ($t_gaji_detail->CurrentAction == "gridadd")
	$t_gaji_detail_grid->RowIndex = 0;
if ($t_gaji_detail->CurrentAction == "gridedit")
	$t_gaji_detail_grid->RowIndex = 0;
while ($t_gaji_detail_grid->RecCnt < $t_gaji_detail_grid->StopRec) {
	$t_gaji_detail_grid->RecCnt++;
	if (intval($t_gaji_detail_grid->RecCnt) >= intval($t_gaji_detail_grid->StartRec)) {
		$t_gaji_detail_grid->RowCnt++;
		if ($t_gaji_detail->CurrentAction == "gridadd" || $t_gaji_detail->CurrentAction == "gridedit" || $t_gaji_detail->CurrentAction == "F") {
			$t_gaji_detail_grid->RowIndex++;
			$objForm->Index = $t_gaji_detail_grid->RowIndex;
			if ($objForm->HasValue($t_gaji_detail_grid->FormActionName))
				$t_gaji_detail_grid->RowAction = strval($objForm->GetValue($t_gaji_detail_grid->FormActionName));
			elseif ($t_gaji_detail->CurrentAction == "gridadd")
				$t_gaji_detail_grid->RowAction = "insert";
			else
				$t_gaji_detail_grid->RowAction = "";
		}

		// Set up key count
		$t_gaji_detail_grid->KeyCount = $t_gaji_detail_grid->RowIndex;

		// Init row class and style
		$t_gaji_detail->ResetAttrs();
		$t_gaji_detail->CssClass = "";
		if ($t_gaji_detail->CurrentAction == "gridadd") {
			if ($t_gaji_detail->CurrentMode == "copy") {
				$t_gaji_detail_grid->LoadRowValues($t_gaji_detail_grid->Recordset); // Load row values
				$t_gaji_detail_grid->SetRecordKey($t_gaji_detail_grid->RowOldKey, $t_gaji_detail_grid->Recordset); // Set old record key
			} else {
				$t_gaji_detail_grid->LoadDefaultValues(); // Load default values
				$t_gaji_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_gaji_detail_grid->LoadRowValues($t_gaji_detail_grid->Recordset); // Load row values
		}
		$t_gaji_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_gaji_detail->CurrentAction == "gridadd") // Grid add
			$t_gaji_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_gaji_detail->CurrentAction == "gridadd" && $t_gaji_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_gaji_detail_grid->RestoreCurrentRowFormValues($t_gaji_detail_grid->RowIndex); // Restore form values
		if ($t_gaji_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t_gaji_detail->EventCancelled) {
				$t_gaji_detail_grid->RestoreCurrentRowFormValues($t_gaji_detail_grid->RowIndex); // Restore form values
			}
			if ($t_gaji_detail_grid->RowAction == "insert")
				$t_gaji_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_gaji_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_gaji_detail->CurrentAction == "gridedit" && ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT || $t_gaji_detail->RowType == EW_ROWTYPE_ADD) && $t_gaji_detail->EventCancelled) // Update failed
			$t_gaji_detail_grid->RestoreCurrentRowFormValues($t_gaji_detail_grid->RowIndex); // Restore form values
		if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_gaji_detail_grid->EditRowCnt++;
		if ($t_gaji_detail->CurrentAction == "F") // Confirm row
			$t_gaji_detail_grid->RestoreCurrentRowFormValues($t_gaji_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_gaji_detail->RowAttrs = array_merge($t_gaji_detail->RowAttrs, array('data-rowindex'=>$t_gaji_detail_grid->RowCnt, 'id'=>'r' . $t_gaji_detail_grid->RowCnt . '_t_gaji_detail', 'data-rowtype'=>$t_gaji_detail->RowType));

		// Render row
		$t_gaji_detail_grid->RenderRow();

		// Render list options
		$t_gaji_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_gaji_detail_grid->RowAction <> "delete" && $t_gaji_detail_grid->RowAction <> "insertdelete" && !($t_gaji_detail_grid->RowAction == "insert" && $t_gaji_detail->CurrentAction == "F" && $t_gaji_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $t_gaji_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_gaji_detail_grid->ListOptions->Render("body", "left", $t_gaji_detail_grid->RowCnt);
?>
	<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<td data-name="peg_id"<?php echo $t_gaji_detail->peg_id->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id">
<span<?php echo $t_gaji_detail->peg_id->ViewAttributes() ?>>
<?php echo $t_gaji_detail->peg_id->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_gaji_detail_grid->PageObjName . "_row_" . $t_gaji_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_gjd_id" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_gjd_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_gjd_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->gjd_id->CurrentValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_gjd_id" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_gjd_id" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_gjd_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->gjd_id->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT || $t_gaji_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_gjd_id" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_gjd_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_gjd_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->gjd_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<td data-name="b_mn"<?php echo $t_gaji_detail->b_mn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn">
<span<?php echo $t_gaji_detail->b_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_mn->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<td data-name="b_sn"<?php echo $t_gaji_detail->b_sn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn">
<span<?php echo $t_gaji_detail->b_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sn->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<td data-name="b_sl"<?php echo $t_gaji_detail->b_sl->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl">
<span<?php echo $t_gaji_detail->b_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sl->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<td data-name="b_rb"<?php echo $t_gaji_detail->b_rb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb">
<span<?php echo $t_gaji_detail->b_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_rb->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<td data-name="b_km"<?php echo $t_gaji_detail->b_km->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_km" class="t_gaji_detail_b_km">
<span<?php echo $t_gaji_detail->b_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_km->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<td data-name="b_jm"<?php echo $t_gaji_detail->b_jm->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm">
<span<?php echo $t_gaji_detail->b_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_jm->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<td data-name="b_sb"<?php echo $t_gaji_detail->b_sb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb">
<span<?php echo $t_gaji_detail->b_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sb->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<td data-name="l_mn"<?php echo $t_gaji_detail->l_mn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn">
<span<?php echo $t_gaji_detail->l_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_mn->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<td data-name="l_sn"<?php echo $t_gaji_detail->l_sn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn">
<span<?php echo $t_gaji_detail->l_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sn->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<td data-name="l_sl"<?php echo $t_gaji_detail->l_sl->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl">
<span<?php echo $t_gaji_detail->l_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sl->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<td data-name="l_rb"<?php echo $t_gaji_detail->l_rb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb">
<span<?php echo $t_gaji_detail->l_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_rb->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<td data-name="l_km"<?php echo $t_gaji_detail->l_km->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_km" class="t_gaji_detail_l_km">
<span<?php echo $t_gaji_detail->l_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_km->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<td data-name="l_jm"<?php echo $t_gaji_detail->l_jm->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm">
<span<?php echo $t_gaji_detail->l_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_jm->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<td data-name="l_sb"<?php echo $t_gaji_detail->l_sb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_grid->RowCnt ?>_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb">
<span<?php echo $t_gaji_detail->l_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sb->ListViewValue() ?></span>
</span>
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="ft_gaji_detailgrid$x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->FormValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="ft_gaji_detailgrid$o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_gaji_detail_grid->ListOptions->Render("body", "right", $t_gaji_detail_grid->RowCnt);
?>
	</tr>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD || $t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_gaji_detailgrid.UpdateOpts(<?php echo $t_gaji_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_gaji_detail->CurrentAction <> "gridadd" || $t_gaji_detail->CurrentMode == "copy")
		if (!$t_gaji_detail_grid->Recordset->EOF) $t_gaji_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_gaji_detail->CurrentMode == "add" || $t_gaji_detail->CurrentMode == "copy" || $t_gaji_detail->CurrentMode == "edit") {
		$t_gaji_detail_grid->RowIndex = '$rowindex$';
		$t_gaji_detail_grid->LoadDefaultValues();

		// Set row properties
		$t_gaji_detail->ResetAttrs();
		$t_gaji_detail->RowAttrs = array_merge($t_gaji_detail->RowAttrs, array('data-rowindex'=>$t_gaji_detail_grid->RowIndex, 'id'=>'r0_t_gaji_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_gaji_detail->RowAttrs["class"], "ewTemplate");
		$t_gaji_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_gaji_detail_grid->RenderRow();

		// Render list options
		$t_gaji_detail_grid->RenderListOptions();
		$t_gaji_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_gaji_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_gaji_detail_grid->ListOptions->Render("body", "left", $t_gaji_detail_grid->RowIndex);
?>
	<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<td data-name="peg_id">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span<?php echo $t_gaji_detail->peg_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->peg_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<td data-name="b_mn">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<span<?php echo $t_gaji_detail->b_mn->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_mn->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<td data-name="b_sn">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<span<?php echo $t_gaji_detail->b_sn->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_sn->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<td data-name="b_sl">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<span<?php echo $t_gaji_detail->b_sl->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_sl->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<td data-name="b_rb">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<span<?php echo $t_gaji_detail->b_rb->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_rb->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<td data-name="b_km">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<span<?php echo $t_gaji_detail->b_km->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_km->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<td data-name="b_jm">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<span<?php echo $t_gaji_detail->b_jm->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_jm->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<td data-name="b_sb">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<span<?php echo $t_gaji_detail->b_sb->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->b_sb->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<td data-name="l_mn">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<span<?php echo $t_gaji_detail->l_mn->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_mn->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<td data-name="l_sn">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<span<?php echo $t_gaji_detail->l_sn->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_sn->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<td data-name="l_sl">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<span<?php echo $t_gaji_detail->l_sl->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_sl->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<td data-name="l_rb">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<span<?php echo $t_gaji_detail->l_rb->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_rb->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<td data-name="l_km">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<span<?php echo $t_gaji_detail->l_km->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_km->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<td data-name="l_jm">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<span<?php echo $t_gaji_detail->l_jm->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_jm->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<td data-name="l_sb">
<?php if ($t_gaji_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<span<?php echo $t_gaji_detail->l_sb->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_gaji_detail->l_sb->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" id="o<?php echo $t_gaji_detail_grid->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_gaji_detail_grid->ListOptions->Render("body", "right", $t_gaji_detail_grid->RowCnt);
?>
<script type="text/javascript">
ft_gaji_detailgrid.UpdateOpts(<?php echo $t_gaji_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_gaji_detail->CurrentMode == "add" || $t_gaji_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_gaji_detail_grid->FormKeyCountName ?>" id="<?php echo $t_gaji_detail_grid->FormKeyCountName ?>" value="<?php echo $t_gaji_detail_grid->KeyCount ?>">
<?php echo $t_gaji_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_gaji_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_gaji_detail_grid->FormKeyCountName ?>" id="<?php echo $t_gaji_detail_grid->FormKeyCountName ?>" value="<?php echo $t_gaji_detail_grid->KeyCount ?>">
<?php echo $t_gaji_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_gaji_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_gaji_detailgrid">
</div>
<?php

// Close recordset
if ($t_gaji_detail_grid->Recordset)
	$t_gaji_detail_grid->Recordset->Close();
?>
<?php if ($t_gaji_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_gaji_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_gaji_detail_grid->TotalRecs == 0 && $t_gaji_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_gaji_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">
ft_gaji_detailgrid.Init();
</script>
<?php } ?>
<?php
$t_gaji_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_gaji_detail_grid->Page_Terminate();
?>
