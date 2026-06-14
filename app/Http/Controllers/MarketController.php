<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

use DB;
use URL;

use App\Models\Page;
use App\Models\Mode;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductLang;
use App\Models\Section;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Category;

class MarketController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '/')->first();
        $categories = Category::where('lang', app()->getLocale())->get()->toTree();
        $products = Product::where('status', '<>', 0)->paginate(27);

        return view('market.index', compact('page', 'categories', 'products'));
    }

    public function search(Request $request)
    {
        $text = trim(strip_tags($request->text));

        $productsLang = ProductLang::where(function($query) use ($text) {
                return $query->where('title', 'LIKE', '%'.$text.'%')
                ->orWhere('description', 'LIKE', '%'.$text.'%');
            })->paginate(27);

        $productsLang->appends([
            'text' => $request->text,
        ]);

        return view('market.found', compact('text', 'productsLang'));
    }

    public function searchAjax(Request $request, $lang)
    {
        $text = trim(strip_tags($request->text));

        $productsLang = ProductLang::when(strlen($text) >= 2, function($query) use ($text) {
                $query->where('title', 'LIKE', '%'.$text.'%')
                ->orWhere('description', 'LIKE', '%'.$text.'%')
                ->take(15);
            }, function($query) {
                $query->take(0);
            })
            ->get();

        return view('market.suggestions-render', ['productsLang' => $productsLang]);
    }

    public function categoryProducts(Request $request, $lang, $categorySlug, $categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        $categories = Category::where('lang', app()->getLocale())->get()->toTree();

        $ids = $category->descendants->where('status', '!=', 0)->pluck('id');
        $ids[] = $categoryId;

        $productsLang = ProductLang::query()
                // ->where('status', '<>', 0)
                ->whereIn('category_id', $ids)
                ->paginate(27);

        return view('market.products-category')->with([
                'categories' => $categories,
                'category' => $category,
                'productsLang' => $productsLang
            ]);
    }

    public function product($lang, $productId, $productSlug)
    {
        $productLang = Productlang::where('slug', $productSlug)->first();
        $productLang->views = $productLang->views + 1;
        $productLang->save();

        $category = Category::where('id', $productLang->category_id)->firstOrFail();
        // $products = Product::search($productLang->title)->where('status', 1)->take(4)->get();

        return view('market.product-detail')->with([
                'productLang' => $productLang,
                'category' => $category,
                // 'products' => $products
            ]);
    }

    public function saveComment(Request $request)
    {
        $this->validate($request, [
            'stars' => 'required|integer|between:1,5',
            'comment' => 'required|min:5|max:500',
        ]);

        $url = explode('/', URL::previous());
        $uri = explode('-', end($url));

        if ($request->id == $uri[0]) {

            $comment = new Comment;
            $comment->parent_id = $request->id;
            $comment->parent_type = 'App\Product';
            $comment->name = \Auth::user()->name;
            $comment->email = \Auth::user()->email;
            $comment->comment = $request->comment;
            $comment->stars = (int) $request->stars;
            $comment->save();

            return redirect()->back()->with('status', 'Отзыв добавлен!');
        }

        return redirect()->back()->with('status', 'Ошибка!');
    }
}
