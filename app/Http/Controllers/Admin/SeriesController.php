<?php

namespace App\Http\Controllers\Admin;

use App\Eloquent\Series;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeriesController extends BaseController
{
    const ITEMS_PER_PAGE = 20;

    public function __construct()
    {
        parent::__construct();
    }

    public function search(Request $request)
    {
        $data = $request->all();
        $res = [
            'total' => 0,
            'items' => [],
        ];
        if (isset($data['k'])) {
            $k = trim(strip_tags($data['k']));
            $query = DB::table('series')
                ->where('name', 'LIKE', '%' . $k . '%');
            $res['total'] = $query->count();
            $items = $query->limit(50)
                ->pluck('name', 'id');
            foreach ($items as $id => $name) {
                $res['items'][] = [
                    'id' => $id,
                    'name' => $name,
                ];
            }
        }
        return response()->json($res);
    }

    public function index()
    {
        $this->setBreadcrumb();
        $breadcrumb = $this->breadcrumb;

        $series = DB::table('series')
            ->select('id', 'name', 'status')
            ->orderBy('name', 'ASC')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(self::ITEMS_PER_PAGE);

        return view('admin.series.index', compact('breadcrumb', 'series'));
    }

    public function create()
    {
        $this->setBreadcrumb('create');
        $breadcrumb = $this->breadcrumb;

        $series = new Series();
        $series->status = 1;

        return view('admin.series.create', compact('breadcrumb', 'series'));
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        $data = $this->getInputData($request);
        $data['created_by'] = Auth::id();

        Series::create($data);
        return redirect(route('admin.series.index'))->with('success_message', 'Successfully created new series!');
    }

    public function edit(Request $request, int $id)
    {
        $this->setBreadcrumb('create');
        $breadcrumb = $this->breadcrumb;

        $series = Series::findOrFail($id);

        return view('admin.series.edit', compact('breadcrumb', 'series'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate($this->getValidationRules());
        $data = $this->getInputData($request);
        $data['updated_by'] = Auth::id();

        $series = Series::findOrFail($id);
        $series->fill($data);
        $series->save();

        return redirect(route('admin.series.index'))->with('success_message', 'Successfully updated a series!');
    }

    public function destroy(Request $request, int $id)
    {
        Series::destroy($id);
        return redirect(route('admin.series.index'))->with('success_message', 'Successfully deleted a series!');
    }

    private function getValidationRules(): array
    {
        return [
            'name' => 'required|min:3|max:100',
            'status' => 'required|integer',
        ];
    }

    private function getInputData($request): array
    {
        $input = $request->all();
        $name = trim(strip_tags($input['name']));
        return [
            'name' => $name,
            'slug' => (new Slugify())->slugify($name),
            'description' => isset($input['description']) ? $input['description'] : '',
            'status' => intval($input['status']),
        ];
    }

    private function setBreadcrumb(string $method = 'index')
    {
        $this->breadcrumb[] = ['label' => 'Series', 'url' => route('admin.series.index')];
        switch ($method) {
            case 'create':
                $this->breadcrumb[] = ['label' => 'Add new series', 'url' => route('admin.series.create')];
                break;
            default:
                break;
        }
    }
}
