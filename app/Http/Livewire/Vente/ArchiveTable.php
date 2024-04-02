<?php

namespace App\Http\Livewire\Vente;

use App\Models\Vente;
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

final class ArchiveTable extends PowerGridComponent
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
     * @return Builder<\App\Models\Vente>
     */
    public function datasource()
    {
      
        $ventes = Vente::where('archive', true)->orderBy('created_at', 'desc')->get();

        return $ventes;

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
            ->addColumn('date_vente', fn (Vente $model) => Carbon::parse($model->date_vente)->format('d/m/Y')  )

            ->addColumn('produit', function (Vente $model) {          
                return  '<span class="badge bg-info text-white font-bold py-1 px-2 fs-6">'.$model?->produit()?->nom.'</span>';
           
            } )
            ->addColumn('prix_total')
            ->addColumn('quantite')
            ->addColumn('unite_mesure', function (Vente $model) {          
                return  '<span class="badge bg-info text-white font-bold py-1 px-2 fs-6">'.$model?->produit()?->unite_mesure.'</span>';
           
            } )
           
            ->addColumn('created_date', function (Vente $model) {          
                return $model->created_at->format('d/m/Y');
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
            Column::make('Date vente', 'date_vente')->searchable()->sortable(),
            Column::make('Produit', 'produit')->searchable()->sortable(),
            Column::make('Prix total', 'prix_total')->searchable()->sortable(),
            Column::make('Quantité', 'quantite')->searchable()->sortable(),
            Column::make('Unité de mesure', 'unite_mesure')->searchable()->sortable(),

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
     * PowerGrid Vente Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
            Button::add('Modifier')
            ->bladeComponent('button-edit-vente-modal', function(Vente $vente) {
                return [
                'tooltip' => "Modifier",
                'vente' => $vente,
                'href' => route('vente.update', Crypt::encrypt($vente->id)),
                'datevente' => $vente->date_vente,
                'permission' => Gate::allows('permission', 'modifier-vente'),
                
                ];
            }),
            
            Button::add('Desarchiver')
            ->bladeComponent('button-unarchive', function(Vente $vente) {
                return ['route' => route('vente.unarchive', Crypt::encrypt($vente->id)),
                'tooltip' => "Désarchiver",
                'details' => "",
                'classunarchive' => "unarchive_vente",
                'permission' => Gate::allows('permission', 'modifier-vente'),
                
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
     * PowerGrid Vente Action Rules.
     *
     * @return array<int, RuleActions>
     */

   
    public function actionRules(): array
    {
       return [
        ];
    }
}