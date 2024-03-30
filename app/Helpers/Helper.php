<?php

namespace App\Helpers;

use App\Models\ArticleModel;
use App\Models\BlogModel;
use App\Models\Category;
use App\Models\CategoryModel;
use App\Models\MaterialModel;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\SizeModel;
use App\Models\User;
use App\Models\UsersModel;
use App\Models\VoucherModel;
use App\Models\VoucherTypeModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Cache\RateLimiting\Limit;

class Helper
{

    public static function getNameById($id, $modelType)
    {
        $model = null;

        switch ($modelType) {
            case 'category':
                $model = Category::where('id', $id)->value('name');
                break;

            case 'size':
                $model = SizeModel::where('sizeID', $id)->first();
                $model = $model ? "$model->name | $model->weight | $model->height" : '';
                break;

            case 'material':
                $model = MaterialModel::where('materialID', $id)->value('name');
                break;

            case 'product':
                $model = Product::where('productID', $id)->value('name');
                break;

            case 'users':
                $model = User::where('userID', $id)->value('name');
                break;

            case 'voucher_type':
                $model = VoucherTypeModel::where('voucher_typeID', $id)->value('name');
                break;
        }

        return $model ?? '';
    }
    public static function format_cash($price)
    {
        return str_replace(",", ".", number_format($price)) . 'đ';
    }
    public static function getArticle($id = NULL)
    {
        $data = ArticleModel::where('status', 1)->where('parent_id', 0)->get();
        if (isset($id)) {
            $data = ArticleModel::where('status', 1)->where('id', $id)->first();
        }
        return $data;
    }
    public static function getCategory($id = NULL)
    {
        $data = CategoryModel::where('status', 1)->where('parent_id', 0)->get();
        if (isset($id)) {
            $data = CategoryModel::where('status', 1)->where('id', $id)->first();
        }
        return $data;
    }
}
