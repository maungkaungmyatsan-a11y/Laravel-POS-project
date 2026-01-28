<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //direct user home page
    public function home()
    {

        if (request('searchKey')) {

        }
        $products = Product::select('products.id', 'products.name', 'products.price', 'products.image', 'products.description', 'categories.name as category_name','product_discounts.discount_amount','product_discounts.discount_value')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('product_discounts','products.id','product_discounts.product_id')

            ->where('products.stock','>',0)
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
        $products = Product::select('products.id', 'products.name', 'products.price', 'products.image', 'products.description', 'categories.name as category_name','product_discounts.discount_amount','product_discounts.discount_value')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('product_discounts','products.id','product_discounts.product_id')
            ->where('products.id', $id)
            ->where('products.stock','>',0)
            ->get();


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

        return view('user.product.details', compact('product', 'comments', 'rating', 'avgRating','products'));

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

    //rating
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
        $orderItems = Cart::select('carts.id', 'carts.user_id', 'carts.product_id', 'carts.quantity', 'products.name', 'products.price', 'products.image','product_discounts.discount_value','product_discounts.discount_type')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->leftJoin('product_discounts','products.id','product_discounts.product_id')
            ->where('carts.user_id', auth()->user()->id)
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
        $order     = Session::get('tempCart');
        $orderCode = $order[0]['order_code'];
        $total     = 5000;
        foreach ($order as $item) {
            $total += $item['total_price'];
        }

        $paymentAccounts = Payment::orderBy('account_type', 'asc')->get();
        return view('user.cart.payment', compact('paymentAccounts', 'orderCode', 'total'));
    }

    public function payment(Request $request)
    {
        $request->validate([
            'name'          => 'required|min:2|max:30',
            'phone'         => 'required|min:10',
            'address'       => 'required|min:5',
            'paymentType'   => 'required',
            'payslip_image' => 'required|file|mimes:png,jpg,jpeg,svg,webp,gif',

        ]);

        $order = Session::get('tempCart');

        $total = 5000;
        foreach ($order as $item) {
            Order::create($item);
            $total += $item['total_price'];
        }

        $paymentHistoryData = [
            'user_id'        => auth()->user()->id,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'payment_method' => $request->paymentType,
            'order_code'     => $order[0]['order_code'],
            'total_amount'   => $total,
        ];

        if ($request->hasFile('payslip_image')) {
            $fileName = uniqid() . $request->file('payslip_image')->getClientOriginalName();
            $request->file('payslip_image')->move(public_path() . '/payslipImage/', $fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);
        Cart::where('user_id', auth()->user()->id)->delete(); //clear cart items
        return to_route('user#orderList');

    }

    //order list
    public function orderList()
    {
        $orderList = Order::select('created_at', 'status', 'order_code')
            ->where('user_id', auth()->user()->id)
            ->groupBy('order_code')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.cart.orderList', compact('orderList'));
    }

    //contact Page
    public function contactPage()
    {
        return view('user.cart.contact');
    }

    //contact
    public function contact(Request $request)
    {
        $request->validate([
            'name'    => 'required|min:2|max:30',
            'phone'   => 'required|min:10',
            'email'   => 'required|email',
            'title'   => 'required|min:2',
            'message' => 'required',
        ]);

        Contact::create([
            'user_id'    => auth()->user()->id,
            'user_name'  => $request->name,
            'phone'      => $request->phone,
            'user_email' => $request->email,
            'title'      => $request->title,
            'message'    => $request->message,
        ]);

        return back()->with(['success' => 'message sent']);

    }

    //profile details
    public function profileDetails()
    {
        return view('user.profile.details');
    }

    //profile Edit
    public function profileEdit()
    {
        return view('user.profile.edit');
    }

    //update
    public function profileUpdate(Request $request, $id)
    {
        $this->validationCheck($request);

        $updateData = $this->getAccountData($request);

        if ($request->hasFile('image')) {
            if (auth()->user()->profile !== null) {
                //oldImage delete
                $oldImage = auth()->user()->profile;
                if (file_exists(public_path('userProfile/' . $oldImage))) {
                    unlink(public_path('userProfile/' . $oldImage));

                }
            }

            //new image upload
            $newImage = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('userProfile/'), $newImage);

            $updateData['profile'] = $newImage;

        }

        User::find($id)->update($updateData);

        return to_route('user#profileDetails');

    }

    //change password page
    public function changePasswordPage()
    {
        return view('user.profile.changePassword');
    }

    //change password process
    public function changePassword(Request $request)
    {
        $dbAccountPassword = auth()->user()->password;

        $this->passwordValidationCheck($request);

        $passwordCheckStatus = Hash::check($request->oldPassword, $dbAccountPassword);

        if ($passwordCheckStatus) {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->newPassword)]);
            return back()->with(['success' => 'password changed successfully']);
        }
        return back()->with(['fail' => 'password change fail. Try again!']);

    }

    //password validation check
    private function passwordValidationCheck($request)
    {
        $request->validate([
            'oldPassword'     => 'required|min:5|max:20',
            'newPassword'     => 'required|min:5|max:20',
            'confirmPassword' => 'required|min:5|max:20|same:newPassword',
        ]);
    }

    private function getAccountData($request)
    {
        return [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,

        ];

    }

    //validation check
    private function validationCheck($request)
    {
        $request->validate([
            'name'    => 'required|min:2|max:30',
            'email'   => 'required|email|min:5|max:40',
            'phone'   => 'required|min:1|max:20',
            'address' => 'required|max:200',

        ]);
    }

}
