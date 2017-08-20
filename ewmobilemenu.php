<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(6, "mmi_c_home_php", $Language->MenuPhrase("6", "MenuText"), "c_home.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(5, "mmi_t_project", $Language->MenuPhrase("5", "MenuText"), "t_projectlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_t_periode", $Language->MenuPhrase("4", "MenuText"), "t_periodelist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_t_pegawai", $Language->MenuPhrase("3", "MenuText"), "t_pegawailist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_t_gaji_master", $Language->MenuPhrase("2", "MenuText"), "t_gaji_masterlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
