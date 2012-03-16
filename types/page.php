<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Brend Wanders <b.wanders@utwente.nl>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

/**
 * The page link type.
 */
class plugin_strata_type_page extends plugin_strata_type {
    function normalize($value, $hint) {
        global $ID;

        $base = ($hint?:getNS($ID));

        // check for local link, and prefix full page id
        // (local links don't get resolved by resolve_pageid)
        if(preg_match('/^#.+/',$value)) {
            $value = $ID.$value;
        }

        // resolve page id with respect to selected base
        resolve_pageid($base,$value,$exists);

        return $value;
    }

    function render($mode, &$R, &$T, $value, $hint) {
        // render internal link
        // (':' is prepended to make sure we use an absolute pagename,
        // internallink resolves page names, but the name is already resolved.)
        $R->internallink(':'.$value);
    }

    function getInfo() {
        return array(
            'desc'=>'Links to a wiki page. The optional hint is treated as namespace for the link.',
            'hint'=>'namespace'
        );
    }
}
