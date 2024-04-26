<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Caisse;
use App\Models\Transaction;
use Crypt;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class IndexTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public $transactions;
    public string $sortField = 'created_at';    
    public string $sortDirection = 'desc';
    
    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
            ->showSearchInput()
            ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Transaction>
     */
    public function datasource()
    {
    
        $user = Auth::user();

        return $this->transactions;

    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
    
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
    
        return PowerGrid::columns()
            // ->addColumn('id')
            ->addColumn('operation', function (Transaction $model) {
                if ($model->type == 'crédit') {
                    $color = "btn-success ";
                    $icon = '<i class="mdi mdi-arrow-up-bold"></i>';

                } else{
                    $color = "btn-danger ";
                    $icon = '<i class="mdi mdi-arrow-down-bold"></i>';
                }

                return  '<button type="button" class="btn ' . $color . ' btn-sm rounded-pill">' . $icon.' '.$model->operation . '</button>';
            })
            ->addColumn('description')
            
            ->addColumn('montant',function(Transaction $model) {
                return '<span class="fw-bold">'.number_format($model->montant, 2, ',', ' ').'</span>';
            })
            ->addColumn('solde',function(Transaction $model) {
                return '<span class="fw-bold">'.number_format($model->solde, 2, ',', ' ').'</span>';
            })
            ->addColumn('date_transaction', fn (Transaction $model) => Carbon::parse($model->date_transaction)->format('d/m/Y'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
      * PowerGrid Columns.
      *
      * @return array<int, Column>
      */
    public function columns(): array
    {
        $colums = [
            // Column::make('Id', 'id'),
            Column::make('Opération', 'operation')->sortable()->searchable(),
            Column::make('Description', 'description')->sortable()->searchable(),
            Column::make('Montant de la transaction', 'montant')->sortable()->searchable(),
            Column::make('Solde', 'solde')->sortable()->searchable(),
            Column::make('Date de la transaction', 'date_transaction')
                ->sortable(),

        ];
        if(Auth::user()->is_admin ){
            $colums[] = Column::make('Saisi par', 'user')->searchable()->sortable();
        }
        
        return $colums;
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
    
        return [
            // Filter::datetimepicker('created_at'),
            // Filter::datetimepicker('nom'),
            // Filter::inputText('nom')->operators(['contains']),
            // Filter::inputText('prenom')->operators(['contains']),
            // Filter::inputText('email')->operators(['contains']),
            // Filter::inputText('telephone')->operators(['contains']),
            // Filter::inputText('adresse')->operators(['contains']),
            // Filter::inputText('code_postal')->operators(['contains']),
            // Filter::inputText('ville')->operators(['contains']),
            // Filter::inputText('pays')->operators(['contains']),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Transaction Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
           
        ];
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Transaction Action Rules.
     *
     * @return array<int, RuleActions>
     */

   
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
        ];
    }
}