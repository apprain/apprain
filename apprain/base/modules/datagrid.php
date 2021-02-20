<?php

/**
 * appRain CMF
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@apprain.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.org/
 *
 * Download Link
 * http://www.apprain.org/download
 *
 * Documents Link
 * http ://www.apprain.org/general-help-center
 */
class appRain_Base_Modules_DataGrid extends appRain_Base_Objects {

    public $rows = Array();
    public $ondatabind;
    public $class_even = 'even';
    public $class_odd = 'odd';

    public function __construct() {
        $this->ondatabind = App::Load('Module/Event');
    }

    public function clear() {
        $this->setDisplay();
        $this->setHeader();
        $this->rows = Array();
        $this->setFooter();

        return $this;
    }

    public function AddRow() {
        $this->rows[] = new DataGridRow(func_get_args());
        return $this;
    }

    private function attachHeader() {
        $HH = App::Helper('Html');
        $header = $this->getHeader();
        $html = '';
        if (!empty($header)) {
            $html .= '<thead>';
            $html .= '<tr>';
            foreach ($header as $tkey => $tval) {
                if (strtolower($tval) == 'options') {
                    $html .= $HH->getTag('th', Array('align' => 'left', 'width' => '12%'), $this->__($tval)); //
                }
                elseif ($tval == '#' || strtolower($tval) == 'id') {
                    $html .= $HH->getTag('th', Array('align' => 'left', 'width' => '4%'), $this->__($tval)); //
                } else {
                    if (!$tkey) {
                        $html .= $HH->getTag('th', Array('align' => 'left', 'class' => 'first'), $this->__($tval));
                    } else {
                        $html .= $HH->getTag('th', Array('align' => 'left'), $this->__($tval));
                    }
                }
            }
            $html .= '</tr>';
            $html .= '</thead>';
        }

        return $html;
    }

    public function attachFooter() {
        $html = "";
        $link = $this->getFooter();
        if (isset($link)) {
            $HH = App::Helper('Html');
            $html = '<tfoot>';
            $html .= '<tr>';
            if (is_array($link)) {
                foreach ($link as $tkey => $tval) {
                    if ((count($link) - 1) == $tkey) {
                        $html .= $HH->getTag(
                                'th', Array(
                            'align' => 'left',
                            'class' => 'first'
                                ), $tval
                        );
                    } else {
                        $html .= $HH->getTag(
                                'th', Array(
                            'align' => 'left',
                            'class' => 'last'
                                ), $tval
                        );
                    }
                }
            } else {
                $html .= $HH->getTag(
                        'td', Array(
                    'colspan' => count($this->getHeader()),
                    'align' => 'center',
                    'class' => 'first'), $link
                );
            }
            $html .= $HH->getTag('/tr');
            $html .= $HH->getTag('/tfoot');
        }

        return $html;
    }

    public function attachBody() {
        $HH = App::Helper('Html');

        $html = '<tbody>';
        foreach ($this->rows as $rkey => $row) {
            $this->ondatabind->Raise($this, $row);
            $html.= '<tr>';
            if ($this->getDisplay() == 'FormListing') {
                $row->cells[1] = ($row->cells[1] != '') ? $row->cells[1] : '&nbsp;';
                $hints = isset($row->cells[2]) && $row->cells[2] != '' ? "<div class=\"hints\">{$row->cells[2]}</div>" : "";
                $row->cells[4] = isset($row->cells[4]) ? $row->cells[4] : '&nbsp;';
                $html.= '<th>' . $row->cells[0] . '</th><td class="is-mendatory">' . $row->cells[4] . '</td><td>' . $hints . $row->cells[1] . '</td>';
            } else {
                $last = array_pop($row->cells);
                $html.= '<td class="first">' . implode('</td><td >', $row->cells) . '</td>';
                $html.= '<td >' . $last . '</td>';
            }
            $html.= '</tr>';
        }
        $html .= '</tbody>';

        return $html;
    }

    public function Render($offAutoDis = false, $options = null) {
        $HH = App::Helper('Html');
        $html = $this->attachHeader();
        $html .= $this->attachBody();
        $html .= $this->attachFooter();

        if ($this->getDisplay() == 'FormListing') {
            $options = array("class" => "form-grid", "cellpadding" => "0", "cellspacing" => "0", "border" => "0", "width" => "100%");
            $htmlc = $HH->getTag('table', $options, $html);
        } else {
            $options = array("class" => "data-grid", "cellpadding" => "0", "cellspacing" => "0", "border" => "0", "width" => "100%");
            $htmlc = $HH->getTag('table', $options, $html);
        }

        if ($offAutoDis) {
            return $htmlc;
        } else {
            echo $htmlc;
        }
    }

}

class DataGridRow {

    public $cells;

    function __construct() {
        $array = func_get_args();
        $this->cells = $array[0];
    }

}
