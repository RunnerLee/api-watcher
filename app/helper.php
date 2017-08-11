<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

if (!function_exists('parse_schedule_condition')) {
    function parse_schedule_condition($condition)
    {
        if (!is_array($condition = json_decode($condition, true))) {
            return true;
        }

        /**
         * 检查星期
         */
        if (
            isset($condition['week'])
            && is_array($condition['week'])
            && false === array_search(strtolower(date('l')), $condition['week'])
        ) {
            return false;
        }

        $currenctHour = date('G');

        /**
         * 检查 between 时间范围
         */
        if (
            isset($condition['hour']['between']['from'], $condition['hour']['between']['to'])
            && $condition['hour']['between']['from'] <= $condition['hour']['between']['to']
            && ($currenctHour < $condition['hour']['between']['from'] || $currenctHour > $condition['hour']['between']['to'])
        ) {
            return false;
        }

        /**
         * 检查 unless_between 时间范围
         */
        if (
            isset($condition['hour']['unless_between']['from'], $condition['hour']['unless_between']['to'])
            && $condition['hour']['unless_between']['from'] <= $condition['hour']['unless_between']['to']
            && ($currenctHour >= $condition['hour']['unless_between']['from'] && $currenctHour <= $condition['hour']['unless_between']['to'])
        ) {
            return false;
        }

        return true;
    }
}

if (!function_exists('build_json_viewer')) {
    function build_json_viewer($json)
    {
        $id = uniqid('JsonViewer', false);
        return view('weight.json', compact('json', 'id'));
    }
}