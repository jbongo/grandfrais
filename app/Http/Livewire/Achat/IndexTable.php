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
      
            ->addColumn('produit', function (Achat $model) {          
                return  '<span class="text-danger font-bold py-1 px-2 fs-5">'.$model->produit?->nom.'</span>';
            } )
            ->addColumn('quantite', function(Achat $model) {
                return  '<span class="badge bg-info text-white font-bold py-1 px-2 fs-6">'.$model->quantite.'</span>';
            })
       
            ->addColumn('prix_unitaire', function(Achat $model) {
                return  '<span class="font-bold py-1 px-2 fs-6">'.number_format($model->prix_unitaire,0,' ').'</span>';
            })
            ->addColumn('prix_total', function(Achat $model) {
                return  '<span class="font-bold py-1 px-2 fs-6">'.number_format($model->prix_total,0,' ').'</span>';
            })
            ->addColumn('fournisseur', function (Achat $model) { 

                if($model->fournisseur?->nature == 'Personne physique'){
                    return  '<span >'.$model->fournisseur?->individu?->civilite.' '.$model->fournisseur?->individu?->nom.' '.$model->fournisseur?->individu?->prenom.'</span>';
                }else{
                    return  '<span >'.$model->fournisseur?->entite?->raison_sociale.'</span>';
                }
            })
           
 
            ->addColumn('date_achat', function(Achat $model) {
                return  Carbon::parse($model->date_achat)->format('d/m/Y');
            })
            ->addColumn('user', function (Achat $model) {        
                
                $user = User::where('id', $model->user_id)->first();
                $contact = $user?->contact;
                $individu = $contact?->individu;
                
                return  '<span >'.$individu?->nom.' '.$individu?->prenom.'</span>';
            })
            ->addColumn('created_date', function (Achat $model) {          
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
            Column::make('Produit', 'produit')
                ->searchable()
                ->sortable(),
            Column::make('Quantité', 'quantite')->searchable()->sortable(),
            Column::make('Prix unitaire', 'prix_unitaire')->searchable()->sortable(),
            Column::make('Prix total', 'prix_total')->searchable()->sortable(),
            Column::make('Fournisseur', 'fournisseur')->searchable()->sortable(),

        
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
            ->bladeComponent('button-edit-achat-modal', function(Achat $achat) {              
                return ['route' => route('achat.edit', Crypt::encrypt($achat->id)),
                'tooltip' => "Modifier",
                'dateAchat' => $achat->date_achat,
                'produitId' => $achat->produit_id,
                'fournisseurId' => $achat->fournisseur_id,
                'quantite' => $achat->quantite,
                'prixTotal' => $achat->prix_total,

                'achat'=> $achat,                
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