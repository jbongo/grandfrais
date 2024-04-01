<?php

namespace App\Http\Livewire\Client;
use App\Models\Contact;
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
    use WithExport;
    public $contacts;
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
    
        $contacts = Contact::where('archive', true)->get();
 
        
        return $contacts;

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
          
            ->addColumn('type', function (Contact $model) {
                
                $btn = "";
                $type = $model->type;

                if($type == "Prospect"){
                    $color = "btn-secondary ";
                }elseif($type == "Client"){
                    $color = "btn-info";                
                }elseif($type == "Fournisseur"){
                    $color = "btn-warning";                
                }
                elseif($type == "Collaborateur"){
                    $color = "btn-danger";                
                }
                else{
                    $color = "btn-primary ";                
                }
                
                $btn.='<div class="badge btn '.$color.' btn-sm font-11 mt-2">'.$type.'</div>';
                    
             
                
                return $btn;
            } )
            ->addColumn('nom')
            ->addColumn('prenom')
            ->addColumn('email',fn (Contact $model) => $model->email)
            ->addColumn('telephone_1', function(Contact $model) {
                return  '<span >'.$model->indicatif_1.' '.$model->telephone_1.'</span>';
            })
            ->addColumn('telephone_2', function(Contact $model) {
                return  '<span >'.$model->indicatif_2.' '.$model->telephone_2.'</span>';
            })
            ->addColumn('entreprise')
            ->addColumn('notes')
            ->addColumn('ville')
            ->addColumn('quartier')
            ->addColumn('user', function (Contact $model) {          
                return  '<span >'.$model->user?->contact?->nom.' '.$model->user?->contact?->prenom.'</span>';
            })
            ->addColumn('created_at_formatted', fn (Contact $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
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
            Column::make('Type', 'type')->sortable()->searchable(),            
            Column::make('Nom', 'nom')->sortable()->searchable(),
            Column::make('Prénom', 'prenom')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Téléphone 1', 'telephone_1')->sortable()->searchable(),
            Column::make('Téléphone 2', 'telephone_2')->sortable()->searchable(),
            Column::make('Entreprise', 'entreprise')->sortable()->searchable(),
            Column::make('Notes', 'notes')->sortable()->searchable(),
            Column::make('Ville', 'ville')->sortable()->searchable(),
            Column::make('Quartier', 'quartier')->sortable()->searchable(),
            Column::make('Date de création', 'created_at_formatted', 'created_at')
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
                     
            
            Button::add('Afficher')
                ->bladeComponent('button-show', function(Contact $contact) {
                    return ['route' => route('contact.show', Crypt::encrypt($contact->id)),
                    'tooltip' => "Afficher",
                    'permission' => Gate::allows('permission', 'afficher-tous-les-contacts'),
                    ];
                }),

            Button::add('Restaurer')
            ->bladeComponent('button-unarchive', function(Contact $contact) {
                return ['route' => route('contact.unarchive', Crypt::encrypt($contact->id)),
                'tooltip' => "Restaurer",
                'classunarchive' => "unarchive_contact",
                'permission' => Gate::allows('permission', 'archiver-tous-les-contacts'),
                
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

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($contact) => $contact->id === 1)
                ->hide(),
        ];
    }
}