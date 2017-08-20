<?php include_once "t_gaji_detailinfo.php" ?>
<?php

//
// Page class
//

$t_gaji_detail_grid = NULL; // Initialize page object first

class ct_gaji_detail_grid extends ct_gaji_detail {

	// Page ID
	var $PageID = 'grid';

	// Project ID
	var $ProjectID = "{CCC661CC-E251-4AC9-9C43-38E94C9A89E5}";

	// Table name
	var $TableName = 't_gaji_detail';

	// Page object name
	var $PageObjName = 't_gaji_detail_grid';

	// Grid form hidden field names
	var $FormName = 'ft_gaji_detailgrid';
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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t_gaji_detail)
		if (!isset($GLOBALS["t_gaji_detail"]) || get_class($GLOBALS["t_gaji_detail"]) == "ct_gaji_detail") {
			$GLOBALS["t_gaji_detail"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["t_gaji_detail"];

		}
		$this->AddUrl = "t_gaji_detailadd.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

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

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;
		$this->Page_Redirecting($url);

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
	var $ShowOtherOptions = FALSE;
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

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

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

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
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
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old recordset
			}
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
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

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
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
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

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
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
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
		if ($this->CurrentMode == "view") { // View mode

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
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->gjd_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('gjd_id');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = "btn-sm"; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->Add("add");
			$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
			$item->Visible = ($this->AddUrl <> "");
		}
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
				$item->Visible = TRUE;
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->GetItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
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
		$objForm->FormName = $this->FormName;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->gjd_id->CurrentValue = strval($arKeys[0]); // gjd_id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		$this->CopyUrl = $this->GetCopyUrl();
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

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "t_gaji_master") {
				$this->gjm_id->CurrentValue = $this->gjm_id->getSessionValue();
			}
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

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "t_gaji_master") {
			$this->gjm_id->Visible = FALSE;
			if ($GLOBALS["t_gaji_master"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
