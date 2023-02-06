<?php

namespace App\Util;

class Formatting
{

    private const monthsMap = [
        "Jan" => "يناير",
        "Feb" => "فبراير",
        "Mar" => "مارس",
        "Apr" => "أبريل",
        "May" => "مايو",
        "Jun" => "يونيو",
        "Jul" => "يوليو",
        "Aug" => "أغسطس",
        "Sep" => "سبتمبر",
        "Oct" => "أكتوبر",
        "Nov" => "نوفمبر",
        "Dec" => "ديسمبر",
    ];

    public static function getFormattedMonth($m)
    {
        return app()->getLocale() == 'ar' ?
            Formatting::monthsMap[$m]  :
            $m;
    }

    //USER BANNER
    public static function getNameForNavBar()
    {
        if (auth()->user() == null)
            return __('fields.username');

        return auth()->user()->name . ' (' . auth()->user()->branch->name . ')';
    }

    public static function getUserTypeForNavBar()
    {
        if (auth()->user() == null)
            return __('fields.userType');

        switch (auth()->user()->type) {

            case '-1':
                return __('fields.super-admin');
            case '0':
                return __('fields.admin');
            case '1':
                return __('fields.normal-user');
        }
    }

    public static function formatInThreeDigits($num)
    {
        return sprintf('%03d', $num);
    }

    public static function formatInTwoDigits($num)
    {
        return sprintf('%02d', $num);
    }

    public static function formatInCurrency($num, $addSuffix = true)
    {
        $num = number_format($num, 3);

        if ($addSuffix)
            $num .= ' ' . __('fields.EGP');

        return  $num;
    }
}
