<?php

// Global variable for table object
$t_gaji_detail = NULL;

//
// Table class for t_gaji_detail
//
class ct_gaji_detail extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $gjd_id;
	var $gjm_id;
	var $peg_id;
	var $b_mn;
	var $b_sn;
	var $b_sl;
	var $b_rb;
	var $b_km;
	var $b_jm;
	var $b_sb;
	var $l_mn;
	var $l_sn;
	var $l_sl;
	var $l_rb;
	var $l_km;
	var $l_jm;
	var $l_sb;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_gaji_detail';
		$this->TableName = 't_gaji_detail';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_gaji_detail`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// gjd_id
		$this->gjd_id = new cField('t_gaji_detail', 't_gaji_detail', 'x_gjd_id', 'gjd_id', '`gjd_id`', '`gjd_id`', 3, -1, FALSE, '`gjd_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->gjd_id->Sortable = TRUE; // Allow sort
		$this->gjd_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['gjd_id'] = &$this->gjd_id;

		// gjm_id
		$this->gjm_id = new cField('t_gaji_detail', 't_gaji_detail', 'x_gjm_id', 'gjm_id', '`gjm_id`', '`gjm_id`', 3, -1, FALSE, '`gjm_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gjm_id->Sortable = TRUE; // Allow sort
		$this->gjm_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['gjm_id'] = &$this->gjm_id;

		// peg_id
		$this->peg_id = new cField('t_gaji_detail', 't_gaji_detail', 'x_peg_id', 'peg_id', '`peg_id`', '`peg_id`', 3, -1, FALSE, '`peg_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->peg_id->Sortable = TRUE; // Allow sort
		$this->peg_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->peg_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->peg_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['peg_id'] = &$this->peg_id;

		// b_mn
		$this->b_mn = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_mn', 'b_mn', '`b_mn`', '`b_mn`', 16, -1, FALSE, '`b_mn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_mn->Sortable = TRUE; // Allow sort
		$this->b_mn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_mn'] = &$this->b_mn;

		// b_sn
		$this->b_sn = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_sn', 'b_sn', '`b_sn`', '`b_sn`', 16, -1, FALSE, '`b_sn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_sn->Sortable = TRUE; // Allow sort
		$this->b_sn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_sn'] = &$this->b_sn;

		// b_sl
		$this->b_sl = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_sl', 'b_sl', '`b_sl`', '`b_sl`', 16, -1, FALSE, '`b_sl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_sl->Sortable = TRUE; // Allow sort
		$this->b_sl->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_sl'] = &$this->b_sl;

		// b_rb
		$this->b_rb = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_rb', 'b_rb', '`b_rb`', '`b_rb`', 16, -1, FALSE, '`b_rb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_rb->Sortable = TRUE; // Allow sort
		$this->b_rb->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_rb'] = &$this->b_rb;

		// b_km
		$this->b_km = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_km', 'b_km', '`b_km`', '`b_km`', 16, -1, FALSE, '`b_km`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_km->Sortable = TRUE; // Allow sort
		$this->b_km->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_km'] = &$this->b_km;

		// b_jm
		$this->b_jm = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_jm', 'b_jm', '`b_jm`', '`b_jm`', 16, -1, FALSE, '`b_jm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_jm->Sortable = TRUE; // Allow sort
		$this->b_jm->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_jm'] = &$this->b_jm;

		// b_sb
		$this->b_sb = new cField('t_gaji_detail', 't_gaji_detail', 'x_b_sb', 'b_sb', '`b_sb`', '`b_sb`', 16, -1, FALSE, '`b_sb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_sb->Sortable = TRUE; // Allow sort
		$this->b_sb->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_sb'] = &$this->b_sb;

		// l_mn
		$this->l_mn = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_mn', 'l_mn', '`l_mn`', '`l_mn`', 16, -1, FALSE, '`l_mn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_mn->Sortable = TRUE; // Allow sort
		$this->l_mn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_mn'] = &$this->l_mn;

		// l_sn
		$this->l_sn = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_sn', 'l_sn', '`l_sn`', '`l_sn`', 16, -1, FALSE, '`l_sn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_sn->Sortable = TRUE; // Allow sort
		$this->l_sn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_sn'] = &$this->l_sn;

		// l_sl
		$this->l_sl = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_sl', 'l_sl', '`l_sl`', '`l_sl`', 16, -1, FALSE, '`l_sl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_sl->Sortable = TRUE; // Allow sort
		$this->l_sl->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_sl'] = &$this->l_sl;

		// l_rb
		$this->l_rb = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_rb', 'l_rb', '`l_rb`', '`l_rb`', 16, -1, FALSE, '`l_rb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_rb->Sortable = TRUE; // Allow sort
		$this->l_rb->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_rb'] = &$this->l_rb;

		// l_km
		$this->l_km = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_km', 'l_km', '`l_km`', '`l_km`', 16, -1, FALSE, '`l_km`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_km->Sortable = TRUE; // Allow sort
		$this->l_km->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_km'] = &$this->l_km;

		// l_jm
		$this->l_jm = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_jm', 'l_jm', '`l_jm`', '`l_jm`', 16, -1, FALSE, '`l_jm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_jm->Sortable = TRUE; // Allow sort
		$this->l_jm->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_jm'] = &$this->l_jm;

		// l_sb
		$this->l_sb = new cField('t_gaji_detail', 't_gaji_detail', 'x_l_sb', 'l_sb', '`l_sb`', '`l_sb`', 16, -1, FALSE, '`l_sb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->l_sb->Sortable = TRUE; // Allow sort
		$this->l_sb->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['l_sb'] = &$this->l_sb;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "t_gaji_master") {
			if ($this->gjm_id->getSessionValue() <> "")
				$sMasterFilter .= "`gjm_id`=" . ew_QuotedValue($this->gjm_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "t_gaji_master") {
			if ($this->gjm_id->getSessionValue() <> "")
				$sDetailFilter .= "`gjm_id`=" . ew_QuotedValue($this->gjm_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_t_gaji_master() {
		return "`gjm_id`=@gjm_id@";
	}

	// Detail filter
	function SqlDetailFilter_t_gaji_master() {
		return "`gjm_id`=@gjm_id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_gaji_detail`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->gjd_id->setDbValue($conn->Insert_ID());
			$rs['gjd_id'] = $this->gjd_id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'gjd_id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('gjd_id', $rs))
				ew_AddFilter($where, ew_QuotedName('gjd_id', $this->DBID) . '=' . ew_QuotedValue($rs['gjd_id'], $this->gjd_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`gjd_id` = @gjd_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->gjd_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@gjd_id@", ew_AdjustSql($this->gjd_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t_gaji_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_gaji_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_gaji_detailview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_gaji_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_gaji_detailadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_gaji_detailadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_gaji_detailedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_gaji_detailadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_gaji_detaildelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "t_gaji_master" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_gjm_id=" . urlencode($this->gjm_id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "gjd_id:" . ew_VarToJson($this->gjd_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->gjd_id->CurrentValue)) {
			$sUrl .= "gjd_id=" . urlencode($this->gjd_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["gjd_id"]))
				$arKeys[] = ew_StripSlashes($_POST["gjd_id"]);
			elseif (isset($_GET["gjd_id"]))
				$arKeys[] = ew_StripSlashes($_GET["gjd_id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->gjd_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->gjd_id->setDbValue($rs->fields('gjd_id'));
		$this->gjm_id->setDbValue($rs->fields('gjm_id'));
		$this->peg_id->setDbValue($rs->fields('peg_id'));
		$this->b_mn->setDbValue($rs->fields('b_mn'));
		$this->b_sn->setDbValue($rs->fields('b_sn'));
		$this->b_sl->setDbValue($rs->fields('b_sl'));
		$this->b_rb->setDbValue($rs->fields('b_rb'));
		$this->b_km->setDbValue($rs->fields('b_km'));
		$this->b_jm->setDbValue($rs->fields('b_jm'));
		$this->b_sb->setDbValue($rs->fields('b_sb'));
		$this->l_mn->setDbValue($rs->fields('l_mn'));
		$this->l_sn->setDbValue($rs->fields('l_sn'));
		$this->l_sl->setDbValue($rs->fields('l_sl'));
		$this->l_rb->setDbValue($rs->fields('l_rb'));
		$this->l_km->setDbValue($rs->fields('l_km'));
		$this->l_jm->setDbValue($rs->fields('l_jm'));
		$this->l_sb->setDbValue($rs->fields('l_sb'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// gjd_id
		// gjm_id
		// peg_id
		// b_mn
		// b_sn
		// b_sl
		// b_rb
		// b_km
		// b_jm
		// b_sb
		// l_mn
		// l_sn
		// l_sl
		// l_rb
		// l_km
		// l_jm
		// l_sb
		// gjd_id

		$this->gjd_id->ViewValue = $this->gjd_id->CurrentValue;
		$this->gjd_id->ViewCustomAttributes = "";

		// gjm_id
		$this->gjm_id->ViewValue = $this->gjm_id->CurrentValue;
		$this->gjm_id->ViewCustomAttributes = "";

		// peg_id
		if (strval($this->peg_id->CurrentValue) <> "") {
			$sFilterWrk = "`peg_id`" . ew_SearchString("=", $this->peg_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `peg_id`, `peg_nama` AS `DispFld`, `peg_jabatan` AS `Disp2Fld`, `peg_upah` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_pegawai`";
		$sWhereWrk = "";
		$this->peg_id->LookupFilters = array("dx1" => '`peg_nama`', "dx2" => '`peg_jabatan`', "dx3" => '`peg_upah`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->peg_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = ew_FormatNumber($rswrk->fields('Disp3Fld'), 0, -2, -2, -1);
				$this->peg_id->ViewValue = $this->peg_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->peg_id->ViewValue = $this->peg_id->CurrentValue;
			}
		} else {
			$this->peg_id->ViewValue = NULL;
		}
		$this->peg_id->ViewCustomAttributes = "";

		// b_mn
		$this->b_mn->ViewValue = $this->b_mn->CurrentValue;
		$this->b_mn->ViewCustomAttributes = "";

		// b_sn
		$this->b_sn->ViewValue = $this->b_sn->CurrentValue;
		$this->b_sn->ViewCustomAttributes = "";

		// b_sl
		$this->b_sl->ViewValue = $this->b_sl->CurrentValue;
		$this->b_sl->ViewCustomAttributes = "";

		// b_rb
		$this->b_rb->ViewValue = $this->b_rb->CurrentValue;
		$this->b_rb->ViewCustomAttributes = "";

		// b_km
		$this->b_km->ViewValue = $this->b_km->CurrentValue;
		$this->b_km->ViewCustomAttributes = "";

		// b_jm
		$this->b_jm->ViewValue = $this->b_jm->CurrentValue;
		$this->b_jm->ViewCustomAttributes = "";

		// b_sb
		$this->b_sb->ViewValue = $this->b_sb->CurrentValue;
		$this->b_sb->ViewCustomAttributes = "";

		// l_mn
		$this->l_mn->ViewValue = $this->l_mn->CurrentValue;
		$this->l_mn->ViewCustomAttributes = "";

		// l_sn
		$this->l_sn->ViewValue = $this->l_sn->CurrentValue;
		$this->l_sn->ViewCustomAttributes = "";

		// l_sl
		$this->l_sl->ViewValue = $this->l_sl->CurrentValue;
		$this->l_sl->ViewCustomAttributes = "";

		// l_rb
		$this->l_rb->ViewValue = $this->l_rb->CurrentValue;
		$this->l_rb->ViewCustomAttributes = "";

		// l_km
		$this->l_km->ViewValue = $this->l_km->CurrentValue;
		$this->l_km->ViewCustomAttributes = "";

		// l_jm
		$this->l_jm->ViewValue = $this->l_jm->CurrentValue;
		$this->l_jm->ViewCustomAttributes = "";

		// l_sb
		$this->l_sb->ViewValue = $this->l_sb->CurrentValue;
		$this->l_sb->ViewCustomAttributes = "";

		// gjd_id
		$this->gjd_id->LinkCustomAttributes = "";
		$this->gjd_id->HrefValue = "";
		$this->gjd_id->TooltipValue = "";

		// gjm_id
		$this->gjm_id->LinkCustomAttributes = "";
		$this->gjm_id->HrefValue = "";
		$this->gjm_id->TooltipValue = "";

		// peg_id
		$this->peg_id->LinkCustomAttributes = "";
		$this->peg_id->HrefValue = "";
		$this->peg_id->TooltipValue = "";

		// b_mn
		$this->b_mn->LinkCustomAttributes = "";
		$this->b_mn->HrefValue = "";
		$this->b_mn->TooltipValue = "";

		// b_sn
		$this->b_sn->LinkCustomAttributes = "";
		$this->b_sn->HrefValue = "";
		$this->b_sn->TooltipValue = "";

		// b_sl
		$this->b_sl->LinkCustomAttributes = "";
		$this->b_sl->HrefValue = "";
		$this->b_sl->TooltipValue = "";

		// b_rb
		$this->b_rb->LinkCustomAttributes = "";
		$this->b_rb->HrefValue = "";
		$this->b_rb->TooltipValue = "";

		// b_km
		$this->b_km->LinkCustomAttributes = "";
		$this->b_km->HrefValue = "";
		$this->b_km->TooltipValue = "";

		// b_jm
		$this->b_jm->LinkCustomAttributes = "";
		$this->b_jm->HrefValue = "";
		$this->b_jm->TooltipValue = "";

		// b_sb
		$this->b_sb->LinkCustomAttributes = "";
		$this->b_sb->HrefValue = "";
		$this->b_sb->TooltipValue = "";

		// l_mn
		$this->l_mn->LinkCustomAttributes = "";
		$this->l_mn->HrefValue = "";
		$this->l_mn->TooltipValue = "";

		// l_sn
		$this->l_sn->LinkCustomAttributes = "";
		$this->l_sn->HrefValue = "";
		$this->l_sn->TooltipValue = "";

		// l_sl
		$this->l_sl->LinkCustomAttributes = "";
		$this->l_sl->HrefValue = "";
		$this->l_sl->TooltipValue = "";

		// l_rb
		$this->l_rb->LinkCustomAttributes = "";
		$this->l_rb->HrefValue = "";
		$this->l_rb->TooltipValue = "";

		// l_km
		$this->l_km->LinkCustomAttributes = "";
		$this->l_km->HrefValue = "";
		$this->l_km->TooltipValue = "";

		// l_jm
		$this->l_jm->LinkCustomAttributes = "";
		$this->l_jm->HrefValue = "";
		$this->l_jm->TooltipValue = "";

		// l_sb
		$this->l_sb->LinkCustomAttributes = "";
		$this->l_sb->HrefValue = "";
		$this->l_sb->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// gjd_id
		$this->gjd_id->EditAttrs["class"] = "form-control";
		$this->gjd_id->EditCustomAttributes = "";
		$this->gjd_id->EditValue = $this->gjd_id->CurrentValue;
		$this->gjd_id->ViewCustomAttributes = "";

		// gjm_id
		$this->gjm_id->EditAttrs["class"] = "form-control";
		$this->gjm_id->EditCustomAttributes = "";
		if ($this->gjm_id->getSessionValue() <> "") {
			$this->gjm_id->CurrentValue = $this->gjm_id->getSessionValue();
		$this->gjm_id->ViewValue = $this->gjm_id->CurrentValue;
		$this->gjm_id->ViewCustomAttributes = "";
		} else {
		$this->gjm_id->EditValue = $this->gjm_id->CurrentValue;
		$this->gjm_id->PlaceHolder = ew_RemoveHtml($this->gjm_id->FldCaption());
		}

		// peg_id
		$this->peg_id->EditAttrs["class"] = "form-control";
		$this->peg_id->EditCustomAttributes = "";

		// b_mn
		$this->b_mn->EditAttrs["class"] = "form-control";
		$this->b_mn->EditCustomAttributes = "";
		$this->b_mn->EditValue = $this->b_mn->CurrentValue;
		$this->b_mn->PlaceHolder = ew_RemoveHtml($this->b_mn->FldCaption());

		// b_sn
		$this->b_sn->EditAttrs["class"] = "form-control";
		$this->b_sn->EditCustomAttributes = "";
		$this->b_sn->EditValue = $this->b_sn->CurrentValue;
		$this->b_sn->PlaceHolder = ew_RemoveHtml($this->b_sn->FldCaption());

		// b_sl
		$this->b_sl->EditAttrs["class"] = "form-control";
		$this->b_sl->EditCustomAttributes = "";
		$this->b_sl->EditValue = $this->b_sl->CurrentValue;
		$this->b_sl->PlaceHolder = ew_RemoveHtml($this->b_sl->FldCaption());

		// b_rb
		$this->b_rb->EditAttrs["class"] = "form-control";
		$this->b_rb->EditCustomAttributes = "";
		$this->b_rb->EditValue = $this->b_rb->CurrentValue;
		$this->b_rb->PlaceHolder = ew_RemoveHtml($this->b_rb->FldCaption());

		// b_km
		$this->b_km->EditAttrs["class"] = "form-control";
		$this->b_km->EditCustomAttributes = "";
		$this->b_km->EditValue = $this->b_km->CurrentValue;
		$this->b_km->PlaceHolder = ew_RemoveHtml($this->b_km->FldCaption());

		// b_jm
		$this->b_jm->EditAttrs["class"] = "form-control";
		$this->b_jm->EditCustomAttributes = "";
		$this->b_jm->EditValue = $this->b_jm->CurrentValue;
		$this->b_jm->PlaceHolder = ew_RemoveHtml($this->b_jm->FldCaption());

		// b_sb
		$this->b_sb->EditAttrs["class"] = "form-control";
		$this->b_sb->EditCustomAttributes = "";
		$this->b_sb->EditValue = $this->b_sb->CurrentValue;
		$this->b_sb->PlaceHolder = ew_RemoveHtml($this->b_sb->FldCaption());

		// l_mn
		$this->l_mn->EditAttrs["class"] = "form-control";
		$this->l_mn->EditCustomAttributes = "";
		$this->l_mn->EditValue = $this->l_mn->CurrentValue;
		$this->l_mn->PlaceHolder = ew_RemoveHtml($this->l_mn->FldCaption());

		// l_sn
		$this->l_sn->EditAttrs["class"] = "form-control";
		$this->l_sn->EditCustomAttributes = "";
		$this->l_sn->EditValue = $this->l_sn->CurrentValue;
		$this->l_sn->PlaceHolder = ew_RemoveHtml($this->l_sn->FldCaption());

		// l_sl
		$this->l_sl->EditAttrs["class"] = "form-control";
		$this->l_sl->EditCustomAttributes = "";
		$this->l_sl->EditValue = $this->l_sl->CurrentValue;
		$this->l_sl->PlaceHolder = ew_RemoveHtml($this->l_sl->FldCaption());

		// l_rb
		$this->l_rb->EditAttrs["class"] = "form-control";
		$this->l_rb->EditCustomAttributes = "";
		$this->l_rb->EditValue = $this->l_rb->CurrentValue;
		$this->l_rb->PlaceHolder = ew_RemoveHtml($this->l_rb->FldCaption());

		// l_km
		$this->l_km->EditAttrs["class"] = "form-control";
		$this->l_km->EditCustomAttributes = "";
		$this->l_km->EditValue = $this->l_km->CurrentValue;
		$this->l_km->PlaceHolder = ew_RemoveHtml($this->l_km->FldCaption());

		// l_jm
		$this->l_jm->EditAttrs["class"] = "form-control";
		$this->l_jm->EditCustomAttributes = "";
		$this->l_jm->EditValue = $this->l_jm->CurrentValue;
		$this->l_jm->PlaceHolder = ew_RemoveHtml($this->l_jm->FldCaption());

		// l_sb
		$this->l_sb->EditAttrs["class"] = "form-control";
		$this->l_sb->EditCustomAttributes = "";
		$this->l_sb->EditValue = $this->l_sb->CurrentValue;
		$this->l_sb->PlaceHolder = ew_RemoveHtml($this->l_sb->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->peg_id->Exportable) $Doc->ExportCaption($this->peg_id);
					if ($this->b_mn->Exportable) $Doc->ExportCaption($this->b_mn);
					if ($this->b_sn->Exportable) $Doc->ExportCaption($this->b_sn);
					if ($this->b_sl->Exportable) $Doc->ExportCaption($this->b_sl);
					if ($this->b_rb->Exportable) $Doc->ExportCaption($this->b_rb);
					if ($this->b_km->Exportable) $Doc->ExportCaption($this->b_km);
					if ($this->b_jm->Exportable) $Doc->ExportCaption($this->b_jm);
					if ($this->b_sb->Exportable) $Doc->ExportCaption($this->b_sb);
					if ($this->l_mn->Exportable) $Doc->ExportCaption($this->l_mn);
					if ($this->l_sn->Exportable) $Doc->ExportCaption($this->l_sn);
					if ($this->l_sl->Exportable) $Doc->ExportCaption($this->l_sl);
					if ($this->l_rb->Exportable) $Doc->ExportCaption($this->l_rb);
					if ($this->l_km->Exportable) $Doc->ExportCaption($this->l_km);
					if ($this->l_jm->Exportable) $Doc->ExportCaption($this->l_jm);
					if ($this->l_sb->Exportable) $Doc->ExportCaption($this->l_sb);
				} else {
					if ($this->gjd_id->Exportable) $Doc->ExportCaption($this->gjd_id);
					if ($this->gjm_id->Exportable) $Doc->ExportCaption($this->gjm_id);
					if ($this->peg_id->Exportable) $Doc->ExportCaption($this->peg_id);
					if ($this->b_mn->Exportable) $Doc->ExportCaption($this->b_mn);
					if ($this->b_sn->Exportable) $Doc->ExportCaption($this->b_sn);
					if ($this->b_sl->Exportable) $Doc->ExportCaption($this->b_sl);
					if ($this->b_rb->Exportable) $Doc->ExportCaption($this->b_rb);
					if ($this->b_km->Exportable) $Doc->ExportCaption($this->b_km);
					if ($this->b_jm->Exportable) $Doc->ExportCaption($this->b_jm);
					if ($this->b_sb->Exportable) $Doc->ExportCaption($this->b_sb);
					if ($this->l_mn->Exportable) $Doc->ExportCaption($this->l_mn);
					if ($this->l_sn->Exportable) $Doc->ExportCaption($this->l_sn);
					if ($this->l_sl->Exportable) $Doc->ExportCaption($this->l_sl);
					if ($this->l_rb->Exportable) $Doc->ExportCaption($this->l_rb);
					if ($this->l_km->Exportable) $Doc->ExportCaption($this->l_km);
					if ($this->l_jm->Exportable) $Doc->ExportCaption($this->l_jm);
					if ($this->l_sb->Exportable) $Doc->ExportCaption($this->l_sb);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->peg_id->Exportable) $Doc->ExportField($this->peg_id);
						if ($this->b_mn->Exportable) $Doc->ExportField($this->b_mn);
						if ($this->b_sn->Exportable) $Doc->ExportField($this->b_sn);
						if ($this->b_sl->Exportable) $Doc->ExportField($this->b_sl);
						if ($this->b_rb->Exportable) $Doc->ExportField($this->b_rb);
						if ($this->b_km->Exportable) $Doc->ExportField($this->b_km);
						if ($this->b_jm->Exportable) $Doc->ExportField($this->b_jm);
						if ($this->b_sb->Exportable) $Doc->ExportField($this->b_sb);
						if ($this->l_mn->Exportable) $Doc->ExportField($this->l_mn);
						if ($this->l_sn->Exportable) $Doc->ExportField($this->l_sn);
						if ($this->l_sl->Exportable) $Doc->ExportField($this->l_sl);
						if ($this->l_rb->Exportable) $Doc->ExportField($this->l_rb);
						if ($this->l_km->Exportable) $Doc->ExportField($this->l_km);
						if ($this->l_jm->Exportable) $Doc->ExportField($this->l_jm);
						if ($this->l_sb->Exportable) $Doc->ExportField($this->l_sb);
					} else {
						if ($this->gjd_id->Exportable) $Doc->ExportField($this->gjd_id);
						if ($this->gjm_id->Exportable) $Doc->ExportField($this->gjm_id);
						if ($this->peg_id->Exportable) $Doc->ExportField($this->peg_id);
						if ($this->b_mn->Exportable) $Doc->ExportField($this->b_mn);
						if ($this->b_sn->Exportable) $Doc->ExportField($this->b_sn);
						if ($this->b_sl->Exportable) $Doc->ExportField($this->b_sl);
						if ($this->b_rb->Exportable) $Doc->ExportField($this->b_rb);
						if ($this->b_km->Exportable) $Doc->ExportField($this->b_km);
						if ($this->b_jm->Exportable) $Doc->ExportField($this->b_jm);
						if ($this->b_sb->Exportable) $Doc->ExportField($this->b_sb);
						if ($this->l_mn->Exportable) $Doc->ExportField($this->l_mn);
						if ($this->l_sn->Exportable) $Doc->ExportField($this->l_sn);
						if ($this->l_sl->Exportable) $Doc->ExportField($this->l_sl);
						if ($this->l_rb->Exportable) $Doc->ExportField($this->l_rb);
						if ($this->l_km->Exportable) $Doc->ExportField($this->l_km);
						if ($this->l_jm->Exportable) $Doc->ExportField($this->l_jm);
						if ($this->l_sb->Exportable) $Doc->ExportField($this->l_sb);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't_gaji_detail';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't_gaji_detail';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['gjd_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't_gaji_detail';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['gjd_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't_gaji_detail';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['gjd_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
