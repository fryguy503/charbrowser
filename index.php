<?php
/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   Portions of this program are derived from publicly licensed software
 *   projects including, but not limited to phpBB, Magelo Clone, 
 *   EQEmulator, EQEditor, and Allakhazam Clone.
 *
 *                                  Author:
 *                           Maudigan(Airwalking) 
 *
 *   September 28, 2014 - Maudigan
 *      added code to monitor database performance
 *   May 24, 2016 - Maudigan
 *      general code cleanup, whitespace correction, removed old comments,
 *      organized some code. A lot has changed, but not much functionally
 *      do a compare to 2.41 to see the differences. 
 *      Implemented new database wrapper.
 *   September 16, 2017 - Maudigan
 *      Modify script to be able to redirect to the other pages using the
 *      "page" variable.
 ***************************************************************************/
  
 
/*********************************************
                 INCLUDES
*********************************************/ 
define('INCHARBROWSER', true);
include_once(__DIR__ . "/include/config.php");
include_once(__DIR__ . "/include/version.php");
include_once(__DIR__ . "/include/language.php");
include_once(__DIR__ . "/include/functions.php");
include_once(__DIR__ . "/include/global.php");
 
 
 
/*********************************************
               INDEX REQUESTED
*********************************************/
if (empty($_REQUEST['page']))
{ 
   /*********************************************
                  DROP INDEX HEADER
   *********************************************/
   $d_title = $subtitle;
   include(__DIR__ . "/include/header.php");
    
    
   /*********************************************
                 POPULATE BODY
   *********************************************/  
   $cb_template->set_filenames(array(
     'index' => 'index_body.tpl')
   );

   $cb_template->assign_both_vars(array(  
      'TITLE' => $mytitle,
      'VERSION' => $version)
   );
   $cb_template->assign_vars(array(  
      'L_VERSION' => $language['INDEX_VERSION'],
      'L_BY' => $language['INDEX_BY'],
      'L_INTRO' => $language['INDEX_INTRO'])
   );
 
 
   /*********************************************
              OUTPUT BODY AND FOOTER
   *********************************************/
   $cb_template->pparse('index');

   $cb_template->destroy;

   include(__DIR__ . "/include/footer.php");   
}


/*********************************************
             OTHER PAGE REQUESTED
*********************************************/
else
{
   /*********************************************
                INPUT VALIDATION
   *********************************************/ 
   //we use the page variable to redirect this script to one of the other php scripts
   //this permits us to use index.php to display every single page in the utility
    
   // Make sure the request isn't escaping to another unintended directory 
   if (strpos($_REQUEST['page'], '.') > 0 || strpos($_REQUEST['page'], '/') > 0 || strpos($_REQUEST['page'], '\\') > 0)
   { 
      cb_message_die($language['MESSAGE_ERROR'],$language['MESSAGE_NOPAGE']);
   } 

   //get the absolute path to the requested script
   $page = __DIR__ . "/" . $_REQUEST['page'] . ".php";

   //make sure the script exists so the include doesn't error
   if (!file_exists($page))
   { 
      cb_message_die($language['MESSAGE_ERROR'],$language['MESSAGE_NOPAGE']);
   } 
   
   include($page);
} 

?>