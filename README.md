JobLogReport
============

CiviCRM Scheduled Job Log Report (alternative to the View Log feature in Scheduled Jobs)

This is an Extension to CiviCRM which installs a report template, Scheduled Job Log Report, which displays the most recent entries in the CiviCRM Scheduled Job Log.
When the Job Log (civicrm_job_log) table gets very large this can cause WSOD or "Allowed memory size ... exceeded" errors when trying to View Log in Scheduled Jobs.
## Installation Instructions
Download this repository and put *uk.co.qualitytime.joblogreport* into your Extensions directory, then **Manage Extensions** to **Install** it.
In your Report Templates (under Contact Report Templates) you will find a new report template, *Scheduled Job Log Report*.
