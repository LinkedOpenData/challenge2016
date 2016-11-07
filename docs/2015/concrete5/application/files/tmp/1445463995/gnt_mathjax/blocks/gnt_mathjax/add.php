<?php  defined('C5_EXECUTE') or die('Access Denied.');
/**
 *-----------------------------------------------------------------------------*
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2013 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */


// Set default values :

$useGlobalConf = true;
$CDNversion = 'latest';
$useCDN = true;
$configName = "TeX-MML-AM_HTMLorMML";

// Can use only one form :
$this->inc('edit.php', get_defined_vars() );
