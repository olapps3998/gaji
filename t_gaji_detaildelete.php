<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_gaji_detailinfo.php" ?>
<?php include_once "t_gaji_masterinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_gaji_detail_delete = NULL; // Initialize page object first

class ct_gaji_detail_delete extends ct_gaji_detail {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{CCC661CC-E251-4AC9-9C43-38E94C9A89E5}";

	// Table name
	var $TableName = 't_gaji_detail';

	// Page object name
	var $PageObjName = 't_gaji_detail_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t_gaji_detail)
		if (!isset($GLOBALS["t_gaji_detail"]) || get_class($GLOBALS["t_gaji_detail"]) == "ct_gaji_detail") {
			$GLOBALS["t_gaji_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_gaji_detail"];
		}

		// Table object (t_gaji_master)
		if (!isset($GLOBALS['t_gaji_master'])) $GLOBALS['t_gaji_master'] = new ct_gaji_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_gaji_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->peg_id->SetVisibility();
		$this->b_mn->SetVisibility();
		$this->b_sn->SetVisibility();
		$this->b_sl->SetVisibility();
		$this->b_rb->SetVisibility();
		$this->b_km->SetVisibility();
		$this->b_jm->SetVisibility();
		$this->b_sb->SetVisibility();
		$this->l_mn->SetVisibility();
		$this->l_sn->SetVisibility();
		$this->l_sl->SetVisibility();
		$this->l_rb->SetVisibility();
		$this->l_km->SetVisibility();
		$this->l_jm->SetVisibility();
		$this->l_sb->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t_gaji_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_gaji_detail);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t_gaji_detaillist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_gaji_detail class, t_gaji_detailinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t_gaji_detaillist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->gjd_id->DbValue = $row['gjd_id'];
		$this->gjm_id->DbValue = $row['gjm_id'];
		$this->peg_id->DbValue = $row['peg_id'];
		$this->b_mn->DbValue = $row['b_mn'];
		$this->b_sn->DbValue = $row['b_sn'];
		$this->b_sl->DbValue = $row['b_sl'];
		$this->b_rb->DbValue = $row['b_rb'];
		$this->b_km->DbValue = $row['b_km'];
		$this->b_jm->DbValue = $row['b_jm'];
		$this->b_sb->DbValue = $row['b_sb'];
		$this->l_mn->DbValue = $row['l_mn'];
		$this->l_sn->DbValue = $row['l_sn'];
		$this->l_sl->DbValue = $row['l_sl'];
		$this->l_rb->DbValue = $row['l_rb'];
		$this->l_km->DbValue = $row['l_km'];
		$this->l_jm->DbValue = $row['l_jm'];
		$this->l_sb->DbValue = $row['l_sb'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['gjd_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t_gaji_master") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_gjm_id"] <> "") {
					$GLOBALS["t_gaji_master"]->gjm_id->setQueryStringValue($_GET["fk_gjm_id"]);
					$this->gjm_id->setQueryStringValue($GLOBALS["t_gaji_master"]->gjm_id->QueryStringValue);
					$this->gjm_id->setSessionValue($this->gjm_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t_gaji_master"]->gjm_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t_gaji_master") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_gjm_id"] <> "") {
					$GLOBALS["t_gaji_master"]->gjm_id->setFormValue($_POST["fk_gjm_id"]);
					$this->gjm_id->setFormValue($GLOBALS["t_gaji_master"]->gjm_id->FormValue);
					$this->gjm_id->setSessionValue($this->gjm_id->FormValue);
					if (!is_numeric($GLOBALS["t_gaji_master"]->gjm_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_gaji_master") {
				if ($this->gjm_id->CurrentValue == "") $this->gjm_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_gaji_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_gaji_detail_delete)) $t_gaji_detail_delete = new ct_gaji_detail_delete();

// Page init
$t_gaji_detail_delete->Page_Init();

// Page main
$t_gaji_detail_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_gaji_detail_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_gaji_detaildelete = new ew_Form("ft_gaji_detaildelete", "delete");

// Form_CustomValidate event
ft_gaji_detaildelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_gaji_detaildelete.ValidateRequired = true;
<?php } else { ?>
ft_gaji_detaildelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_gaji_detaildelete.Lists["x_peg_id"] = {"LinkField":"x_peg_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_peg_nama","x_peg_jabatan","x_peg_upah",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_pegawai"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t_gaji_detail_delete->ShowPageHeader(); ?>
<?php
$t_gaji_detail_delete->ShowMessage();
?>
<form name="ft_gaji_detaildelete" id="ft_gaji_detaildelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_gaji_detail_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_gaji_detail_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_gaji_detail">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_gaji_detail_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t_gaji_detail->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<th><span id="elh_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id"><?php echo $t_gaji_detail->peg_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<th><span id="elh_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn"><?php echo $t_gaji_detail->b_mn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<th><span id="elh_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn"><?php echo $t_gaji_detail->b_sn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<th><span id="elh_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl"><?php echo $t_gaji_detail->b_sl->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<th><span id="elh_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb"><?php echo $t_gaji_detail->b_rb->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<th><span id="elh_t_gaji_detail_b_km" class="t_gaji_detail_b_km"><?php echo $t_gaji_detail->b_km->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<th><span id="elh_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm"><?php echo $t_gaji_detail->b_jm->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<th><span id="elh_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb"><?php echo $t_gaji_detail->b_sb->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<th><span id="elh_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn"><?php echo $t_gaji_detail->l_mn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<th><span id="elh_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn"><?php echo $t_gaji_detail->l_sn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<th><span id="elh_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl"><?php echo $t_gaji_detail->l_sl->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<th><span id="elh_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb"><?php echo $t_gaji_detail->l_rb->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<th><span id="elh_t_gaji_detail_l_km" class="t_gaji_detail_l_km"><?php echo $t_gaji_detail->l_km->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<th><span id="elh_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm"><?php echo $t_gaji_detail->l_jm->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<th><span id="elh_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb"><?php echo $t_gaji_detail->l_sb->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_gaji_detail_delete->RecCnt = 0;
$i = 0;
while (!$t_gaji_detail_delete->Recordset->EOF) {
	$t_gaji_detail_delete->RecCnt++;
	$t_gaji_detail_delete->RowCnt++;

	// Set row properties
	$t_gaji_detail->ResetAttrs();
	$t_gaji_detail->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_gaji_detail_delete->LoadRowValues($t_gaji_detail_delete->Recordset);

	// Render row
	$t_gaji_detail_delete->RenderRow();
?>
	<tr<?php echo $t_gaji_detail->RowAttributes() ?>>
<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<td<?php echo $t_gaji_detail->peg_id->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id">
<span<?php echo $t_gaji_detail->peg_id->ViewAttributes() ?>>
<?php echo $t_gaji_detail->peg_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<td<?php echo $t_gaji_detail->b_mn->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn">
<span<?php echo $t_gaji_detail->b_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_mn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<td<?php echo $t_gaji_detail->b_sn->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn">
<span<?php echo $t_gaji_detail->b_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<td<?php echo $t_gaji_detail->b_sl->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl">
<span<?php echo $t_gaji_detail->b_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sl->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<td<?php echo $t_gaji_detail->b_rb->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb">
<span<?php echo $t_gaji_detail->b_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_rb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<td<?php echo $t_gaji_detail->b_km->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_km" class="t_gaji_detail_b_km">
<span<?php echo $t_gaji_detail->b_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_km->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<td<?php echo $t_gaji_detail->b_jm->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm">
<span<?php echo $t_gaji_detail->b_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_jm->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<td<?php echo $t_gaji_detail->b_sb->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb">
<span<?php echo $t_gaji_detail->b_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<td<?php echo $t_gaji_detail->l_mn->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn">
<span<?php echo $t_gaji_detail->l_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_mn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<td<?php echo $t_gaji_detail->l_sn->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn">
<span<?php echo $t_gaji_detail->l_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<td<?php echo $t_gaji_detail->l_sl->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl">
<span<?php echo $t_gaji_detail->l_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sl->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<td<?php echo $t_gaji_detail->l_rb->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb">
<span<?php echo $t_gaji_detail->l_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_rb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<td<?php echo $t_gaji_detail->l_km->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_km" class="t_gaji_detail_l_km">
<span<?php echo $t_gaji_detail->l_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_km->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<td<?php echo $t_gaji_detail->l_jm->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm">
<span<?php echo $t_gaji_detail->l_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_jm->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<td<?php echo $t_gaji_detail->l_sb->CellAttributes() ?>>
<span id="el<?php echo $t_gaji_detail_delete->RowCnt ?>_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb">
<span<?php echo $t_gaji_detail->l_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_gaji_detail_delete->Recordset->MoveNext();
}
$t_gaji_detail_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_gaji_detail_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_gaji_detaildelete.Init();
</script>
<?php
$t_gaji_detail_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_gaji_detail_delete->Page_Terminate();
?>
