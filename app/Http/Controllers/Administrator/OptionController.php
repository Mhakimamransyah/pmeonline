<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Requests\CreateItemOptionRequest;
use App\Http\Requests\CreateOptionRequest;
use App\Http\Requests\ShowOptionRequest;
use App\ItemOption;
use App\Option;
use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'administrator']);
    }

    public function index()
    {
        return view('administrator.option.index', [
            'options' => Option::all()
        ]);
    }

    public function create(CreateOptionRequest $request)
    {
        $option = (new Option)
            ->fill($request->all());
        $option->setTableName(Str::slug($option->getTitle(), '_'));
        $option->save();
        $this->createOptionTable($option);
        return redirect()->back()->with(['success' => __('Daftar pilihan ' . $option->getTitle() . ' berhasil dibuat.')]);
    }

    private function createOptionTable(Option $option)
    {
        if (!Schema::hasTable($option->getTableName())) {
            Schema::create($option->getTableName(), function (Blueprint $table) {
                $table->increments('id');
                $table->string('value');
                $table->string('text');

                $optCount = 10;
                for ($optCurrent = 1; $optCurrent <= $optCount; $optCurrent++) {
                    $table->string('opt_'.$optCurrent)->nullable();
                }

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function show(ShowOptionRequest $request)
    {
        $option = $request->getOption();
        $tableName = $option->getTableName();
        if (!Schema::hasTable($tableName)) {
            return redirect()->back()->withErrors(['Tabel ' . $tableName . ' tidak ditemukan.']);
        }
        $items = (new ItemOption)
            ->setTable($tableName)
            ->get();
        return view('administrator.option.show', [
            'option' => $option,
            'items' => $items,
        ]);
    }

    public function createItem(CreateItemOptionRequest $request)
    {
        $item = $request->getItemOption()
            ->fill($request->except(['table_name']));
        $item->save();
        return redirect()->back()->with(['success' => 'Item ' . $item->getText() . ' berhasil ditambahkan.']);
    }

    public function showTableItem(Request $request)
    {
        $item = DB::table($request->get('table'))->where('id', '=', $request->query('id'))->get();
        return view('administrator.option.tableitem.show', ['item' => $item->first()]);
    }

    public function updateTableItem(Request $request)
    {
        DB::beginTransaction();
        DB::table($request->get('table'))->where('id', '=', $request->get('id'))->update($request->except('_token', 'table', 'id', 'table_id'));
        DB::commit();
        return redirect()->route('administrator.option.show', ['id' => $request->get('table_id')]);
    }

    public function delete(Option $option)
    {
        Schema::dropIfExists($option->table_name);
        $option->delete();
        return redirect()->route('administrator.option.index')->with(['success' => 'Daftar pilihan '.$option->title.' berhasil dihapus']);
    }
}
