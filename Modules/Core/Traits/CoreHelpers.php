<?php

namespace Modules\Core\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait CoreHelpers
{
    public function getAllDatesBetweenTwoDates($dateFrom, $dateTo)
    {
        $dates = [];
        $period = \Carbon\CarbonPeriod::create($dateFrom, $dateTo);
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }
    public function extractRestaurantVacationsRange($customVacations)
    {
        $customVacationsData = [];
        if (!empty($customVacations)) {
            foreach ($customVacations as $i => $vacation) {
                $vacation = explode(' - ', $vacation);
                $customVacationsData[] = $this->getAllDatesBetweenTwoDates($vacation[0], $vacation[1]);
            }
            $customVacationsData = Arr::collapse($customVacationsData);
        }
        return $customVacationsData;
    }



    public function isClosedOn($date)
    {
        $vacations = array_keys(setting('week_end') ?? []);
        $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($date)));
        $isClosed = false;
        $shortDay = Str::lower($date->format('D'));

        $customVacations = array_unique(
            $this->extractRestaurantVacationsRange(setting('vacation', 'date_range')) ?? []
        );
        // info('customVacations');
        // info($customVacations);

        if (setting('week_end') && in_array($shortDay, setting('week_end'))) {
            $isClosed = true;
        }

        info('isClosed after week_end');
        info($isClosed ? 'true': 'false');
        // info('setting(\'week_end\')');
        // info(setting('week_end'));
        if (!empty($customVacations) && in_array($date->format('Y-m-d'), $customVacations)) {
            $isClosed = true;
        }

        info('isClosed after customVacations');
        info($isClosed ? 'true': 'false');
        return $isClosed;
    }

     public function calculateEndAt($startAt, $duration)
     {
         $endAt = Carbon::parse($startAt);

         for ($i = 0; $duration > $i;) {

             if (!$this->isClosedOn($endAt)) {
                $i++;
             }
             $endAt->addDay();
         }

         return $endAt->subDays(1);
     }
}
