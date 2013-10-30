<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Report_Form_Job_JobLog1',					//	must correspond to the filepath of the Report Template 
    'entity' => 'ReportTemplate',								//	this is a Report Template
	'module' => 'uk.co.qualitytime.joblogreport',				//	must match the key of the Extension
    'params' => 
    array (
      'version' => 3,											//	
      'label' => 'Scheduled Job Log Report',					//	name of the report template
      'description' => 'Recent entries in Scheduled Job Log',	//	description of the report template
      'class_name' => 'CRM_Report_Form_Job_JobLog1',			//	must match the class name in the report template (.php) file
      'report_url' => 'uk.co.qualitytime.joblog/report1',		//	URL of the report template
      'component' => '',										//	null component, ie appears in the Contact Report Templates
    ),
  ),
);