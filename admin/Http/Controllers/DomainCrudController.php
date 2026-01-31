<?php

namespace Admin\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Admin\Http\Requests\DomainRequest;

class DomainCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Domain::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/domain');
        CRUD::setEntityNameStrings('домен', 'домены');
    }

    /**
     * Define what happens when the List operation is loaded.
     */
    protected function setupListOperation()
    {
        CRUD::column('url')->label('Домен');
        CRUD::column('user.name')->label('Пользователь'); // ← показывает имя юзера
        CRUD::column('interval_minutes')->label('Интервал (мин)');
        CRUD::column('timeout_seconds')->label('Таймаут (сек)');
        CRUD::column('method')->label('Метод');
        CRUD::column('last_checked_at')->label('Последняя проверка');
        CRUD::column('active')->type('boolean')->label('Активный');
    }

    /**
     * Define what happens when the Create/Update operation is loaded.
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DomainRequest::class);

        CRUD::field('user_id')
            ->label('Пользователь')
            ->type('select')
            ->entity('user')
            ->attribute('name')
            ->placeholder('Выберите пользователя')
            ->allows_null(false);


        CRUD::field('url')
            ->type('text')
            ->label('Домен (с https://)');

        CRUD::field('interval_minutes')
            ->type('number')
            ->label('Интервал проверки (мин)')
            ->attributes(['min' => 1, 'max' => 1440]);

        CRUD::field('timeout_seconds')
            ->type('number')
            ->label('Таймаут запроса (сек)')
            ->attributes(['min' => 1, 'max' => 60]);

        CRUD::field('method')
            ->type('select_from_array')
            ->label('Метод проверки')
            ->options(['GET' => 'GET', 'HEAD' => 'HEAD'])
            ->allows_null(false);

        CRUD::field('active')
            ->type('checkbox')
            ->label('Активный')
            ->default(true);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
