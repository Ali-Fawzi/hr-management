<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function ($employee) {
            return '
                <a href="' . route('employees.show', $employee->employee_id) . '" class="btn btn-sm">
                    <i class="bi bi-eye-fill text-primary"></i>
                </a>
            ';
        })
        ->editColumn('position', function ($employee) {
            return $employee->position->title;
        })
        ->editColumn('department', function ($employee) {
            return $employee->department->name;
        })
        ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->with(['department', 'position']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employees-table')
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
            Column::make('employee_id')->title('id'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('position')
            ->searchable(false)
            ->orderable(false),
            Column::make('department')
            ->searchable(false)
            ->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center no-search'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Employees_' . date('Y-m-d H:i:s');
    }
}
