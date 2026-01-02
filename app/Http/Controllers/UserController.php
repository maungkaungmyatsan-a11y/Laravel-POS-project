<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //direct user home page
    public function home()
    {

        if (request('searchKey')) {

        }
        $products = Product::select('products.id', 'products.name', 'products.price', 'products.image', 'products.description', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
        //when user click category tag
            ->when(request('categoryId'), function ($query) {
                $categoryId = request('categoryId');
                $query->where('products.category_Id', $categoryId);
            })
        //when user search products by name
            ->when(request('searchKey'), function ($query) {
                $key = request('searchKey');
                $query->where('products.name', 'like', '%' . $key . '%');
            })

        //filter by min and max price
            ->when(request('minPrice') || request('maxPrice'), function ($query) {
                $min = request('minPrice');
                $max = request('maxPrice');

                if (request('minPrice')) {
                    $query->where('products.price', '>=', $min);
                }
                if (request('maxPrice')) {
                    $query->where('products.price', '<=', $max);
                }
            })
        //Sort by name, price, date
            ->when(request('sortingType'), function ($query) {
                $sortType = request('sortingType');

                switch ($sortType) {
                    case 'nameAsc':$query->orderBy('products.name', 'asc');break;
                    case 'nameDesc':$query->orderBy('products.name', 'desc');break;
                    case 'priceAsc':$query->orderBy('products.price', 'asc');break;
                    case 'priceDesc':$query->orderBy('products.price', 'desc');break;
                    case 'dateAsc':$query->orderBy('products.created_at', 'asc');break;
                    case 'dateDesc':$query->orderBy('products.created_at', 'desc');break;

                }
            })
            ->orderBy('products.created_at', 'desc')->get();

        $categories = Category::select('id', 'name')->get();

        return view('user.dashboard.home', compact('products', 'categories'));
    }

    //product details
    public function productDetails($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)
            ->first();

        $comments = Comment::select('users.profile', 'comments.product_id', 'comments.id as comment_id', 'comments.user_id', 'users.name', 'comments.message', 'comments.created_at')
            ->leftJoin('users', 'comments.user_id', 'users.id')
            ->where('comments.product_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $rating = Rating::where('product_id', $id)->where('user_id', auth()->user()->id)->value('count');

        $avgRating = Rating::where('product_id', $id)->avg('count');
        $avgRating = number_format($avgRating, 1);

        //  $relatedProducts = Product::select('products.*','categories.name as category_name')
        // ->leftJoin('categories','products.category_id','categories.id')
        // ->get();

        return view('user.product.details', compact('product', 'comments', 'rating', 'avgRating'));

    }

    //comment
    public function comment(Request $request)
    {
        Comment::create([
            'user_id'    => $request->userId,
            'product_id' => $request->productId,
            'message'    => $request->comment,
        ]);

        return back()->with(['success' => 'comment success']);

    }

    public function commentDelete($commentId)
    {
        Comment::where('id', $commentId)->delete();

        return back();
    }

    public function rating(Request $request)
    {
        Rating::updateOrCreate([
            'user_id'    => $request->userId,
            'product_id' => $request->productId],
            [
                'count' => $request->productRating]
        );

        return back()->with(['ratingSuccess' => 'success']);
    }

    public function cart()
    {
        $orderItems = Cart::select('carts.id', 'carts.user_id', 'carts.product_id', 'carts.quantity', 'products.name', 'products.price', 'products.image')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('user.cart.list', compact('orderItems'));

    }

    public function addToCart(Request $request)
    {
        Cart::create([
            'user_id'    => $request->userId,
            'product_id' => $request->productId,
            'quantity'   => $request->count,
        ]);

        return back()->with(['cartSuccess' => 'success']);

    }

    public function deleteCart(Request $request)
    {
        Cart::where('id', $request->deleteCartId)->delete();
        return response()->json([
            "status"  => 200,
            "message" => 'cart delete success',
        ]);
    }

    //temp storage
    public function cartTemp(Request $request)
    {
        Session::put('tempCart', $request->all());
        return response()->json([
            'status'  => 200,
            'message' => 'session store success',
        ]);
    }

    //direct to payment page
    public function paymentPage(Request $request)
    {
        $order = Session::get('tempCart');
        $orderCode = $order[0]['order_code'];
        $total = 5000;
        foreach($order as $item){
            $total += $item['total_price'];
        }

        $paymentAccounts = Payment::orderBy('account_type', 'asc')->get();
        return view('user.cart.payment', compact('paymentAccounts','orderCode','total'));
    }

    public function payment(Request $request)
    {
        $request->validate([
            'name'        => 'required|min:2|max:30',
            'phone'       => 'required|min:10',
            'address'     => 'required|min:5',
            'paymentType' => 'required',
            'payslip_image'       => 'required|file|mimes:png,jpg,jpeg,svg,webp,gif',

        ]);

        $order = Session::get('tempCart');

        $total = 5000;
        foreach($order as $item){
            Order::create($item);
            $total += $item['total_price'];
        }

        $paymentHistoryData = [
            'user_id' => auth()->user()->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $order[0]['order_code'],
            'total_amount' => $total
        ];

        if($request->hasFile('payslip_image')){
            $fileName = uniqid() . $request->file('payslip_image')->getClientOriginalName();
            $request->file('payslip_image')->move(public_path().'/payslipImage/',$fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);
        Cart::where('user_id',auth()->user()->id)->delete(); //clear cart items
        return to_route('user#orderList');

    }

    //order list
    public function orderList(){
        $orderList = Order::select('created_at','status','order_code')
                         ->where('user_id',auth()->user()->id)
                         ->groupBy('order_code')
                         ->orderBy('created_at','desc')
                         ->get();

        return view('user.cart.orderList',compact('orderList'));
    }

}
