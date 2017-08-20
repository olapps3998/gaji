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

$t_gaji_detail_view = NULL; // Initialize page object first

class ct_gaji_detail_view extends ct_gaji_detail {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{CCC661CC-E251-4AC9-9C43-38E94C9A89E5}";

	// Table name
	var $TableName = 't_gaji_detail';

	// Page object name
	var $PageObjName = 't_gaji_detail_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["gjd_id"] <> "") {
			$this->RecKey["gjd_id"] = $_GET["gjd_id"];
			$KeyUrl .= "&amp;gjd_id=" . urlencode($this->RecKey["gjd_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (t_gaji_master)
		if (!isset($GLOBALS['t_gaji_master'])) $GLOBALS['t_gaji_master'] = new ct_gaji_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_gaji_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["gjd_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["gjd_id"]);
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up master/detail parameters
		$this->SetUpMasterParms();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["gjd_id"] <> "") {
				$this->gjd_id->setQueryStringValue($_GET["gjd_id"]);
				$this->RecKey["gjd_id"] = $this->gjd_id->QueryStringValue;
			} elseif (@$_POST["gjd_id"] <> "") {
				$this->gjd_id->setFormValue($_POST["gjd_id"]);
				$this->RecKey["gjd_id"] = $this->gjd_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("t_gaji_detaillist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->gjd_id->CurrentValue) == strval($this->Recordset->fields('gjd_id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t_gaji_detaillist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "t_gaji_detaillist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "");

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "");

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "");

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_t_gaji_detail\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t_gaji_detail',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft_gaji_detailview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
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
			$this->setSessionWhere($this->GetDetailFilter());

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
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_gaji_detail_view)) $t_gaji_detail_view = new ct_gaji_detail_view();

// Page init
$t_gaji_detail_view->Page_Init();

// Page main
$t_gaji_detail_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_gaji_detail_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft_gaji_detailview = new ew_Form("ft_gaji_detailview", "view");

// Form_CustomValidate event
ft_gaji_detailview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_gaji_detailview.ValidateRequired = true;
<?php } else { ?>
ft_gaji_detailview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_gaji_detailview.Lists["x_peg_id"] = {"LinkField":"x_peg_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_peg_nama","x_peg_jabatan","x_peg_upah",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_pegawai"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$t_gaji_detail_view->IsModal) { ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $t_gaji_detail_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t_gaji_detail_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$t_gaji_detail_view->IsModal) { ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t_gaji_detail_view->ShowPageHeader(); ?>
<?php
$t_gaji_detail_view->ShowMessage();
?>
<?php if (!$t_gaji_detail_view->IsModal) { ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_gaji_detail_view->Pager)) $t_gaji_detail_view->Pager = new cPrevNextPager($t_gaji_detail_view->StartRec, $t_gaji_detail_view->DisplayRecs, $t_gaji_detail_view->TotalRecs) ?>
<?php if ($t_gaji_detail_view->Pager->RecordCount > 0 && $t_gaji_detail_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_gaji_detail_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_gaji_detail_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_gaji_detail_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_gaji_detail_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_gaji_detail_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_gaji_detail_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="ft_gaji_detailview" id="ft_gaji_detailview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_gaji_detail_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_gaji_detail_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_gaji_detail">
<?php if ($t_gaji_detail_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
	<tr id="r_peg_id">
		<td><span id="elh_t_gaji_detail_peg_id"><?php echo $t_gaji_detail->peg_id->FldCaption() ?></span></td>
		<td data-name="peg_id"<?php echo $t_gaji_detail->peg_id->CellAttributes() ?>>
<span id="el_t_gaji_detail_peg_id">
<span<?php echo $t_gaji_detail->peg_id->ViewAttributes() ?>>
<?php echo $t_gaji_detail->peg_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
	<tr id="r_b_mn">
		<td><span id="elh_t_gaji_detail_b_mn"><?php echo $t_gaji_detail->b_mn->FldCaption() ?></span></td>
		<td data-name="b_mn"<?php echo $t_gaji_detail->b_mn->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_mn">
<span<?php echo $t_gaji_detail->b_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_mn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
	<tr id="r_b_sn">
		<td><span id="elh_t_gaji_detail_b_sn"><?php echo $t_gaji_detail->b_sn->FldCaption() ?></span></td>
		<td data-name="b_sn"<?php echo $t_gaji_detail->b_sn->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_sn">
<span<?php echo $t_gaji_detail->b_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
	<tr id="r_b_sl">
		<td><span id="elh_t_gaji_detail_b_sl"><?php echo $t_gaji_detail->b_sl->FldCaption() ?></span></td>
		<td data-name="b_sl"<?php echo $t_gaji_detail->b_sl->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_sl">
<span<?php echo $t_gaji_detail->b_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sl->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
	<tr id="r_b_rb">
		<td><span id="elh_t_gaji_detail_b_rb"><?php echo $t_gaji_detail->b_rb->FldCaption() ?></span></td>
		<td data-name="b_rb"<?php echo $t_gaji_detail->b_rb->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_rb">
<span<?php echo $t_gaji_detail->b_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_rb->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
	<tr id="r_b_km">
		<td><span id="elh_t_gaji_detail_b_km"><?php echo $t_gaji_detail->b_km->FldCaption() ?></span></td>
		<td data-name="b_km"<?php echo $t_gaji_detail->b_km->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_km">
<span<?php echo $t_gaji_detail->b_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_km->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
	<tr id="r_b_jm">
		<td><span id="elh_t_gaji_detail_b_jm"><?php echo $t_gaji_detail->b_jm->FldCaption() ?></span></td>
		<td data-name="b_jm"<?php echo $t_gaji_detail->b_jm->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_jm">
<span<?php echo $t_gaji_detail->b_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_jm->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
	<tr id="r_b_sb">
		<td><span id="elh_t_gaji_detail_b_sb"><?php echo $t_gaji_detail->b_sb->FldCaption() ?></span></td>
		<td data-name="b_sb"<?php echo $t_gaji_detail->b_sb->CellAttributes() ?>>
<span id="el_t_gaji_detail_b_sb">
<span<?php echo $t_gaji_detail->b_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sb->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
	<tr id="r_l_mn">
		<td><span id="elh_t_gaji_detail_l_mn"><?php echo $t_gaji_detail->l_mn->FldCaption() ?></span></td>
		<td data-name="l_mn"<?php echo $t_gaji_detail->l_mn->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_mn">
<span<?php echo $t_gaji_detail->l_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_mn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
	<tr id="r_l_sn">
		<td><span id="elh_t_gaji_detail_l_sn"><?php echo $t_gaji_detail->l_sn->FldCaption() ?></span></td>
		<td data-name="l_sn"<?php echo $t_gaji_detail->l_sn->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_sn">
<span<?php echo $t_gaji_detail->l_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
	<tr id="r_l_sl">
		<td><span id="elh_t_gaji_detail_l_sl"><?php echo $t_gaji_detail->l_sl->FldCaption() ?></span></td>
		<td data-name="l_sl"<?php echo $t_gaji_detail->l_sl->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_sl">
<span<?php echo $t_gaji_detail->l_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sl->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
	<tr id="r_l_rb">
		<td><span id="elh_t_gaji_detail_l_rb"><?php echo $t_gaji_detail->l_rb->FldCaption() ?></span></td>
		<td data-name="l_rb"<?php echo $t_gaji_detail->l_rb->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_rb">
<span<?php echo $t_gaji_detail->l_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_rb->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
	<tr id="r_l_km">
		<td><span id="elh_t_gaji_detail_l_km"><?php echo $t_gaji_detail->l_km->FldCaption() ?></span></td>
		<td data-name="l_km"<?php echo $t_gaji_detail->l_km->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_km">
<span<?php echo $t_gaji_detail->l_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_km->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
	<tr id="r_l_jm">
		<td><span id="elh_t_gaji_detail_l_jm"><?php echo $t_gaji_detail->l_jm->FldCaption() ?></span></td>
		<td data-name="l_jm"<?php echo $t_gaji_detail->l_jm->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_jm">
<span<?php echo $t_gaji_detail->l_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_jm->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
	<tr id="r_l_sb">
		<td><span id="elh_t_gaji_detail_l_sb"><?php echo $t_gaji_detail->l_sb->FldCaption() ?></span></td>
		<td data-name="l_sb"<?php echo $t_gaji_detail->l_sb->CellAttributes() ?>>
<span id="el_t_gaji_detail_l_sb">
<span<?php echo $t_gaji_detail->l_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sb->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$t_gaji_detail_view->IsModal) { ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<?php if (!isset($t_gaji_detail_view->Pager)) $t_gaji_detail_view->Pager = new cPrevNextPager($t_gaji_detail_view->StartRec, $t_gaji_detail_view->DisplayRecs, $t_gaji_detail_view->TotalRecs) ?>
<?php if ($t_gaji_detail_view->Pager->RecordCount > 0 && $t_gaji_detail_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_gaji_detail_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_gaji_detail_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_gaji_detail_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_gaji_detail_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_gaji_detail_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_gaji_detail_view->PageUrl() ?>start=<?php echo $t_gaji_detail_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_gaji_detail_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">
ft_gaji_detailview.Init();
</script>
<?php } ?>
<?php
$t_gaji_detail_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t_gaji_detail_view->Page_Terminate();
?>
