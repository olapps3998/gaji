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

$t_gaji_detail_add = NULL; // Initialize page object first

class ct_gaji_detail_add extends ct_gaji_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{CCC661CC-E251-4AC9-9C43-38E94C9A89E5}";

	// Table name
	var $TableName = 't_gaji_detail';

	// Page object name
	var $PageObjName = 't_gaji_detail_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["gjd_id"] != "") {
				$this->gjd_id->setQueryStringValue($_GET["gjd_id"]);
				$this->setKey("gjd_id", $this->gjd_id->CurrentValue); // Set up key
			} else {
				$this->setKey("gjd_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t_gaji_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_gaji_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_gaji_detailview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->peg_id->CurrentValue = NULL;
		$this->peg_id->OldValue = $this->peg_id->CurrentValue;
		$this->b_mn->CurrentValue = NULL;
		$this->b_mn->OldValue = $this->b_mn->CurrentValue;
		$this->b_sn->CurrentValue = NULL;
		$this->b_sn->OldValue = $this->b_sn->CurrentValue;
		$this->b_sl->CurrentValue = NULL;
		$this->b_sl->OldValue = $this->b_sl->CurrentValue;
		$this->b_rb->CurrentValue = NULL;
		$this->b_rb->OldValue = $this->b_rb->CurrentValue;
		$this->b_km->CurrentValue = NULL;
		$this->b_km->OldValue = $this->b_km->CurrentValue;
		$this->b_jm->CurrentValue = NULL;
		$this->b_jm->OldValue = $this->b_jm->CurrentValue;
		$this->b_sb->CurrentValue = NULL;
		$this->b_sb->OldValue = $this->b_sb->CurrentValue;
		$this->l_mn->CurrentValue = NULL;
		$this->l_mn->OldValue = $this->l_mn->CurrentValue;
		$this->l_sn->CurrentValue = NULL;
		$this->l_sn->OldValue = $this->l_sn->CurrentValue;
		$this->l_sl->CurrentValue = NULL;
		$this->l_sl->OldValue = $this->l_sl->CurrentValue;
		$this->l_rb->CurrentValue = NULL;
		$this->l_rb->OldValue = $this->l_rb->CurrentValue;
		$this->l_km->CurrentValue = NULL;
		$this->l_km->OldValue = $this->l_km->CurrentValue;
		$this->l_jm->CurrentValue = NULL;
		$this->l_jm->OldValue = $this->l_jm->CurrentValue;
		$this->l_sb->CurrentValue = NULL;
		$this->l_sb->OldValue = $this->l_sb->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->peg_id->FldIsDetailKey) {
			$this->peg_id->setFormValue($objForm->GetValue("x_peg_id"));
		}
		if (!$this->b_mn->FldIsDetailKey) {
			$this->b_mn->setFormValue($objForm->GetValue("x_b_mn"));
		}
		if (!$this->b_sn->FldIsDetailKey) {
			$this->b_sn->setFormValue($objForm->GetValue("x_b_sn"));
		}
		if (!$this->b_sl->FldIsDetailKey) {
			$this->b_sl->setFormValue($objForm->GetValue("x_b_sl"));
		}
		if (!$this->b_rb->FldIsDetailKey) {
			$this->b_rb->setFormValue($objForm->GetValue("x_b_rb"));
		}
		if (!$this->b_km->FldIsDetailKey) {
			$this->b_km->setFormValue($objForm->GetValue("x_b_km"));
		}
		if (!$this->b_jm->FldIsDetailKey) {
			$this->b_jm->setFormValue($objForm->GetValue("x_b_jm"));
		}
		if (!$this->b_sb->FldIsDetailKey) {
			$this->b_sb->setFormValue($objForm->GetValue("x_b_sb"));
		}
		if (!$this->l_mn->FldIsDetailKey) {
			$this->l_mn->setFormValue($objForm->GetValue("x_l_mn"));
		}
		if (!$this->l_sn->FldIsDetailKey) {
			$this->l_sn->setFormValue($objForm->GetValue("x_l_sn"));
		}
		if (!$this->l_sl->FldIsDetailKey) {
			$this->l_sl->setFormValue($objForm->GetValue("x_l_sl"));
		}
		if (!$this->l_rb->FldIsDetailKey) {
			$this->l_rb->setFormValue($objForm->GetValue("x_l_rb"));
		}
		if (!$this->l_km->FldIsDetailKey) {
			$this->l_km->setFormValue($objForm->GetValue("x_l_km"));
		}
		if (!$this->l_jm->FldIsDetailKey) {
			$this->l_jm->setFormValue($objForm->GetValue("x_l_jm"));
		}
		if (!$this->l_sb->FldIsDetailKey) {
			$this->l_sb->setFormValue($objForm->GetValue("x_l_sb"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->peg_id->CurrentValue = $this->peg_id->FormValue;
		$this->b_mn->CurrentValue = $this->b_mn->FormValue;
		$this->b_sn->CurrentValue = $this->b_sn->FormValue;
		$this->b_sl->CurrentValue = $this->b_sl->FormValue;
		$this->b_rb->CurrentValue = $this->b_rb->FormValue;
		$this->b_km->CurrentValue = $this->b_km->FormValue;
		$this->b_jm->CurrentValue = $this->b_jm->FormValue;
		$this->b_sb->CurrentValue = $this->b_sb->FormValue;
		$this->l_mn->CurrentValue = $this->l_mn->FormValue;
		$this->l_sn->CurrentValue = $this->l_sn->FormValue;
		$this->l_sl->CurrentValue = $this->l_sl->FormValue;
		$this->l_rb->CurrentValue = $this->l_rb->FormValue;
		$this->l_km->CurrentValue = $this->l_km->FormValue;
		$this->l_jm->CurrentValue = $this->l_jm->FormValue;
		$this->l_sb->CurrentValue = $this->l_sb->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("gjd_id")) <> "")
			$this->gjd_id->CurrentValue = $this->getKey("gjd_id"); // gjd_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// peg_id
			$this->peg_id->EditCustomAttributes = "";
			if (trim(strval($this->peg_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`peg_id`" . ew_SearchString("=", $this->peg_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `peg_id`, `peg_nama` AS `DispFld`, `peg_jabatan` AS `Disp2Fld`, `peg_upah` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_pegawai`";
			$sWhereWrk = "";
			$this->peg_id->LookupFilters = array("dx1" => '`peg_nama`', "dx2" => '`peg_jabatan`', "dx3" => '`peg_upah`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->peg_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode(ew_FormatNumber($rswrk->fields('Disp3Fld'), 0, -2, -2, -1));
				$this->peg_id->ViewValue = $this->peg_id->DisplayValue($arwrk);
			} else {
				$this->peg_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][3] = ew_FormatNumber($arwrk[$rowcntwrk][3], 0, -2, -2, -1);
			}
			$this->peg_id->EditValue = $arwrk;

			// b_mn
			$this->b_mn->EditAttrs["class"] = "form-control";
			$this->b_mn->EditCustomAttributes = "";
			$this->b_mn->EditValue = ew_HtmlEncode($this->b_mn->CurrentValue);
			$this->b_mn->PlaceHolder = ew_RemoveHtml($this->b_mn->FldCaption());

			// b_sn
			$this->b_sn->EditAttrs["class"] = "form-control";
			$this->b_sn->EditCustomAttributes = "";
			$this->b_sn->EditValue = ew_HtmlEncode($this->b_sn->CurrentValue);
			$this->b_sn->PlaceHolder = ew_RemoveHtml($this->b_sn->FldCaption());

			// b_sl
			$this->b_sl->EditAttrs["class"] = "form-control";
			$this->b_sl->EditCustomAttributes = "";
			$this->b_sl->EditValue = ew_HtmlEncode($this->b_sl->CurrentValue);
			$this->b_sl->PlaceHolder = ew_RemoveHtml($this->b_sl->FldCaption());

			// b_rb
			$this->b_rb->EditAttrs["class"] = "form-control";
			$this->b_rb->EditCustomAttributes = "";
			$this->b_rb->EditValue = ew_HtmlEncode($this->b_rb->CurrentValue);
			$this->b_rb->PlaceHolder = ew_RemoveHtml($this->b_rb->FldCaption());

			// b_km
			$this->b_km->EditAttrs["class"] = "form-control";
			$this->b_km->EditCustomAttributes = "";
			$this->b_km->EditValue = ew_HtmlEncode($this->b_km->CurrentValue);
			$this->b_km->PlaceHolder = ew_RemoveHtml($this->b_km->FldCaption());

			// b_jm
			$this->b_jm->EditAttrs["class"] = "form-control";
			$this->b_jm->EditCustomAttributes = "";
			$this->b_jm->EditValue = ew_HtmlEncode($this->b_jm->CurrentValue);
			$this->b_jm->PlaceHolder = ew_RemoveHtml($this->b_jm->FldCaption());

			// b_sb
			$this->b_sb->EditAttrs["class"] = "form-control";
			$this->b_sb->EditCustomAttributes = "";
			$this->b_sb->EditValue = ew_HtmlEncode($this->b_sb->CurrentValue);
			$this->b_sb->PlaceHolder = ew_RemoveHtml($this->b_sb->FldCaption());

			// l_mn
			$this->l_mn->EditAttrs["class"] = "form-control";
			$this->l_mn->EditCustomAttributes = "";
			$this->l_mn->EditValue = ew_HtmlEncode($this->l_mn->CurrentValue);
			$this->l_mn->PlaceHolder = ew_RemoveHtml($this->l_mn->FldCaption());

			// l_sn
			$this->l_sn->EditAttrs["class"] = "form-control";
			$this->l_sn->EditCustomAttributes = "";
			$this->l_sn->EditValue = ew_HtmlEncode($this->l_sn->CurrentValue);
			$this->l_sn->PlaceHolder = ew_RemoveHtml($this->l_sn->FldCaption());

			// l_sl
			$this->l_sl->EditAttrs["class"] = "form-control";
			$this->l_sl->EditCustomAttributes = "";
			$this->l_sl->EditValue = ew_HtmlEncode($this->l_sl->CurrentValue);
			$this->l_sl->PlaceHolder = ew_RemoveHtml($this->l_sl->FldCaption());

			// l_rb
			$this->l_rb->EditAttrs["class"] = "form-control";
			$this->l_rb->EditCustomAttributes = "";
			$this->l_rb->EditValue = ew_HtmlEncode($this->l_rb->CurrentValue);
			$this->l_rb->PlaceHolder = ew_RemoveHtml($this->l_rb->FldCaption());

			// l_km
			$this->l_km->EditAttrs["class"] = "form-control";
			$this->l_km->EditCustomAttributes = "";
			$this->l_km->EditValue = ew_HtmlEncode($this->l_km->CurrentValue);
			$this->l_km->PlaceHolder = ew_RemoveHtml($this->l_km->FldCaption());

			// l_jm
			$this->l_jm->EditAttrs["class"] = "form-control";
			$this->l_jm->EditCustomAttributes = "";
			$this->l_jm->EditValue = ew_HtmlEncode($this->l_jm->CurrentValue);
			$this->l_jm->PlaceHolder = ew_RemoveHtml($this->l_jm->FldCaption());

			// l_sb
			$this->l_sb->EditAttrs["class"] = "form-control";
			$this->l_sb->EditCustomAttributes = "";
			$this->l_sb->EditValue = ew_HtmlEncode($this->l_sb->CurrentValue);
			$this->l_sb->PlaceHolder = ew_RemoveHtml($this->l_sb->FldCaption());

			// Add refer script
			// peg_id

			$this->peg_id->LinkCustomAttributes = "";
			$this->peg_id->HrefValue = "";

			// b_mn
			$this->b_mn->LinkCustomAttributes = "";
			$this->b_mn->HrefValue = "";

			// b_sn
			$this->b_sn->LinkCustomAttributes = "";
			$this->b_sn->HrefValue = "";

			// b_sl
			$this->b_sl->LinkCustomAttributes = "";
			$this->b_sl->HrefValue = "";

			// b_rb
			$this->b_rb->LinkCustomAttributes = "";
			$this->b_rb->HrefValue = "";

			// b_km
			$this->b_km->LinkCustomAttributes = "";
			$this->b_km->HrefValue = "";

			// b_jm
			$this->b_jm->LinkCustomAttributes = "";
			$this->b_jm->HrefValue = "";

			// b_sb
			$this->b_sb->LinkCustomAttributes = "";
			$this->b_sb->HrefValue = "";

			// l_mn
			$this->l_mn->LinkCustomAttributes = "";
			$this->l_mn->HrefValue = "";

			// l_sn
			$this->l_sn->LinkCustomAttributes = "";
			$this->l_sn->HrefValue = "";

			// l_sl
			$this->l_sl->LinkCustomAttributes = "";
			$this->l_sl->HrefValue = "";

			// l_rb
			$this->l_rb->LinkCustomAttributes = "";
			$this->l_rb->HrefValue = "";

			// l_km
			$this->l_km->LinkCustomAttributes = "";
			$this->l_km->HrefValue = "";

			// l_jm
			$this->l_jm->LinkCustomAttributes = "";
			$this->l_jm->HrefValue = "";

			// l_sb
			$this->l_sb->LinkCustomAttributes = "";
			$this->l_sb->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->peg_id->FldIsDetailKey && !is_null($this->peg_id->FormValue) && $this->peg_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->peg_id->FldCaption(), $this->peg_id->ReqErrMsg));
		}
		if (!$this->b_mn->FldIsDetailKey && !is_null($this->b_mn->FormValue) && $this->b_mn->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_mn->FldCaption(), $this->b_mn->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_mn->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_mn->FldErrMsg());
		}
		if (!$this->b_sn->FldIsDetailKey && !is_null($this->b_sn->FormValue) && $this->b_sn->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_sn->FldCaption(), $this->b_sn->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_sn->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_sn->FldErrMsg());
		}
		if (!$this->b_sl->FldIsDetailKey && !is_null($this->b_sl->FormValue) && $this->b_sl->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_sl->FldCaption(), $this->b_sl->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_sl->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_sl->FldErrMsg());
		}
		if (!$this->b_rb->FldIsDetailKey && !is_null($this->b_rb->FormValue) && $this->b_rb->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_rb->FldCaption(), $this->b_rb->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_rb->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_rb->FldErrMsg());
		}
		if (!$this->b_km->FldIsDetailKey && !is_null($this->b_km->FormValue) && $this->b_km->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_km->FldCaption(), $this->b_km->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_km->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_km->FldErrMsg());
		}
		if (!$this->b_jm->FldIsDetailKey && !is_null($this->b_jm->FormValue) && $this->b_jm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_jm->FldCaption(), $this->b_jm->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_jm->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_jm->FldErrMsg());
		}
		if (!$this->b_sb->FldIsDetailKey && !is_null($this->b_sb->FormValue) && $this->b_sb->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_sb->FldCaption(), $this->b_sb->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->b_sb->FormValue)) {
			ew_AddMessage($gsFormError, $this->b_sb->FldErrMsg());
		}
		if (!$this->l_mn->FldIsDetailKey && !is_null($this->l_mn->FormValue) && $this->l_mn->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_mn->FldCaption(), $this->l_mn->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_mn->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_mn->FldErrMsg());
		}
		if (!$this->l_sn->FldIsDetailKey && !is_null($this->l_sn->FormValue) && $this->l_sn->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_sn->FldCaption(), $this->l_sn->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_sn->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_sn->FldErrMsg());
		}
		if (!$this->l_sl->FldIsDetailKey && !is_null($this->l_sl->FormValue) && $this->l_sl->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_sl->FldCaption(), $this->l_sl->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_sl->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_sl->FldErrMsg());
		}
		if (!$this->l_rb->FldIsDetailKey && !is_null($this->l_rb->FormValue) && $this->l_rb->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_rb->FldCaption(), $this->l_rb->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_rb->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_rb->FldErrMsg());
		}
		if (!$this->l_km->FldIsDetailKey && !is_null($this->l_km->FormValue) && $this->l_km->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_km->FldCaption(), $this->l_km->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_km->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_km->FldErrMsg());
		}
		if (!$this->l_jm->FldIsDetailKey && !is_null($this->l_jm->FormValue) && $this->l_jm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_jm->FldCaption(), $this->l_jm->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_jm->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_jm->FldErrMsg());
		}
		if (!$this->l_sb->FldIsDetailKey && !is_null($this->l_sb->FormValue) && $this->l_sb->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->l_sb->FldCaption(), $this->l_sb->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->l_sb->FormValue)) {
			ew_AddMessage($gsFormError, $this->l_sb->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// peg_id
		$this->peg_id->SetDbValueDef($rsnew, $this->peg_id->CurrentValue, 0, FALSE);

		// b_mn
		$this->b_mn->SetDbValueDef($rsnew, $this->b_mn->CurrentValue, 0, FALSE);

		// b_sn
		$this->b_sn->SetDbValueDef($rsnew, $this->b_sn->CurrentValue, 0, FALSE);

		// b_sl
		$this->b_sl->SetDbValueDef($rsnew, $this->b_sl->CurrentValue, 0, FALSE);

		// b_rb
		$this->b_rb->SetDbValueDef($rsnew, $this->b_rb->CurrentValue, 0, FALSE);

		// b_km
		$this->b_km->SetDbValueDef($rsnew, $this->b_km->CurrentValue, 0, FALSE);

		// b_jm
		$this->b_jm->SetDbValueDef($rsnew, $this->b_jm->CurrentValue, 0, FALSE);

		// b_sb
		$this->b_sb->SetDbValueDef($rsnew, $this->b_sb->CurrentValue, 0, FALSE);

		// l_mn
		$this->l_mn->SetDbValueDef($rsnew, $this->l_mn->CurrentValue, 0, FALSE);

		// l_sn
		$this->l_sn->SetDbValueDef($rsnew, $this->l_sn->CurrentValue, 0, FALSE);

		// l_sl
		$this->l_sl->SetDbValueDef($rsnew, $this->l_sl->CurrentValue, 0, FALSE);

		// l_rb
		$this->l_rb->SetDbValueDef($rsnew, $this->l_rb->CurrentValue, 0, FALSE);

		// l_km
		$this->l_km->SetDbValueDef($rsnew, $this->l_km->CurrentValue, 0, FALSE);

		// l_jm
		$this->l_jm->SetDbValueDef($rsnew, $this->l_jm->CurrentValue, 0, FALSE);

		// l_sb
		$this->l_sb->SetDbValueDef($rsnew, $this->l_sb->CurrentValue, 0, FALSE);

		// gjm_id
		if ($this->gjm_id->getSessionValue() <> "") {
			$rsnew['gjm_id'] = $this->gjm_id->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_peg_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `peg_id` AS `LinkFld`, `peg_nama` AS `DispFld`, `peg_jabatan` AS `Disp2Fld`, `peg_upah` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_pegawai`";
			$sWhereWrk = "{filter}";
			$this->peg_id->LookupFilters = array("dx1" => '`peg_nama`', "dx2" => '`peg_jabatan`', "dx3" => '`peg_upah`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`peg_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->peg_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_gaji_detail_add)) $t_gaji_detail_add = new ct_gaji_detail_add();

// Page init
$t_gaji_detail_add->Page_Init();

// Page main
$t_gaji_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_gaji_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_gaji_detailadd = new ew_Form("ft_gaji_detailadd", "add");

// Validate form
ft_gaji_detailadd.Validate = function() {
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
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft_gaji_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_gaji_detailadd.ValidateRequired = true;
<?php } else { ?>
ft_gaji_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_gaji_detailadd.Lists["x_peg_id"] = {"LinkField":"x_peg_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_peg_nama","x_peg_jabatan","x_peg_upah",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_pegawai"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_gaji_detail_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t_gaji_detail_add->ShowPageHeader(); ?>
<?php
$t_gaji_detail_add->ShowMessage();
?>
<form name="ft_gaji_detailadd" id="ft_gaji_detailadd" class="<?php echo $t_gaji_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_gaji_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_gaji_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_gaji_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_gaji_detail_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($t_gaji_detail->getCurrentMasterTable() == "t_gaji_master") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_gaji_master">
<input type="hidden" name="fk_gjm_id" value="<?php echo $t_gaji_detail->gjm_id->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
	<div id="r_peg_id" class="form-group">
		<label id="elh_t_gaji_detail_peg_id" for="x_peg_id" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->peg_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->peg_id->CellAttributes() ?>>
<span id="el_t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x_peg_id" id="x_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x_peg_id" id="s_x_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<?php echo $t_gaji_detail->peg_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
	<div id="r_b_mn" class="form-group">
		<label id="elh_t_gaji_detail_b_mn" for="x_b_mn" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_mn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_mn->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x_b_mn" id="x_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_mn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
	<div id="r_b_sn" class="form-group">
		<label id="elh_t_gaji_detail_b_sn" for="x_b_sn" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_sn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_sn->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x_b_sn" id="x_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_sn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
	<div id="r_b_sl" class="form-group">
		<label id="elh_t_gaji_detail_b_sl" for="x_b_sl" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_sl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_sl->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x_b_sl" id="x_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_sl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
	<div id="r_b_rb" class="form-group">
		<label id="elh_t_gaji_detail_b_rb" for="x_b_rb" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_rb->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_rb->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x_b_rb" id="x_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_rb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
	<div id="r_b_km" class="form-group">
		<label id="elh_t_gaji_detail_b_km" for="x_b_km" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_km->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_km->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x_b_km" id="x_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_km->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
	<div id="r_b_jm" class="form-group">
		<label id="elh_t_gaji_detail_b_jm" for="x_b_jm" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_jm->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_jm->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x_b_jm" id="x_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_jm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
	<div id="r_b_sb" class="form-group">
		<label id="elh_t_gaji_detail_b_sb" for="x_b_sb" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->b_sb->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->b_sb->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x_b_sb" id="x_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->b_sb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
	<div id="r_l_mn" class="form-group">
		<label id="elh_t_gaji_detail_l_mn" for="x_l_mn" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_mn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_mn->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x_l_mn" id="x_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_mn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
	<div id="r_l_sn" class="form-group">
		<label id="elh_t_gaji_detail_l_sn" for="x_l_sn" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_sn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_sn->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x_l_sn" id="x_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_sn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
	<div id="r_l_sl" class="form-group">
		<label id="elh_t_gaji_detail_l_sl" for="x_l_sl" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_sl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_sl->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x_l_sl" id="x_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_sl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
	<div id="r_l_rb" class="form-group">
		<label id="elh_t_gaji_detail_l_rb" for="x_l_rb" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_rb->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_rb->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x_l_rb" id="x_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_rb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
	<div id="r_l_km" class="form-group">
		<label id="elh_t_gaji_detail_l_km" for="x_l_km" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_km->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_km->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x_l_km" id="x_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_km->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
	<div id="r_l_jm" class="form-group">
		<label id="elh_t_gaji_detail_l_jm" for="x_l_jm" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_jm->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_jm->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x_l_jm" id="x_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_jm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
	<div id="r_l_sb" class="form-group">
		<label id="elh_t_gaji_detail_l_sb" for="x_l_sb" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_detail->l_sb->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_detail->l_sb->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x_l_sb" id="x_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<?php echo $t_gaji_detail->l_sb->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($t_gaji_detail->gjm_id->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_gjm_id" id="x_gjm_id" value="<?php echo ew_HtmlEncode(strval($t_gaji_detail->gjm_id->getSessionValue())) ?>">
<?php } ?>
<?php if (!$t_gaji_detail_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_gaji_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_gaji_detailadd.Init();
</script>
<?php
$t_gaji_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_gaji_detail_add->Page_Terminate();
?>
