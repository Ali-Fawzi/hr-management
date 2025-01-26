<?php

namespace App\DataTables;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PositionsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($position) {
                return '
                    <a href="' . route('positions.edit', $position->position_id) . '" class="btn btn-sm">
                        <i class="bi bi-pencil-fill text-primary"></i>
                    </a>
                    <form action="' . route('positions.destroy', $position->position_id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm" onclick="return confirm(\'Are you sure?\')">
                            <i class="bi bi-trash-fill text-danger"></i>
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->setRowId('position_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Position $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('job-positions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->responsive()
                    ->buttons([
                        Button::make('add'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    ])
                    ->parameters([
                        'order' => [[0, 'asc']],
                        'dom' => '<"top mb-2"Bfl>rt<"bottom d-flex align-items-center justify-content-between mt-3"ip>',
                    ])
                    ->select(false);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('position_id')->title('Id'),
            Column::make('title'),
            Column::make('description'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(120)
            ->addClass('text-center no-search'),
        ];
    }
    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Positions_' . date('Y-m-d H:i:s');
    }
}
