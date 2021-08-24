<?php

namespace App\Widgets\Sidebar;

use App\Repositories\Catalog\CatalogProductTablesRepository;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;

class ListProductWidget extends AbstractWidget
{
    protected $companyId;
    protected $catalogProductTablesRepository;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->companyId = Auth::user()->company()->first()->id;
        $this->catalogProductTablesRepository = new CatalogProductTablesRepository();
    }

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $tablesProduct = $this->catalogProductTablesRepository->getTablesProductFromCompanyId($this->companyId);

        $productsName = [];
        foreach ($tablesProduct as $table) {

            $productsName[] = mb_substr($table, strpos($table, '_', 0) + 1);
        }

        if (count($productsName) == 0) {
            $productsName[] = 'NULL';
        }

        return view('admin_panel.widgets.sidebar.listProductWidget', compact('productsName'));
    }
}
