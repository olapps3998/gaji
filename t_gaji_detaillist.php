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

$t_gaji_detail_list = NULL; // Initialize page object first

class ct_gaji_detail_list extends ct_gaji_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{CCC661CC-E251-4AC9-9C43-38E94C9A89E5}";

	// Table name
	var $TableName = 't_gaji_detail';

	// Page object name
	var $PageObjName = 't_gaji_detail_list';

	// Grid form hidden field names
	var $FormName = 'ft_gaji_detaillist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t_gaji_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t_gaji_detaildelete.php";
		$this->MultiUpdateUrl = "t_gaji_detailupdate.php";

		// Table object (t_gaji_master)
		if (!isset($GLOBALS['t_gaji_master'])) $GLOBALS['t_gaji_master'] = new ct_gaji_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_gaji_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft_gaji_detaillistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();

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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t_gaji_master") {
			global $t_gaji_master;
			$rsmaster = $t_gaji_master->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("t_gaji_masterlist.php"); // Return to master page
			} else {
				$t_gaji_master->LoadListRowValues($rsmaster);
				$t_gaji_master->RowType = EW_ROWTYPE_MASTER; // Master row
				$t_gaji_master->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("gjd_id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		$bInlineEdit = TRUE;
		if (@$_GET["gjd_id"] <> "") {
			$this->gjd_id->setQueryStringValue($_GET["gjd_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("gjd_id", $this->gjd_id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("gjd_id")) <> strval($this->gjd_id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if ($this->CurrentAction == "copy") {
			if (@$_GET["gjd_id"] <> "") {
				$this->gjd_id->setQueryStringValue($_GET["gjd_id"]);
				$this->setKey("gjd_id", $this->gjd_id->CurrentValue); // Set up key
			} else {
				$this->setKey("gjd_id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->gjd_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->gjd_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->gjd_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_peg_id") && $objForm->HasValue("o_peg_id") && $this->peg_id->CurrentValue <> $this->peg_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_mn") && $objForm->HasValue("o_b_mn") && $this->b_mn->CurrentValue <> $this->b_mn->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_sn") && $objForm->HasValue("o_b_sn") && $this->b_sn->CurrentValue <> $this->b_sn->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_sl") && $objForm->HasValue("o_b_sl") && $this->b_sl->CurrentValue <> $this->b_sl->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_rb") && $objForm->HasValue("o_b_rb") && $this->b_rb->CurrentValue <> $this->b_rb->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_km") && $objForm->HasValue("o_b_km") && $this->b_km->CurrentValue <> $this->b_km->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_jm") && $objForm->HasValue("o_b_jm") && $this->b_jm->CurrentValue <> $this->b_jm->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_b_sb") && $objForm->HasValue("o_b_sb") && $this->b_sb->CurrentValue <> $this->b_sb->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_mn") && $objForm->HasValue("o_l_mn") && $this->l_mn->CurrentValue <> $this->l_mn->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_sn") && $objForm->HasValue("o_l_sn") && $this->l_sn->CurrentValue <> $this->l_sn->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_sl") && $objForm->HasValue("o_l_sl") && $this->l_sl->CurrentValue <> $this->l_sl->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_rb") && $objForm->HasValue("o_l_rb") && $this->l_rb->CurrentValue <> $this->l_rb->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_km") && $objForm->HasValue("o_l_km") && $this->l_km->CurrentValue <> $this->l_km->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_jm") && $objForm->HasValue("o_l_jm") && $this->l_jm->CurrentValue <> $this->l_jm->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_l_sb") && $objForm->HasValue("o_l_sb") && $this->l_sb->CurrentValue <> $this->l_sb->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->peg_id, $bCtrl); // peg_id
			$this->UpdateSort($this->b_mn, $bCtrl); // b_mn
			$this->UpdateSort($this->b_sn, $bCtrl); // b_sn
			$this->UpdateSort($this->b_sl, $bCtrl); // b_sl
			$this->UpdateSort($this->b_rb, $bCtrl); // b_rb
			$this->UpdateSort($this->b_km, $bCtrl); // b_km
			$this->UpdateSort($this->b_jm, $bCtrl); // b_jm
			$this->UpdateSort($this->b_sb, $bCtrl); // b_sb
			$this->UpdateSort($this->l_mn, $bCtrl); // l_mn
			$this->UpdateSort($this->l_sn, $bCtrl); // l_sn
			$this->UpdateSort($this->l_sl, $bCtrl); // l_sl
			$this->UpdateSort($this->l_rb, $bCtrl); // l_rb
			$this->UpdateSort($this->l_km, $bCtrl); // l_km
			$this->UpdateSort($this->l_jm, $bCtrl); // l_jm
			$this->UpdateSort($this->l_sb, $bCtrl); // l_sb
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->gjm_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->peg_id->setSort("");
				$this->b_mn->setSort("");
				$this->b_sn->setSort("");
				$this->b_sl->setSort("");
				$this->b_rb->setSort("");
				$this->b_km->setSort("");
				$this->b_jm->setSort("");
				$this->b_sb->setSort("");
				$this->l_mn->setSort("");
				$this->l_sn->setSort("");
				$this->l_sl->setSort("");
				$this->l_rb->setSort("");
				$this->l_km->setSort("");
				$this->l_jm->setSort("");
				$this->l_sb->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->gjd_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->gjd_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->gjd_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "");
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "");

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "");
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ft_gaji_detaillist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = (TRUE);

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft_gaji_detaillistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft_gaji_detaillistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft_gaji_detaillist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = TRUE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = TRUE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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
		$this->peg_id->setOldValue($objForm->GetValue("o_peg_id"));
		if (!$this->b_mn->FldIsDetailKey) {
			$this->b_mn->setFormValue($objForm->GetValue("x_b_mn"));
		}
		$this->b_mn->setOldValue($objForm->GetValue("o_b_mn"));
		if (!$this->b_sn->FldIsDetailKey) {
			$this->b_sn->setFormValue($objForm->GetValue("x_b_sn"));
		}
		$this->b_sn->setOldValue($objForm->GetValue("o_b_sn"));
		if (!$this->b_sl->FldIsDetailKey) {
			$this->b_sl->setFormValue($objForm->GetValue("x_b_sl"));
		}
		$this->b_sl->setOldValue($objForm->GetValue("o_b_sl"));
		if (!$this->b_rb->FldIsDetailKey) {
			$this->b_rb->setFormValue($objForm->GetValue("x_b_rb"));
		}
		$this->b_rb->setOldValue($objForm->GetValue("o_b_rb"));
		if (!$this->b_km->FldIsDetailKey) {
			$this->b_km->setFormValue($objForm->GetValue("x_b_km"));
		}
		$this->b_km->setOldValue($objForm->GetValue("o_b_km"));
		if (!$this->b_jm->FldIsDetailKey) {
			$this->b_jm->setFormValue($objForm->GetValue("x_b_jm"));
		}
		$this->b_jm->setOldValue($objForm->GetValue("o_b_jm"));
		if (!$this->b_sb->FldIsDetailKey) {
			$this->b_sb->setFormValue($objForm->GetValue("x_b_sb"));
		}
		$this->b_sb->setOldValue($objForm->GetValue("o_b_sb"));
		if (!$this->l_mn->FldIsDetailKey) {
			$this->l_mn->setFormValue($objForm->GetValue("x_l_mn"));
		}
		$this->l_mn->setOldValue($objForm->GetValue("o_l_mn"));
		if (!$this->l_sn->FldIsDetailKey) {
			$this->l_sn->setFormValue($objForm->GetValue("x_l_sn"));
		}
		$this->l_sn->setOldValue($objForm->GetValue("o_l_sn"));
		if (!$this->l_sl->FldIsDetailKey) {
			$this->l_sl->setFormValue($objForm->GetValue("x_l_sl"));
		}
		$this->l_sl->setOldValue($objForm->GetValue("o_l_sl"));
		if (!$this->l_rb->FldIsDetailKey) {
			$this->l_rb->setFormValue($objForm->GetValue("x_l_rb"));
		}
		$this->l_rb->setOldValue($objForm->GetValue("o_l_rb"));
		if (!$this->l_km->FldIsDetailKey) {
			$this->l_km->setFormValue($objForm->GetValue("x_l_km"));
		}
		$this->l_km->setOldValue($objForm->GetValue("o_l_km"));
		if (!$this->l_jm->FldIsDetailKey) {
			$this->l_jm->setFormValue($objForm->GetValue("x_l_jm"));
		}
		$this->l_jm->setOldValue($objForm->GetValue("o_l_jm"));
		if (!$this->l_sb->FldIsDetailKey) {
			$this->l_sb->setFormValue($objForm->GetValue("x_l_sb"));
		}
		$this->l_sb->setOldValue($objForm->GetValue("o_l_sb"));
		if (!$this->gjd_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->gjd_id->setFormValue($objForm->GetValue("x_gjd_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->gjd_id->CurrentValue = $this->gjd_id->FormValue;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Edit refer script
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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// peg_id
			$this->peg_id->SetDbValueDef($rsnew, $this->peg_id->CurrentValue, 0, $this->peg_id->ReadOnly);

			// b_mn
			$this->b_mn->SetDbValueDef($rsnew, $this->b_mn->CurrentValue, 0, $this->b_mn->ReadOnly);

			// b_sn
			$this->b_sn->SetDbValueDef($rsnew, $this->b_sn->CurrentValue, 0, $this->b_sn->ReadOnly);

			// b_sl
			$this->b_sl->SetDbValueDef($rsnew, $this->b_sl->CurrentValue, 0, $this->b_sl->ReadOnly);

			// b_rb
			$this->b_rb->SetDbValueDef($rsnew, $this->b_rb->CurrentValue, 0, $this->b_rb->ReadOnly);

			// b_km
			$this->b_km->SetDbValueDef($rsnew, $this->b_km->CurrentValue, 0, $this->b_km->ReadOnly);

			// b_jm
			$this->b_jm->SetDbValueDef($rsnew, $this->b_jm->CurrentValue, 0, $this->b_jm->ReadOnly);

			// b_sb
			$this->b_sb->SetDbValueDef($rsnew, $this->b_sb->CurrentValue, 0, $this->b_sb->ReadOnly);

			// l_mn
			$this->l_mn->SetDbValueDef($rsnew, $this->l_mn->CurrentValue, 0, $this->l_mn->ReadOnly);

			// l_sn
			$this->l_sn->SetDbValueDef($rsnew, $this->l_sn->CurrentValue, 0, $this->l_sn->ReadOnly);

			// l_sl
			$this->l_sl->SetDbValueDef($rsnew, $this->l_sl->CurrentValue, 0, $this->l_sl->ReadOnly);

			// l_rb
			$this->l_rb->SetDbValueDef($rsnew, $this->l_rb->CurrentValue, 0, $this->l_rb->ReadOnly);

			// l_km
			$this->l_km->SetDbValueDef($rsnew, $this->l_km->CurrentValue, 0, $this->l_km->ReadOnly);

			// l_jm
			$this->l_jm->SetDbValueDef($rsnew, $this->l_jm->CurrentValue, 0, $this->l_jm->ReadOnly);

			// l_sb
			$this->l_sb->SetDbValueDef($rsnew, $this->l_sb->CurrentValue, 0, $this->l_sb->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_t_gaji_detail\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t_gaji_detail',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft_gaji_detaillist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

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

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t_gaji_master") {
			global $t_gaji_master;
			if (!isset($t_gaji_master)) $t_gaji_master = new ct_gaji_master;
			$rsmaster = $t_gaji_master->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$t_gaji_master;
					$t_gaji_master->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
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

		// Build QueryString for search
		// Build QueryString for pager

		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($t_gaji_detail_list)) $t_gaji_detail_list = new ct_gaji_detail_list();

// Page init
$t_gaji_detail_list->Page_Init();

// Page main
$t_gaji_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_gaji_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft_gaji_detaillist = new ew_Form("ft_gaji_detaillist", "list");
ft_gaji_detaillist.FormKeyCountName = '<?php echo $t_gaji_detail_list->FormKeyCountName ?>';

// Validate form
ft_gaji_detaillist.Validate = function() {
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
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft_gaji_detaillist.EmptyRow = function(infix) {
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
ft_gaji_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_gaji_detaillist.ValidateRequired = true;
<?php } else { ?>
ft_gaji_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_gaji_detaillist.Lists["x_peg_id"] = {"LinkField":"x_peg_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_peg_nama","x_peg_jabatan","x_peg_upah",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_pegawai"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t_gaji_detail->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($t_gaji_detail_list->TotalRecs > 0 && $t_gaji_detail_list->ExportOptions->Visible()) { ?>
<?php $t_gaji_detail_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($t_gaji_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $t_gaji_detail->Export == "print")) { ?>
<?php
if ($t_gaji_detail_list->DbMasterFilter <> "" && $t_gaji_detail->getCurrentMasterTable() == "t_gaji_master") {
	if ($t_gaji_detail_list->MasterRecordExists) {
?>
<?php include_once "t_gaji_mastermaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($t_gaji_detail->CurrentAction == "gridadd") {
	$t_gaji_detail->CurrentFilter = "0=1";
	$t_gaji_detail_list->StartRec = 1;
	$t_gaji_detail_list->DisplayRecs = $t_gaji_detail->GridAddRowCount;
	$t_gaji_detail_list->TotalRecs = $t_gaji_detail_list->DisplayRecs;
	$t_gaji_detail_list->StopRec = $t_gaji_detail_list->DisplayRecs;
} else {
	$bSelectLimit = $t_gaji_detail_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_gaji_detail_list->TotalRecs <= 0)
			$t_gaji_detail_list->TotalRecs = $t_gaji_detail->SelectRecordCount();
	} else {
		if (!$t_gaji_detail_list->Recordset && ($t_gaji_detail_list->Recordset = $t_gaji_detail_list->LoadRecordset()))
			$t_gaji_detail_list->TotalRecs = $t_gaji_detail_list->Recordset->RecordCount();
	}
	$t_gaji_detail_list->StartRec = 1;
	if ($t_gaji_detail_list->DisplayRecs <= 0 || ($t_gaji_detail->Export <> "" && $t_gaji_detail->ExportAll)) // Display all records
		$t_gaji_detail_list->DisplayRecs = $t_gaji_detail_list->TotalRecs;
	if (!($t_gaji_detail->Export <> "" && $t_gaji_detail->ExportAll))
		$t_gaji_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t_gaji_detail_list->Recordset = $t_gaji_detail_list->LoadRecordset($t_gaji_detail_list->StartRec-1, $t_gaji_detail_list->DisplayRecs);

	// Set no record found message
	if ($t_gaji_detail->CurrentAction == "" && $t_gaji_detail_list->TotalRecs == 0) {
		if ($t_gaji_detail_list->SearchWhere == "0=101")
			$t_gaji_detail_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_gaji_detail_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_gaji_detail_list->RenderOtherOptions();
?>
<?php $t_gaji_detail_list->ShowPageHeader(); ?>
<?php
$t_gaji_detail_list->ShowMessage();
?>
<?php if ($t_gaji_detail_list->TotalRecs > 0 || $t_gaji_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_gaji_detail">
<?php if ($t_gaji_detail->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($t_gaji_detail->CurrentAction <> "gridadd" && $t_gaji_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_gaji_detail_list->Pager)) $t_gaji_detail_list->Pager = new cPrevNextPager($t_gaji_detail_list->StartRec, $t_gaji_detail_list->DisplayRecs, $t_gaji_detail_list->TotalRecs) ?>
<?php if ($t_gaji_detail_list->Pager->RecordCount > 0 && $t_gaji_detail_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_gaji_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_gaji_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_gaji_detail_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_gaji_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_gaji_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t_gaji_detail_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t_gaji_detail_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t_gaji_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t_gaji_detail_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t_gaji_detail_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t_gaji_detail_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t_gaji_detail_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t_gaji_detail_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t_gaji_detail->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_gaji_detail_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ft_gaji_detaillist" id="ft_gaji_detaillist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_gaji_detail_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_gaji_detail_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_gaji_detail">
<?php if ($t_gaji_detail->getCurrentMasterTable() == "t_gaji_master" && $t_gaji_detail->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_gaji_master">
<input type="hidden" name="fk_gjm_id" value="<?php echo $t_gaji_detail->gjm_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_t_gaji_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t_gaji_detail_list->TotalRecs > 0 || $t_gaji_detail->CurrentAction == "add" || $t_gaji_detail->CurrentAction == "copy" || $t_gaji_detail->CurrentAction == "gridedit") { ?>
<table id="tbl_t_gaji_detaillist" class="table ewTable">
<?php echo $t_gaji_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_gaji_detail_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_gaji_detail_list->RenderListOptions();

// Render list options (header, left)
$t_gaji_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->peg_id) == "") { ?>
		<th data-name="peg_id"><div id="elh_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->peg_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="peg_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->peg_id) ?>',2);"><div id="elh_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->peg_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->peg_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->peg_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_mn) == "") { ?>
		<th data-name="b_mn"><div id="elh_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_mn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_mn"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_mn) ?>',2);"><div id="elh_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_mn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_mn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_mn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_sn) == "") { ?>
		<th data-name="b_sn"><div id="elh_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_sn"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_sn) ?>',2);"><div id="elh_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_sn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_sn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_sl) == "") { ?>
		<th data-name="b_sl"><div id="elh_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_sl"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_sl) ?>',2);"><div id="elh_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_sl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_sl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_rb) == "") { ?>
		<th data-name="b_rb"><div id="elh_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_rb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_rb"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_rb) ?>',2);"><div id="elh_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_rb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_rb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_rb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_km) == "") { ?>
		<th data-name="b_km"><div id="elh_t_gaji_detail_b_km" class="t_gaji_detail_b_km"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_km->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_km"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_km) ?>',2);"><div id="elh_t_gaji_detail_b_km" class="t_gaji_detail_b_km">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_km->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_km->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_km->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_jm) == "") { ?>
		<th data-name="b_jm"><div id="elh_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_jm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_jm"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_jm) ?>',2);"><div id="elh_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_jm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_jm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_jm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->b_sb) == "") { ?>
		<th data-name="b_sb"><div id="elh_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_sb"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->b_sb) ?>',2);"><div id="elh_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->b_sb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->b_sb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->b_sb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_mn) == "") { ?>
		<th data-name="l_mn"><div id="elh_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_mn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_mn"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_mn) ?>',2);"><div id="elh_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_mn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_mn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_mn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_sn) == "") { ?>
		<th data-name="l_sn"><div id="elh_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_sn"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_sn) ?>',2);"><div id="elh_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_sn->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_sn->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_sl) == "") { ?>
		<th data-name="l_sl"><div id="elh_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_sl"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_sl) ?>',2);"><div id="elh_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_sl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_sl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_rb) == "") { ?>
		<th data-name="l_rb"><div id="elh_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_rb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_rb"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_rb) ?>',2);"><div id="elh_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_rb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_rb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_rb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_km) == "") { ?>
		<th data-name="l_km"><div id="elh_t_gaji_detail_l_km" class="t_gaji_detail_l_km"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_km->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_km"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_km) ?>',2);"><div id="elh_t_gaji_detail_l_km" class="t_gaji_detail_l_km">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_km->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_km->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_km->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_jm) == "") { ?>
		<th data-name="l_jm"><div id="elh_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_jm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_jm"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_jm) ?>',2);"><div id="elh_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_jm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_jm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_jm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
	<?php if ($t_gaji_detail->SortUrl($t_gaji_detail->l_sb) == "") { ?>
		<th data-name="l_sb"><div id="elh_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb"><div class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sb->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="l_sb"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_gaji_detail->SortUrl($t_gaji_detail->l_sb) ?>',2);"><div id="elh_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_gaji_detail->l_sb->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_gaji_detail->l_sb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t_gaji_detail->l_sb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_gaji_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t_gaji_detail->CurrentAction == "add" || $t_gaji_detail->CurrentAction == "copy") {
		$t_gaji_detail_list->RowIndex = 0;
		$t_gaji_detail_list->KeyCount = $t_gaji_detail_list->RowIndex;
		if ($t_gaji_detail->CurrentAction == "copy" && !$t_gaji_detail_list->LoadRow())
				$t_gaji_detail->CurrentAction = "add";
		if ($t_gaji_detail->CurrentAction == "add")
			$t_gaji_detail_list->LoadDefaultValues();
		if ($t_gaji_detail->EventCancelled) // Insert failed
			$t_gaji_detail_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t_gaji_detail->ResetAttrs();
		$t_gaji_detail->RowAttrs = array_merge($t_gaji_detail->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t_gaji_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t_gaji_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_gaji_detail_list->RenderRow();

		// Render list options
		$t_gaji_detail_list->RenderListOptions();
		$t_gaji_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $t_gaji_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_gaji_detail_list->ListOptions->Render("body", "left", $t_gaji_detail_list->RowCnt);
?>
	<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<td data-name="peg_id">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<td data-name="b_mn">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<td data-name="b_sn">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<td data-name="b_sl">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<td data-name="b_rb">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<td data-name="b_km">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<td data-name="b_jm">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<td data-name="b_sb">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<td data-name="l_mn">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<td data-name="l_sn">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<td data-name="l_sl">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<td data-name="l_rb">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<td data-name="l_km">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<td data-name="l_jm">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<td data-name="l_sb">
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_gaji_detail_list->ListOptions->Render("body", "right", $t_gaji_detail_list->RowCnt);
?>
<script type="text/javascript">
ft_gaji_detaillist.UpdateOpts(<?php echo $t_gaji_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t_gaji_detail->ExportAll && $t_gaji_detail->Export <> "") {
	$t_gaji_detail_list->StopRec = $t_gaji_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t_gaji_detail_list->TotalRecs > $t_gaji_detail_list->StartRec + $t_gaji_detail_list->DisplayRecs - 1)
		$t_gaji_detail_list->StopRec = $t_gaji_detail_list->StartRec + $t_gaji_detail_list->DisplayRecs - 1;
	else
		$t_gaji_detail_list->StopRec = $t_gaji_detail_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_gaji_detail_list->FormKeyCountName) && ($t_gaji_detail->CurrentAction == "gridadd" || $t_gaji_detail->CurrentAction == "gridedit" || $t_gaji_detail->CurrentAction == "F")) {
		$t_gaji_detail_list->KeyCount = $objForm->GetValue($t_gaji_detail_list->FormKeyCountName);
		$t_gaji_detail_list->StopRec = $t_gaji_detail_list->StartRec + $t_gaji_detail_list->KeyCount - 1;
	}
}
$t_gaji_detail_list->RecCnt = $t_gaji_detail_list->StartRec - 1;
if ($t_gaji_detail_list->Recordset && !$t_gaji_detail_list->Recordset->EOF) {
	$t_gaji_detail_list->Recordset->MoveFirst();
	$bSelectLimit = $t_gaji_detail_list->UseSelectLimit;
	if (!$bSelectLimit && $t_gaji_detail_list->StartRec > 1)
		$t_gaji_detail_list->Recordset->Move($t_gaji_detail_list->StartRec - 1);
} elseif (!$t_gaji_detail->AllowAddDeleteRow && $t_gaji_detail_list->StopRec == 0) {
	$t_gaji_detail_list->StopRec = $t_gaji_detail->GridAddRowCount;
}

// Initialize aggregate
$t_gaji_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_gaji_detail->ResetAttrs();
$t_gaji_detail_list->RenderRow();
$t_gaji_detail_list->EditRowCnt = 0;
if ($t_gaji_detail->CurrentAction == "edit")
	$t_gaji_detail_list->RowIndex = 1;
if ($t_gaji_detail->CurrentAction == "gridadd")
	$t_gaji_detail_list->RowIndex = 0;
if ($t_gaji_detail->CurrentAction == "gridedit")
	$t_gaji_detail_list->RowIndex = 0;
while ($t_gaji_detail_list->RecCnt < $t_gaji_detail_list->StopRec) {
	$t_gaji_detail_list->RecCnt++;
	if (intval($t_gaji_detail_list->RecCnt) >= intval($t_gaji_detail_list->StartRec)) {
		$t_gaji_detail_list->RowCnt++;
		if ($t_gaji_detail->CurrentAction == "gridadd" || $t_gaji_detail->CurrentAction == "gridedit" || $t_gaji_detail->CurrentAction == "F") {
			$t_gaji_detail_list->RowIndex++;
			$objForm->Index = $t_gaji_detail_list->RowIndex;
			if ($objForm->HasValue($t_gaji_detail_list->FormActionName))
				$t_gaji_detail_list->RowAction = strval($objForm->GetValue($t_gaji_detail_list->FormActionName));
			elseif ($t_gaji_detail->CurrentAction == "gridadd")
				$t_gaji_detail_list->RowAction = "insert";
			else
				$t_gaji_detail_list->RowAction = "";
		}

		// Set up key count
		$t_gaji_detail_list->KeyCount = $t_gaji_detail_list->RowIndex;

		// Init row class and style
		$t_gaji_detail->ResetAttrs();
		$t_gaji_detail->CssClass = "";
		if ($t_gaji_detail->CurrentAction == "gridadd") {
			$t_gaji_detail_list->LoadDefaultValues(); // Load default values
		} else {
			$t_gaji_detail_list->LoadRowValues($t_gaji_detail_list->Recordset); // Load row values
		}
		$t_gaji_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_gaji_detail->CurrentAction == "gridadd") // Grid add
			$t_gaji_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_gaji_detail->CurrentAction == "gridadd" && $t_gaji_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_gaji_detail_list->RestoreCurrentRowFormValues($t_gaji_detail_list->RowIndex); // Restore form values
		if ($t_gaji_detail->CurrentAction == "edit") {
			if ($t_gaji_detail_list->CheckInlineEditKey() && $t_gaji_detail_list->EditRowCnt == 0) { // Inline edit
				$t_gaji_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t_gaji_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t_gaji_detail->EventCancelled) {
				$t_gaji_detail_list->RestoreCurrentRowFormValues($t_gaji_detail_list->RowIndex); // Restore form values
			}
			if ($t_gaji_detail_list->RowAction == "insert")
				$t_gaji_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_gaji_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_gaji_detail->CurrentAction == "edit" && $t_gaji_detail->RowType == EW_ROWTYPE_EDIT && $t_gaji_detail->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t_gaji_detail_list->RestoreFormValues(); // Restore form values
		}
		if ($t_gaji_detail->CurrentAction == "gridedit" && ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT || $t_gaji_detail->RowType == EW_ROWTYPE_ADD) && $t_gaji_detail->EventCancelled) // Update failed
			$t_gaji_detail_list->RestoreCurrentRowFormValues($t_gaji_detail_list->RowIndex); // Restore form values
		if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_gaji_detail_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t_gaji_detail->RowAttrs = array_merge($t_gaji_detail->RowAttrs, array('data-rowindex'=>$t_gaji_detail_list->RowCnt, 'id'=>'r' . $t_gaji_detail_list->RowCnt . '_t_gaji_detail', 'data-rowtype'=>$t_gaji_detail->RowType));

		// Render row
		$t_gaji_detail_list->RenderRow();

		// Render list options
		$t_gaji_detail_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_gaji_detail_list->RowAction <> "delete" && $t_gaji_detail_list->RowAction <> "insertdelete" && !($t_gaji_detail_list->RowAction == "insert" && $t_gaji_detail->CurrentAction == "F" && $t_gaji_detail_list->EmptyRow())) {
?>
	<tr<?php echo $t_gaji_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_gaji_detail_list->ListOptions->Render("body", "left", $t_gaji_detail_list->RowCnt);
?>
	<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<td data-name="peg_id"<?php echo $t_gaji_detail->peg_id->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_peg_id" class="t_gaji_detail_peg_id">
<span<?php echo $t_gaji_detail->peg_id->ViewAttributes() ?>>
<?php echo $t_gaji_detail->peg_id->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $t_gaji_detail_list->PageObjName . "_row_" . $t_gaji_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_gjd_id" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_gjd_id" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_gjd_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->gjd_id->CurrentValue) ?>">
<input type="hidden" data-table="t_gaji_detail" data-field="x_gjd_id" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_gjd_id" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_gjd_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->gjd_id->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT || $t_gaji_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_gaji_detail" data-field="x_gjd_id" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_gjd_id" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_gjd_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->gjd_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<td data-name="b_mn"<?php echo $t_gaji_detail->b_mn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_mn" class="t_gaji_detail_b_mn">
<span<?php echo $t_gaji_detail->b_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_mn->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<td data-name="b_sn"<?php echo $t_gaji_detail->b_sn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sn" class="t_gaji_detail_b_sn">
<span<?php echo $t_gaji_detail->b_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sn->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<td data-name="b_sl"<?php echo $t_gaji_detail->b_sl->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sl" class="t_gaji_detail_b_sl">
<span<?php echo $t_gaji_detail->b_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sl->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<td data-name="b_rb"<?php echo $t_gaji_detail->b_rb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_rb" class="t_gaji_detail_b_rb">
<span<?php echo $t_gaji_detail->b_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_rb->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<td data-name="b_km"<?php echo $t_gaji_detail->b_km->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_km" class="t_gaji_detail_b_km">
<span<?php echo $t_gaji_detail->b_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_km->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<td data-name="b_jm"<?php echo $t_gaji_detail->b_jm->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_jm" class="t_gaji_detail_b_jm">
<span<?php echo $t_gaji_detail->b_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_jm->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<td data-name="b_sb"<?php echo $t_gaji_detail->b_sb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_b_sb" class="t_gaji_detail_b_sb">
<span<?php echo $t_gaji_detail->b_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->b_sb->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<td data-name="l_mn"<?php echo $t_gaji_detail->l_mn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_mn" class="t_gaji_detail_l_mn">
<span<?php echo $t_gaji_detail->l_mn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_mn->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<td data-name="l_sn"<?php echo $t_gaji_detail->l_sn->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sn" class="t_gaji_detail_l_sn">
<span<?php echo $t_gaji_detail->l_sn->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sn->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<td data-name="l_sl"<?php echo $t_gaji_detail->l_sl->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sl" class="t_gaji_detail_l_sl">
<span<?php echo $t_gaji_detail->l_sl->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sl->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<td data-name="l_rb"<?php echo $t_gaji_detail->l_rb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_rb" class="t_gaji_detail_l_rb">
<span<?php echo $t_gaji_detail->l_rb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_rb->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<td data-name="l_km"<?php echo $t_gaji_detail->l_km->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_km" class="t_gaji_detail_l_km">
<span<?php echo $t_gaji_detail->l_km->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_km->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<td data-name="l_jm"<?php echo $t_gaji_detail->l_jm->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_jm" class="t_gaji_detail_l_jm">
<span<?php echo $t_gaji_detail->l_jm->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_jm->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<td data-name="l_sb"<?php echo $t_gaji_detail->l_sb->CellAttributes() ?>>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_gaji_detail_list->RowCnt ?>_t_gaji_detail_l_sb" class="t_gaji_detail_l_sb">
<span<?php echo $t_gaji_detail->l_sb->ViewAttributes() ?>>
<?php echo $t_gaji_detail->l_sb->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_gaji_detail_list->ListOptions->Render("body", "right", $t_gaji_detail_list->RowCnt);
?>
	</tr>
<?php if ($t_gaji_detail->RowType == EW_ROWTYPE_ADD || $t_gaji_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_gaji_detaillist.UpdateOpts(<?php echo $t_gaji_detail_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_gaji_detail->CurrentAction <> "gridadd")
		if (!$t_gaji_detail_list->Recordset->EOF) $t_gaji_detail_list->Recordset->MoveNext();
}
?>
<?php
	if ($t_gaji_detail->CurrentAction == "gridadd" || $t_gaji_detail->CurrentAction == "gridedit") {
		$t_gaji_detail_list->RowIndex = '$rowindex$';
		$t_gaji_detail_list->LoadDefaultValues();

		// Set row properties
		$t_gaji_detail->ResetAttrs();
		$t_gaji_detail->RowAttrs = array_merge($t_gaji_detail->RowAttrs, array('data-rowindex'=>$t_gaji_detail_list->RowIndex, 'id'=>'r0_t_gaji_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_gaji_detail->RowAttrs["class"], "ewTemplate");
		$t_gaji_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_gaji_detail_list->RenderRow();

		// Render list options
		$t_gaji_detail_list->RenderListOptions();
		$t_gaji_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $t_gaji_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_gaji_detail_list->ListOptions->Render("body", "left", $t_gaji_detail_list->RowIndex);
?>
	<?php if ($t_gaji_detail->peg_id->Visible) { // peg_id ?>
		<td data-name="peg_id">
<span id="el$rowindex$_t_gaji_detail_peg_id" class="form-group t_gaji_detail_peg_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id"><?php echo (strval($t_gaji_detail->peg_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t_gaji_detail->peg_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_gaji_detail->peg_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_gaji_detail->peg_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->CurrentValue ?>"<?php echo $t_gaji_detail->peg_id->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="s_x<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo $t_gaji_detail->peg_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_peg_id" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_peg_id" value="<?php echo ew_HtmlEncode($t_gaji_detail->peg_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_mn->Visible) { // b_mn ?>
		<td data-name="b_mn">
<span id="el$rowindex$_t_gaji_detail_b_mn" class="form-group t_gaji_detail_b_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_mn->EditValue ?>"<?php echo $t_gaji_detail->b_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_mn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_mn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sn->Visible) { // b_sn ?>
		<td data-name="b_sn">
<span id="el$rowindex$_t_gaji_detail_b_sn" class="form-group t_gaji_detail_b_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sn->EditValue ?>"<?php echo $t_gaji_detail->b_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sl->Visible) { // b_sl ?>
		<td data-name="b_sl">
<span id="el$rowindex$_t_gaji_detail_b_sl" class="form-group t_gaji_detail_b_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sl->EditValue ?>"<?php echo $t_gaji_detail->b_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sl" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_rb->Visible) { // b_rb ?>
		<td data-name="b_rb">
<span id="el$rowindex$_t_gaji_detail_b_rb" class="form-group t_gaji_detail_b_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_rb->EditValue ?>"<?php echo $t_gaji_detail->b_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_rb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_rb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_km->Visible) { // b_km ?>
		<td data-name="b_km">
<span id="el$rowindex$_t_gaji_detail_b_km" class="form-group t_gaji_detail_b_km">
<input type="text" data-table="t_gaji_detail" data-field="x_b_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_km->EditValue ?>"<?php echo $t_gaji_detail->b_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_km" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_km->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_jm->Visible) { // b_jm ?>
		<td data-name="b_jm">
<span id="el$rowindex$_t_gaji_detail_b_jm" class="form-group t_gaji_detail_b_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_b_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_jm->EditValue ?>"<?php echo $t_gaji_detail->b_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_jm" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_jm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->b_sb->Visible) { // b_sb ?>
		<td data-name="b_sb">
<span id="el$rowindex$_t_gaji_detail_b_sb" class="form-group t_gaji_detail_b_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_b_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->b_sb->EditValue ?>"<?php echo $t_gaji_detail->b_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_b_sb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_b_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->b_sb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_mn->Visible) { // l_mn ?>
		<td data-name="l_mn">
<span id="el$rowindex$_t_gaji_detail_l_mn" class="form-group t_gaji_detail_l_mn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_mn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_mn->EditValue ?>"<?php echo $t_gaji_detail->l_mn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_mn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_mn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_mn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sn->Visible) { // l_sn ?>
		<td data-name="l_sn">
<span id="el$rowindex$_t_gaji_detail_l_sn" class="form-group t_gaji_detail_l_sn">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sn" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sn->EditValue ?>"<?php echo $t_gaji_detail->l_sn->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sn" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sn" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sn->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sl->Visible) { // l_sl ?>
		<td data-name="l_sl">
<span id="el$rowindex$_t_gaji_detail_l_sl" class="form-group t_gaji_detail_l_sl">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sl" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sl->EditValue ?>"<?php echo $t_gaji_detail->l_sl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sl" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sl" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_rb->Visible) { // l_rb ?>
		<td data-name="l_rb">
<span id="el$rowindex$_t_gaji_detail_l_rb" class="form-group t_gaji_detail_l_rb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_rb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_rb->EditValue ?>"<?php echo $t_gaji_detail->l_rb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_rb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_rb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_rb->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_km->Visible) { // l_km ?>
		<td data-name="l_km">
<span id="el$rowindex$_t_gaji_detail_l_km" class="form-group t_gaji_detail_l_km">
<input type="text" data-table="t_gaji_detail" data-field="x_l_km" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_km->EditValue ?>"<?php echo $t_gaji_detail->l_km->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_km" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_km" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_km->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_jm->Visible) { // l_jm ?>
		<td data-name="l_jm">
<span id="el$rowindex$_t_gaji_detail_l_jm" class="form-group t_gaji_detail_l_jm">
<input type="text" data-table="t_gaji_detail" data-field="x_l_jm" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_jm->EditValue ?>"<?php echo $t_gaji_detail->l_jm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_jm" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_jm" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_jm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_gaji_detail->l_sb->Visible) { // l_sb ?>
		<td data-name="l_sb">
<span id="el$rowindex$_t_gaji_detail_l_sb" class="form-group t_gaji_detail_l_sb">
<input type="text" data-table="t_gaji_detail" data-field="x_l_sb" name="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="x<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" size="2" placeholder="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->getPlaceHolder()) ?>" value="<?php echo $t_gaji_detail->l_sb->EditValue ?>"<?php echo $t_gaji_detail->l_sb->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_gaji_detail" data-field="x_l_sb" name="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" id="o<?php echo $t_gaji_detail_list->RowIndex ?>_l_sb" value="<?php echo ew_HtmlEncode($t_gaji_detail->l_sb->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_gaji_detail_list->ListOptions->Render("body", "right", $t_gaji_detail_list->RowCnt);
?>
<script type="text/javascript">
ft_gaji_detaillist.UpdateOpts(<?php echo $t_gaji_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t_gaji_detail->CurrentAction == "add" || $t_gaji_detail->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" id="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" value="<?php echo $t_gaji_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($t_gaji_detail->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" id="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" value="<?php echo $t_gaji_detail_list->KeyCount ?>">
<?php echo $t_gaji_detail_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t_gaji_detail->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" id="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" value="<?php echo $t_gaji_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($t_gaji_detail->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" id="<?php echo $t_gaji_detail_list->FormKeyCountName ?>" value="<?php echo $t_gaji_detail_list->KeyCount ?>">
<?php echo $t_gaji_detail_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t_gaji_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t_gaji_detail_list->Recordset)
	$t_gaji_detail_list->Recordset->Close();
?>
<?php if ($t_gaji_detail->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t_gaji_detail->CurrentAction <> "gridadd" && $t_gaji_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_gaji_detail_list->Pager)) $t_gaji_detail_list->Pager = new cPrevNextPager($t_gaji_detail_list->StartRec, $t_gaji_detail_list->DisplayRecs, $t_gaji_detail_list->TotalRecs) ?>
<?php if ($t_gaji_detail_list->Pager->RecordCount > 0 && $t_gaji_detail_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_gaji_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_gaji_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_gaji_detail_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_gaji_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_gaji_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_gaji_detail_list->PageUrl() ?>start=<?php echo $t_gaji_detail_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t_gaji_detail_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t_gaji_detail_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t_gaji_detail_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t_gaji_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t_gaji_detail_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t_gaji_detail_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t_gaji_detail_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t_gaji_detail_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="200"<?php if ($t_gaji_detail_list->DisplayRecs == 200) { ?> selected<?php } ?>>200</option>
<option value="ALL"<?php if ($t_gaji_detail->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_gaji_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t_gaji_detail_list->TotalRecs == 0 && $t_gaji_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_gaji_detail_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_gaji_detail->Export == "") { ?>
<script type="text/javascript">
ft_gaji_detaillist.Init();
</script>
<?php } ?>
<?php
$t_gaji_detail_list->ShowPageFooter();
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
$t_gaji_detail_list->Page_Terminate();
?>
