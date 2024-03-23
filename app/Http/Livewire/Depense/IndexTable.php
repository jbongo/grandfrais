<?php

namespace App\Http\Livewire\Depense;


use App\Models\Depense;
use App\Models\User;
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
    use ActionButton;
    use WithExport;
    public $client_id;
    public string $sortField = 'created_at';
    
    public string $sortDirection = 'desc';
    /*
    |-------------------------------------------------------------------------

    
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
     * @return Builder<\App\Models\Contact>
     */
    public function datasource()
    {
      
        $depenses = Depense::where('archive', false)->orderBy('created_at', 'desc')->get();

        return $depenses;

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
      
            ->addColumn('typedepense_id', function (Depense $model) {          
                return  '<span class="badge bg-info text-white font-bold py-1 px-2 fs-6">'.$model->typedepense->type.'</span>';
           
            } )
            ->addColumn('details')
            ->addColumn('montant', function (Depense $model) {          
                return  '<span >'.number_format($model->montant, 0, ",", " ").'</span>';
            } )
     
            ->addColumn('date_depense', fn (Depense $model) =>  $model->date_depense  )
            ->addColumn('user', function (Depense $model) {        
                
                $user = User::where('id', $model->user_id)->first();
                $contact = $user?->contact;
                $individu = $contact?->individu;
                
                return  '<span >'.$individu?->nom.' '.$individu?->prenom.'</span>';
            });
          
            // ->addColumn('statut');
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
        $colums =  [
            // Column::make('Id', 'id'),
            Column::make('Type de dépense', 'typedepense_id')
                ->searchable()
                ->sortable(),
            Column::make('Détails', 'details')->searchable()->sortable(),
            Column::make('Montant', 'montant')->searchable()->sortable(),
            Column::make('Date depense', 'date_depense')->searchable()->sortable(),  
            // Column::make('Statut', 'statut')->searchable()->sortable(),

            // Column::make('Actions')

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
     * PowerGrid Contact Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('Modifier')
            ->bladeComponent('button-edit-depense-modal', function(Depense $depense) {
                return ['route' => route('depense.update', Crypt::encrypt($depense->id)),
                'tooltip' => "Modifier",
                'typedepenseid' => $depense->typedepense_id,
                'datedepense' => $depense->date_depense,
                'details' => $depense->details,
                'montant' => $depense->montant,
                'href' => route('depense.update', Crypt::encrypt($depense->id)),
                'permission' => Gate::allows('permission', 'modifier-depense'),
                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Depense $depense) {
                return ['route' => route('depense.archive', Crypt::encrypt($depense->id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_depense",
                'permission' => Gate::allows('permission', 'modifier-depense'),
                
                ];
            }),
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
     * PowerGrid Contact Action Rules.
     *
     * @return array<int, RuleActions>
     */

   
    public function actionRules(): array
    {
       return [
        ];
    }
}