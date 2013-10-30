<?php

require_once 'civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function joblogreport_civicrm_config(&$config) {
//  watchdog('php', 'joblogreport_civicrm_config', NULL, WATCHDOG_DEBUG);
  _civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function joblogreport_civicrm_xmlMenu(&$files) {
//  watchdog('php', 'joblogreport_civicrm_xmlMenu', NULL, WATCHDOG_DEBUG);
  _civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function joblogreport_civicrm_install() {
// watchdog('php', 'joblogreport_civicrm_install', NULL, WATCHDOG_DEBUG);
  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, __DIR__ . '/sql/auto_install.sql');
  return _civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function joblogreport_civicrm_uninstall() {
//  watchdog('php', 'joblogreport_civicrm_uninstall', NULL, WATCHDOG_DEBUG);
  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, __DIR__ . '/sql/auto_uninstall.sql');
  return _civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function joblogreport_civicrm_enable() {
//  watchdog('php', 'joblogreport_civicrm_enable', NULL, WATCHDOG_DEBUG);
  return _civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function joblogreport_civicrm_disable() {
//  watchdog('php', 'joblogreport_civicrm_disable', NULL, WATCHDOG_DEBUG);
  return _civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function joblogreport_civicrm_managed(&$entities) {
//  watchdog('php', 'joblogreport_civicrm_managed', NULL, WATCHDOG_DEBUG);
  return _civix_civicrm_managed($entities);
}

?>