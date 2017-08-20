<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_gaji_masterinfo.php" ?>
<?php include_once "t_gaji_detailgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_gaji_master_add = NULL; // Initialize page object first

class ct_gaji_master_add extends ct_gaji_master {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{CCC661CC-E251-4AC9-9C43-38E94C9A89E5}";

	// Table name
	var $TableName = 't_gaji_master';

	// Page object name
	var $PageObjName = 't_gaji_master_add';

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

		// Table object (t_gaji_master)
		if (!isset($GLOBALS["t_gaji_master"]) || get_class($GLOBALS["t_gaji_master"]) == "ct_gaji_master") {
			$GLOBALS["t_gaji_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_gaji_master"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_gaji_master', TRUE);

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
		$this->prj_id->SetVisibility();
		$this->per_id->SetVisibility();
		$this->gjm_total->SetVisibility();

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

			// Process auto fill for detail table 't_gaji_detail'
			if (@$_POST["grid"] == "ft_gaji_detailgrid") {
				if (!isset($GLOBALS["t_gaji_detail_grid"])) $GLOBALS["t_gaji_detail_grid"] = new ct_gaji_detail_grid;
				$GLOBALS["t_gaji_detail_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $t_gaji_master;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_gaji_master);
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["gjm_id"] != "") {
				$this->gjm_id->setQueryStringValue($_GET["gjm_id"]);
				$this->setKey("gjm_id", $this->gjm_id->CurrentValue); // Set up key
			} else {
				$this->setKey("gjm_id", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("t_gaji_masterlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_gaji_masterlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_gaji_masterview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->prj_id->CurrentValue = NULL;
		$this->prj_id->OldValue = $this->prj_id->CurrentValue;
		$this->per_id->CurrentValue = NULL;
		$this->per_id->OldValue = $this->per_id->CurrentValue;
		$this->gjm_total->CurrentValue = NULL;
		$this->gjm_total->OldValue = $this->gjm_total->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->prj_id->FldIsDetailKey) {
			$this->prj_id->setFormValue($objForm->GetValue("x_prj_id"));
		}
		if (!$this->per_id->FldIsDetailKey) {
			$this->per_id->setFormValue($objForm->GetValue("x_per_id"));
		}
		if (!$this->gjm_total->FldIsDetailKey) {
			$this->gjm_total->setFormValue($objForm->GetValue("x_gjm_total"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->prj_id->CurrentValue = $this->prj_id->FormValue;
		$this->per_id->CurrentValue = $this->per_id->FormValue;
		$this->gjm_total->CurrentValue = $this->gjm_total->FormValue;
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
		$this->gjm_id->setDbValue($rs->fields('gjm_id'));
		$this->prj_id->setDbValue($rs->fields('prj_id'));
		if (array_key_exists('EV__prj_id', $rs->fields)) {
			$this->prj_id->VirtualValue = $rs->fields('EV__prj_id'); // Set up virtual field value
		} else {
			$this->prj_id->VirtualValue = ""; // Clear value
		}
		$this->per_id->setDbValue($rs->fields('per_id'));
		if (array_key_exists('EV__per_id', $rs->fields)) {
			$this->per_id->VirtualValue = $rs->fields('EV__per_id'); // Set up virtual field value
		} else {
			$this->per_id->VirtualValue = ""; // Clear value
		}
		$this->gjm_total->setDbValue($rs->fields('gjm_total'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->gjm_id->DbValue = $row['gjm_id'];
		$this->prj_id->DbValue = $row['prj_id'];
		$this->per_id->DbValue = $row['per_id'];
		$this->gjm_total->DbValue = $row['gjm_total'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("gjm_id")) <> "")
			$this->gjm_id->CurrentValue = $this->getKey("gjm_id"); // gjm_id
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
		// gjm_id
		// prj_id
		// per_id
		// gjm_total

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// gjm_id
		$this->gjm_id->ViewValue = $this->gjm_id->CurrentValue;
		$this->gjm_id->ViewCustomAttributes = "";

		// prj_id
		if ($this->prj_id->VirtualValue <> "") {
			$this->prj_id->ViewValue = $this->prj_id->VirtualValue;
		} else {
		if (strval($this->prj_id->CurrentValue) <> "") {
			$sFilterWrk = "`prj_id`" . ew_SearchString("=", $this->prj_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `prj_id`, `prj_nama` AS `DispFld`, `prj_lokasi` AS `Disp2Fld`, `prj_pekerjaan` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_project`";
		$sWhereWrk = "";
		$this->prj_id->LookupFilters = array("dx1" => '`prj_nama`', "dx2" => '`prj_lokasi`', "dx3" => '`prj_pekerjaan`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->prj_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->prj_id->ViewValue = $this->prj_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->prj_id->ViewValue = $this->prj_id->CurrentValue;
			}
		} else {
			$this->prj_id->ViewValue = NULL;
		}
		}
		$this->prj_id->ViewCustomAttributes = "";

		// per_id
		if ($this->per_id->VirtualValue <> "") {
			$this->per_id->ViewValue = $this->per_id->VirtualValue;
		} else {
		if (strval($this->per_id->CurrentValue) <> "") {
			$sFilterWrk = "`per_id`" . ew_SearchString("=", $this->per_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `per_id`, `per_mulai` AS `DispFld`, `per_selesai` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_periode`";
		$sWhereWrk = "";
		$this->per_id->LookupFilters = array("df1" => "7", "dx1" => ew_CastDateFieldForLike('`per_mulai`', 7, "DB"), "df2" => "7", "dx2" => ew_CastDateFieldForLike('`per_selesai`', 7, "DB"));
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->per_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_FormatDateTime($rswrk->fields('DispFld'), 7);
				$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 7);
				$this->per_id->ViewValue = $this->per_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->per_id->ViewValue = $this->per_id->CurrentValue;
			}
		} else {
			$this->per_id->ViewValue = NULL;
		}
		}
		$this->per_id->ViewCustomAttributes = "";

		// gjm_total
		$this->gjm_total->ViewValue = $this->gjm_total->CurrentValue;
		$this->gjm_total->ViewValue = ew_FormatNumber($this->gjm_total->ViewValue, 0, -2, -2, -1);
		$this->gjm_total->CellCssStyle .= "text-align: right;";
		$this->gjm_total->ViewCustomAttributes = "";

			// prj_id
			$this->prj_id->LinkCustomAttributes = "";
			$this->prj_id->HrefValue = "";
			$this->prj_id->TooltipValue = "";

			// per_id
			$this->per_id->LinkCustomAttributes = "";
			$this->per_id->HrefValue = "";
			$this->per_id->TooltipValue = "";

			// gjm_total
			$this->gjm_total->LinkCustomAttributes = "";
			$this->gjm_total->HrefValue = "";
			$this->gjm_total->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// prj_id
			$this->prj_id->EditCustomAttributes = "";
			if (trim(strval($this->prj_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`prj_id`" . ew_SearchString("=", $this->prj_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `prj_id`, `prj_nama` AS `DispFld`, `prj_lokasi` AS `Disp2Fld`, `prj_pekerjaan` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_project`";
			$sWhereWrk = "";
			$this->prj_id->LookupFilters = array("dx1" => '`prj_nama`', "dx2" => '`prj_lokasi`', "dx3" => '`prj_pekerjaan`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->prj_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->prj_id->ViewValue = $this->prj_id->DisplayValue($arwrk);
			} else {
				$this->prj_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->prj_id->EditValue = $arwrk;

			// per_id
			$this->per_id->EditCustomAttributes = "";
			if (trim(strval($this->per_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`per_id`" . ew_SearchString("=", $this->per_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `per_id`, `per_mulai` AS `DispFld`, `per_selesai` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t_periode`";
			$sWhereWrk = "";
			$this->per_id->LookupFilters = array("df1" => "7", "dx1" => ew_CastDateFieldForLike('`per_mulai`', 7, "DB"), "df2" => "7", "dx2" => ew_CastDateFieldForLike('`per_selesai`', 7, "DB"));
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->per_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode(ew_FormatDateTime($rswrk->fields('DispFld'), 7));
				$arwrk[2] = ew_HtmlEncode(ew_FormatDateTime($rswrk->fields('Disp2Fld'), 7));
				$this->per_id->ViewValue = $this->per_id->DisplayValue($arwrk);
			} else {
				$this->per_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = ew_FormatDateTime($arwrk[$rowcntwrk][1], 7);
				$arwrk[$rowcntwrk][2] = ew_FormatDateTime($arwrk[$rowcntwrk][2], 7);
			}
			$this->per_id->EditValue = $arwrk;

			// gjm_total
			$this->gjm_total->EditAttrs["class"] = "form-control";
			$this->gjm_total->EditCustomAttributes = "";
			$this->gjm_total->EditValue = ew_HtmlEncode($this->gjm_total->CurrentValue);
			$this->gjm_total->PlaceHolder = ew_RemoveHtml($this->gjm_total->FldCaption());

			// Add refer script
			// prj_id

			$this->prj_id->LinkCustomAttributes = "";
			$this->prj_id->HrefValue = "";

			// per_id
			$this->per_id->LinkCustomAttributes = "";
			$this->per_id->HrefValue = "";

			// gjm_total
			$this->gjm_total->LinkCustomAttributes = "";
			$this->gjm_total->HrefValue = "";
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
		if (!$this->prj_id->FldIsDetailKey && !is_null($this->prj_id->FormValue) && $this->prj_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->prj_id->FldCaption(), $this->prj_id->ReqErrMsg));
		}
		if (!$this->per_id->FldIsDetailKey && !is_null($this->per_id->FormValue) && $this->per_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->per_id->FldCaption(), $this->per_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->gjm_total->FormValue)) {
			ew_AddMessage($gsFormError, $this->gjm_total->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t_gaji_detail", $DetailTblVar) && $GLOBALS["t_gaji_detail"]->DetailAdd) {
			if (!isset($GLOBALS["t_gaji_detail_grid"])) $GLOBALS["t_gaji_detail_grid"] = new ct_gaji_detail_grid(); // get detail page object
			$GLOBALS["t_gaji_detail_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// prj_id
		$this->prj_id->SetDbValueDef($rsnew, $this->prj_id->CurrentValue, 0, FALSE);

		// per_id
		$this->per_id->SetDbValueDef($rsnew, $this->per_id->CurrentValue, 0, FALSE);

		// gjm_total
		$this->gjm_total->SetDbValueDef($rsnew, $this->gjm_total->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("t_gaji_detail", $DetailTblVar) && $GLOBALS["t_gaji_detail"]->DetailAdd) {
				$GLOBALS["t_gaji_detail"]->gjm_id->setSessionValue($this->gjm_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["t_gaji_detail_grid"])) $GLOBALS["t_gaji_detail_grid"] = new ct_gaji_detail_grid(); // Get detail page object
				$AddRow = $GLOBALS["t_gaji_detail_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["t_gaji_detail"]->gjm_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("t_gaji_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["t_gaji_detail_grid"]))
					$GLOBALS["t_gaji_detail_grid"] = new ct_gaji_detail_grid;
				if ($GLOBALS["t_gaji_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["t_gaji_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["t_gaji_detail_grid"]->CurrentMode = "add";
					$GLOBALS["t_gaji_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["t_gaji_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t_gaji_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["t_gaji_detail_grid"]->gjm_id->FldIsDetailKey = TRUE;
					$GLOBALS["t_gaji_detail_grid"]->gjm_id->CurrentValue = $this->gjm_id->CurrentValue;
					$GLOBALS["t_gaji_detail_grid"]->gjm_id->setSessionValue($GLOBALS["t_gaji_detail_grid"]->gjm_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_gaji_masterlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_prj_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `prj_id` AS `LinkFld`, `prj_nama` AS `DispFld`, `prj_lokasi` AS `Disp2Fld`, `prj_pekerjaan` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_project`";
			$sWhereWrk = "{filter}";
			$this->prj_id->LookupFilters = array("dx1" => '`prj_nama`', "dx2" => '`prj_lokasi`', "dx3" => '`prj_pekerjaan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`prj_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->prj_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_per_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `per_id` AS `LinkFld`, `per_mulai` AS `DispFld`, `per_selesai` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_periode`";
			$sWhereWrk = "{filter}";
			$this->per_id->LookupFilters = array("df1" => "7", "dx1" => ew_CastDateFieldForLike('`per_mulai`', 7, "DB"), "df2" => "7", "dx2" => ew_CastDateFieldForLike('`per_selesai`', 7, "DB"));
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`per_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->per_id, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t_gaji_master_add)) $t_gaji_master_add = new ct_gaji_master_add();

// Page init
$t_gaji_master_add->Page_Init();

// Page main
$t_gaji_master_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_gaji_master_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_gaji_masteradd = new ew_Form("ft_gaji_masteradd", "add");

// Validate form
ft_gaji_masteradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_prj_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_master->prj_id->FldCaption(), $t_gaji_master->prj_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_per_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_gaji_master->per_id->FldCaption(), $t_gaji_master->per_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gjm_total");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_gaji_master->gjm_total->FldErrMsg()) ?>");

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
ft_gaji_masteradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_gaji_masteradd.ValidateRequired = true;
<?php } else { ?>
ft_gaji_masteradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_gaji_masteradd.Lists["x_prj_id"] = {"LinkField":"x_prj_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_prj_nama","x_prj_lokasi","x_prj_pekerjaan",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_project"};
ft_gaji_masteradd.Lists["x_per_id"] = {"LinkField":"x_per_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_per_mulai","x_per_selesai","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_periode"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_gaji_master_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t_gaji_master_add->ShowPageHeader(); ?>
<?php
$t_gaji_master_add->ShowMessage();
?>
<form name="ft_gaji_masteradd" id="ft_gaji_masteradd" class="<?php echo $t_gaji_master_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_gaji_master_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_gaji_master_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_gaji_master">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_gaji_master_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_gaji_master->prj_id->Visible) { // prj_id ?>
	<div id="r_prj_id" class="form-group">
		<label id="elh_t_gaji_master_prj_id" for="x_prj_id" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_master->prj_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_master->prj_id->CellAttributes() ?>>
<span id="el_t_gaji_master_prj_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_prj_id"><?php echo (strval($t_gaji_master->prj_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_master->prj_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_master->prj_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_prj_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_master" data-field="x_prj_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_master->prj_id->DisplayValueSeparatorAttribute() ?>" name="x_prj_id" id="x_prj_id" value="<?php echo $t_gaji_master->prj_id->CurrentValue ?>"<?php echo $t_gaji_master->prj_id->EditAttributes() ?>>
<input type="hidden" name="s_x_prj_id" id="s_x_prj_id" value="<?php echo $t_gaji_master->prj_id->LookupFilterQuery() ?>">
</span>
<?php echo $t_gaji_master->prj_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_master->per_id->Visible) { // per_id ?>
	<div id="r_per_id" class="form-group">
		<label id="elh_t_gaji_master_per_id" for="x_per_id" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_master->per_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_master->per_id->CellAttributes() ?>>
<span id="el_t_gaji_master_per_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_per_id"><?php echo (strval($t_gaji_master->per_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_master->per_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_master->per_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_per_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_master" data-field="x_per_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_master->per_id->DisplayValueSeparatorAttribute() ?>" name="x_per_id" id="x_per_id" value="<?php echo $t_gaji_master->per_id->CurrentValue ?>"<?php echo $t_gaji_master->per_id->EditAttributes() ?>>
<input type="hidden" name="s_x_per_id" id="s_x_per_id" value="<?php echo $t_gaji_master->per_id->LookupFilterQuery() ?>">
</span>
<?php echo $t_gaji_master->per_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_gaji_master->gjm_total->Visible) { // gjm_total ?>
	<div id="r_gjm_total" class="form-group">
		<label id="elh_t_gaji_master_gjm_total" for="x_gjm_total" class="col-sm-2 control-label ewLabel"><?php echo $t_gaji_master->gjm_total->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_gaji_master->gjm_total->CellAttributes() ?>>
<span id="el_t_gaji_master_gjm_total">
<input type="text" data-table="t_gaji_master" data-field="x_gjm_total" name="x_gjm_total" id="x_gjm_total" size="30" placeholder="<?php echo ew_HtmlEncode($t_gaji_master->gjm_total->getPlaceHolder()) ?>" value="<?php echo $t_gaji_master->gjm_total->EditValue ?>"<?php echo $t_gaji_master->gjm_total->EditAttributes() ?>>
</span>
<?php echo $t_gaji_master->gjm_total->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("t_gaji_detail", explode(",", $t_gaji_master->getCurrentDetailTable())) && $t_gaji_detail->DetailAdd) {
?>
<?php if ($t_gaji_master->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("t_gaji_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "t_gaji_detailgrid.php" ?>
<?php } ?>
<?php if (!$t_gaji_master_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_gaji_master_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_gaji_masteradd.Init();
</script>
<?php
$t_gaji_master_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_gaji_master_add->Page_Terminate();
?>
