<?php

namespace System\Tools;

use System\Tools\DateTool;

/**
 * Form generator
 */

class FormTool
{
    /**
     * @param string $type
     * @param string $name
     * @param string $ph
     * @return string
     */
    public static function input ($type, $name, $ph, $default = null)
    {
        return '<input type="' .$type. '" name="' .$name. '" placeholder="' .$ph. '" value="' .$default. '" />';
    }

    /**
     * @param string $name
     * @param string $ph
     * @return string
     */
    public static function textarea ($name, $ph, $default = null)
    {
        return '<textarea name="' .$name. '" placeholder="' .$ph. '">' .$default. '</textarea>';
    }

    /**
     * @param string $name
     * @param string $text
     * @param array $datas
     * @param int $datas
     * @return string
     */
    public static function select ($name, $text, $datas, $default = null, $multiple = false)
    {
        $html = '<select name="' .$name. '"';
        if ($multiple) $html .= ' multiple';
        $html .= '>';
            $html .= '<optgroup label="' .$text. '">';

                foreach ($datas as $key => $value) {
                    if (!is_null($default) && intval($default) === $key) {
                        $html .= '<option selected value="' .$key. '">' .$value. '</option>';
                        continue;
                    }
                    $html .= '<option value="' .$key. '">' .$value. '</option>';
                }

            $html .= '</optgroup>';
        $html .= '</select>';

        return $html;
    }

    /**
     * @param string $text
     * @param string $action Action of the treatment
     * @param string $type Classe name
     * @return string
     */
    public static function button ($text, $action, $type, $value = null)
    {
        $html = '<button type="submit" name="' .$action. '" class="btn-' .$type. '"';
        if (!is_null($value)) $html .= ' value="' .$value. '"';
        $html .= '>';
        $html .= $text;
        $html .= '</button>';

        return $html;
    }

    /**
     * @param string $name
     * @param string $text
     * @param bool $current
     * @param string $date
     * @return string
     */
    public static function date ($name, $text, $current = false, $default = null)
    {
        $tomorrow = DateTool::dateFormat(DateTool::dateFormat(time(), 'tomorrow'));
        $id = uniqid();

        $html = '<div class="date">';
            $html .= '<label for="' .$id. '">' .$text. '</label>';

            if ($current) $html .= '<input id="' .$id. '" type="date" name="' .$name. '" min="' .$tomorrow. '"';
            else $html .= '<input id="' .$id. '" type="date" name="' .$name. '"';

            if (!is_null($default)) $html .= ' value="' .DateTool::dateFormat($default). '"';
            $html .= ' />';
        $html .= '</div>';

        return $html;
    }
}