<?php

namespace Modules\Package\ViewComposers\Dashboard;

use Cache;
use Illuminate\View\View;
use Modules\Package\Repositories\Dashboard\SubscriptionRepository;

class SubscriptionComposer
{
    public function __construct(SubscriptionRepository $order)
    {
        $this->orders = $order->allOrders();
        $this->completeOrders = $order->completeOrders();
        $this->orders_total = $order->orderSum();

        $this->todayProfit = $order->totalTodayProfit();
        $this->monthProfit = $order->totalMonthProfit();
        $this->yearProfit = $order->totalYearProfit();
        $this->totalProfit = $order->totalProfit();

        $this->orders_count = $order->getOrdersQuery()->count();
        $this->monthlyOrders = $order->monthlyOrders();
    }

    public function compose(View $view)
    {
        $view->with('orders_count', $this->orders);
        $view->with('completeOrders', $this->completeOrders);
        $view->with('orders_total', $this->orders_total);

        $view->with([
            "todayProfit" => $this->todayProfit,
            "monthProfit" => $this->monthProfit,
            "yearProfit" => $this->yearProfit
        ]);
        $view->with('totalProfit', $this->totalProfit);

        $view->with('monthlyOrders', $this->monthlyOrders);
    }
}
