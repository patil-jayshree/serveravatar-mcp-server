<?php

namespace App\Helpers;

class TimezoneHelper
{
    public static function getAll(): array
    {
        $regions = array(
            \DateTimeZone::AFRICA,
            \DateTimeZone::AMERICA,
            \DateTimeZone::ANTARCTICA,
            \DateTimeZone::ASIA,
            \DateTimeZone::ATLANTIC,
            \DateTimeZone::AUSTRALIA,
            \DateTimeZone::EUROPE,
            \DateTimeZone::INDIAN,
            \DateTimeZone::PACIFIC,
        );

        $timezones = array();
        foreach ($regions as $region) {
            $timezones = array_merge($timezones, \DateTimeZone::listIdentifiers($region));
        }

        $timezone_offsets = array();
        foreach ($timezones as $timezone) {
            $tz = new \DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new \DateTime);
        }

        // Etc/UTC
        $etcTz = new \DateTimeZone('Etc/UTC');
        $timezone_offsets['Etc/UTC'] = $etcTz->getOffset(new \DateTime);

        // UTC alias (browsers return 'UTC', PHP listIdentifiers returns 'Etc/UTC')
        $utcTz = new \DateTimeZone('UTC');
        $timezone_offsets['UTC'] = $utcTz->getOffset(new \DateTime);

        asort($timezone_offsets);
        $timezone_list = array();

        foreach ($timezone_offsets as $timezone => $offset) {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate('H:i', abs($offset));
            $pretty_offset = "UTC{$offset_prefix}{$offset_formatted}";
            $timezone_list[$timezone] = "({$pretty_offset}) {$timezone}";
        }

        return $timezone_list;
    }
}
