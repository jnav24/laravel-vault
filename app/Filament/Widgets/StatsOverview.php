<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $maxSite = [];

        $sites = Site::query()
            ->with('access')
            ->where('user_id', auth()->user()->id)
            ->get();

        $collect = $sites->map(function (Site $site) use (&$maxSite) {
            $count = $site->access->count();

            if (empty($maxSite) || $count > $maxSite['count']) {
                $maxSite = ['name' => $site->name, 'count' => $count];
            }

            return $count;
        });

        return [
            Card::make('Total No. of Users', $collect->sum()),
            Card::make('Site with Most Users', $maxSite['name']),
        ];
    }
}
