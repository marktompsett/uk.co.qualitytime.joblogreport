<?php
/*  Title: 	Scheduled Job Log Report
 *  Author:	Mark Tompsett <mark.tompsett@qualitytime.co.uk>
 */

//	error_reporting(E_ALL);
//	ini_set('display_errors', TRUE);
//	ini_set('display_startup_errors', TRUE);

require_once 'CRM/Report/Form.php';

class CRM_Report_Form_Job_JobLog1 extends CRM_Report_Form    {
  
  function __construct()  {
    $this->_columns = array(
      'civicrm_job_log'   => array(
	    'dao' => 'CRM_Contact_DAO_Contact',		//	we need a DAO even though this report is nothing to do with Contacts
        'fields' => array(
         'domain_id' => array(
            'title'    		=> ts('Domain'),
            'default'  		=> false,
          ),
           'run_time' => array(
            'title'    		=> ts('Run Time'),
            'default'  		=> true,
          ),
           'job_id' => array(
            'title'    		=> ts('Job ID'),
            'required'  	=> true,			//	this column is required...
            'no_display'	=> true,			//	...but not displayed because we only use it to construct a hyperlink for the job name
          ),
          'name' => array(
            'title'    		=> ts('Job'),
            'default'   	=> true,
          ),
          'command' => array(
            'title'    		=> ts('Command'),
            'default'   	=> false,
          ),
          'description' => array(
            'title'    		=> ts('Description'),
            'default'   	=> true,
          ),
          'data' => array(
            'title'    		=> ts('Data'),
            'default'   	=> true,
          ),
        ),
		'filters' => array( 
		  'jid' =>	array( 
			'name'         	=> 'job_id',
			'title'        	=> ts( 'Job' ),
			'type'         	=> CRM_Utils_Type::T_INT,
			'operatorType' 	=> CRM_Report_Form::OP_MULTISELECT,
			'options'      	=> array( ),
		  ),																//	maybe we could also filter on domain ?
		),
      ),
    );
    $sql = "SELECT id, name FROM civicrm_job WHERE last_run IS NOT NULL ";	//	only get ids of jobs which have been run
    $dao = CRM_Core_DAO::executeQuery( $sql, CRM_Core_DAO::$_nullArray );	
	while ($dao->fetch()) {	
	  $id = $dao->id;
	  $name = $dao->name;
	  $this->_columns['civicrm_job_log']['filters']['jid']['options'][$id] = $name;
    }
	$this->_add2groupSupported = false;										//	suppress "Add these Contacts to Group" functionality
    parent::__construct();
  }

  function from()  {
    $this->_from = "FROM civicrm_job_log {$this->_aliases['civicrm_job_log']}";
  }

  function where( ) {
	$clauses = array( );
	foreach ( $this->_columns as $tableName => $table ) {
	  if ( array_key_exists('filters', $table) ) {
		foreach ( $table['filters'] as $fieldName => $field ) {
		  $clause = null;
		  if ( CRM_Utils_Array::value( 'operatorType', $field ) & CRM_Utils_Type::T_DATE ) {
		    $relative = CRM_Utils_Array::value( "{$fieldName}_relative", $this->_params );
		    $from     = CRM_Utils_Array::value( "{$fieldName}_from"    , $this->_params );
			$to       = CRM_Utils_Array::value( "{$fieldName}_to"      , $this->_params );
			$clause   = $this->dateClause( $field['name'], $relative, $from, $to, $field['type'] );
		  } else {
			$op = CRM_Utils_Array::value( "{$fieldName}_op", $this->_params );
			if ( $op ) {
			  $clause = $this->whereClause( $field,
											$op,
											CRM_Utils_Array::value( "{$fieldName}_value", $this->_params ),
											CRM_Utils_Array::value( "{$fieldName}_min", $this->_params ),
											CRM_Utils_Array::value( "{$fieldName}_max", $this->_params ) );
			}
		  }
		  if ( ! empty( $clause ) ) {
		    $clauses[ ] = $clause;
		  }
		}
	  }
	}
	if ( empty( $clauses ) ) {
	  $this->_where = "WHERE ( 1 ) ";
	} else {
	  $this->_where = "WHERE " . implode( ' AND ', $clauses );
	}
  }

  function orderBy( ) {
    $this->_orderBy = " ORDER BY {$this->_aliases['civicrm_job_log']}.id DESC ";	//	report most recent entries first
  }

  function alterDisplay( &$rows ) {     										    // custom code to alter rows
    $entryFound = false;     
    foreach ( $rows as $rowNum => $row ) {
	  if ( array_key_exists('civicrm_job_log_name', $row) )	{						// name exists so reformat it as a hyperlink
        $name = $rows[$rowNum]['civicrm_job_log_name' ];
        $url = CRM_Utils_System::url( 'civicrm/admin/job', 'action=update&id=' . $row['civicrm_job_log_job_id'] . '&reset=1', $this->_absoluteUrl );
        $rows[$rowNum]['civicrm_job_log_name_link' ] = $url;
        $rows[$rowNum]['civicrm_job_log_name_hover'] = ts("Click to edit this Scheduled Job");
        $entryFound = true;
	  }
	  if ( array_key_exists('civicrm_job_log_data', $row) )	{
	     $rows[$rowNum]['civicrm_job_log_data'] = '<pre>' . $row['civicrm_job_log_data'] . '</pre>';
      }	  
      if ( !$entryFound ) {
        break;																		// skip looking further in rows if first row doesn't have the column(s) we need
      }
    }
  }
}

?>