<?php

namespace App\Http\Livewire\Achat;


use App\Models\Achat;
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
     * @return Builder<\App\Models\Contact>
     */
    public function datasource()
    {
      
        $achats = Achat::where('archive', false)->orderBy('created_at', 'desc')->get();

        return $achats;

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
      
            ->addColumn('numero', function (Achat $model) {          
                return  '<span class="badge bg-info text-white font-bold py-1 px-2 fs-6">'.$model->numero.'</span>';
           
            } )
            ->addColumn('nom')
            ->addColumn('montant_ttc')
            ->addColumn('client', function (Achat $model) { 
                if($model->client()?->type == 'individu'){
                    return  '<span >'.$model->client()?->individu?->civilite.' '.$model->client()?->individu?->nom.' '.$model->client()?->individu?->prenom.'</span>';
                }else{
                    return  '<span >'.$model->client()?->entite?->raison_sociale.'</span>';
                }
            })
           
            ->addColumn('notes')
            ->addColumn('date_achat', fn (Achat $model) =>  $model->date_achat  )
            ->addColumn('user', function (Achat $model) {        
                
                $user = User::where('id', $model->user_id)->first();
                $contact = $user?->contact;
                $individu = $contact?->individu;
                
                return  '<span >'.$individu?->nom.' '.$individu?->prenom.'</span>';
            })
            ->addColumn('created_date', function (Achat $model) {          
                return $model->created_at->format('d-m-Y');
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
            Column::make('Numero', 'numero')
                ->searchable()
                ->sortable(),
            Column::make('Nom', 'nom')->searchable()->sortable(),
            Column::make('Montant', 'montant_ttc')->searchable()->sortable(),
            Column::make('Client', 'client')->searchable()->sortable(),
            Column::make('Notes', 'notes')->searchable()->sortable(),
            Column::make('Date achat', 'date_achat')->searchable()->sortable(),  
            // Column::make('Statut', 'statut')->searchable()->sortable(),
            Column::make('Date d\'ajout', 'created_date')->searchable()->sortable(),
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
            ->bladeComponent('button-edit', function(Achat $achat) {
                return ['route' => route('achat.edit', Crypt::encrypt($achat->id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-contact'),
                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Achat $achat) {
                return ['route' => route('achat.archive', Crypt::encrypt($achat->id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_achat",
                'permission' => Gate::allows('permission', 'modifier-contact'),
                
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