<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('components.layouts.adminAuth')]
    public function render()
    {
        $users = User::count();

        $widget = [
            'users' => $users
        ];

        $columnChartModel = (new ColumnChartModel())
            ->setTitle('Income Chart')
            ->addColumn('January', 100, '#f6ad55')
            ->addColumn('February', 200, '#fc8181')
            ->addColumn('March', 52, '#125df4')
            ->addColumn('April', 123, '#93cdf4')
            ->addColumn('May', 643, '#1a32f4')
            ->addColumn('June', 521, '#10cdf4')
            ->addColumn('July', 14, '#20cdf4')
            ->addColumn('August', 161, '#30cdf4')
            ->addColumn('September', 899, '#40cdf4')
            ->addColumn('November', 251, '#50cdf4')
            ->addColumn('December', 321, '#60cdf4');

        // $lineChartModel = (new LineChartModel())
        //     ->setTitle('Occupancy Rate')
        //     ->setAnimated(true)
        //     ->withOnPointClickEvent('onPointClick')
        //     ->setSmoothCurve()
        //     ->setXAxisVisible(true)
        //     ->setDataLabelsEnabled(false)
        //     ->sparklined();
            // ->addSlice('January', 100, '#f6ad55')
            // ->addSlice('February', 200, '#fc8181')
            // ->addSlice('March', 52, '#125df4')
            // ->addSlice('December', 321, '#60cdf4');

        return view('livewire.admin.dashboard', [
            'widget' => $widget,
            'columnChartModel' => $columnChartModel,
            // 'lineChartModel' => $lineChartModel
        ]);
    }
}
