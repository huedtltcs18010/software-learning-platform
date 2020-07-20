<?php

namespace App\Http\Controllers\Admin;

use App\Eloquent\Category;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends BaseController
{
    const ITEMS_PER_PAGE = 20;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->setBreadcrumb();
        $breadcrumb = $this->breadcrumb;

        $categories = DB::table('categories')
            ->select('id', 'name', 'status')
            ->orderBy('name', 'ASC')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(self::ITEMS_PER_PAGE);

        return view('admin.categories.index', compact('breadcrumb', 'categories'));
    }

    public function create()
    {
        $this->setBreadcrumb('create');
        $breadcrumb = $this->breadcrumb;

        $category = new Category();
        $category->status = 1;

        return view('admin.categories.create', compact('breadcrumb', 'category'));
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());

        $data = $this->getInputData($request);
        $data['created_by'] = Auth::id();

        Category::create($data);
        return redirect(route('admin.categories.index'))->with('success_message', 'Successfully created new category!');
    }

    public function edit(Request $request, int $id)
    {
        $this->setBreadcrumb('create');
        $breadcrumb = $this->breadcrumb;

        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('breadcrumb', 'category'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate($this->getValidationRules());

        $data = $this->getInputData($request);
        $data['updated_by'] = Auth::id();

        $category = Category::findOrFail($id);
        $category->fill($data);
        $category->save();

        return redirect(route('admin.categories.index'))->with('success_message', 'Successfully updated a category!');
    }

    public function destroy(Request $request, int $id)
    {
        Category::destroy($id);
        return redirect(route('admin.categories.index'))->with('success_message', 'Successfully deleted a category!');
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
        $this->breadcrumb[] = ['label' => 'Categories', 'url' => route('admin.categories.index')];
        switch ($method) {
            case 'create':
                $this->breadcrumb[] = ['label' => 'Add new category', 'url' => route('admin.categories.create')];
                break;
            default:
                break;
        }
    }
}
