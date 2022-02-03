<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productCategories = Product::select('category', DB::raw('COUNT(id) as count'))->groupBy('category')->orderBy('count', 'DESC')->get();
        $productCount = Product::count();
        $productCountToday = Product::whereDate('created_at', Carbon::now())->count();

        return view('home', compact('productCategories', 'productCount', 'productCountToday'));
    }

    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['sometimes', 'max:50', 'unique:users,id,' . Auth::user()->id],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ])->validate();

        $user = Auth::user();
        $user->name = $data['name'];

        if (!$user->username) {
            $user->username = $data['username'];
        }

        if ($data['password']) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Your profile has been updated successfully.');
    }

    public function chartUpdateProductCategories(Request $request)
    {
        $data = $request->all();

        $response = [];

        $chartLabels = [];
        $chartDatasets = [];

        switch ($data['range']) {
            case 'last-7-days':
                $productCategoriesCollection = Product::select('id', 'category', 'created_at', DB::raw('COUNT(id) as count'))
                    ->groupBy('category')
                    ->groupBy('created_at')
                    ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
                    ->get();

                $period = new DatePeriod(
                    new DateTime(Carbon::now()->subDays(7)->format('Y-m-d')),
                    new DateInterval('P1D'),
                    new DateTime(Carbon::now()->format('Y-m-d'))
                );

                // initialize the labels
                foreach ($period as $value) {
                    $chartLabels[] = $value->format('M. d, Y');
                }

                foreach ($productCategoriesCollection as $productCategory) {
                    if (!isset($response[$productCategory->category])) {
                        $response[$productCategory->category] = [];
                    }

                    if (!$response[$productCategory->category]) {
                        // initialize first the 0s
                        foreach ($period as $key => $value) {
                            $response[$productCategory->category][$value->format('Y-m-d')] = 0;
                        }
                    }

                    $date = Carbon::parse($productCategory->created_at)->format('Y-m-d');
                    $response[$productCategory->category][$date] = $productCategory->count;
                }

                break;
            case 'last-2-weeks':
                $productCategoriesCollection = Product::select('id', 'category', 'created_at', DB::raw('COUNT(id) as count'))
                    ->groupBy('category', 'created_at')
                    ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()])
                    ->get();

                $period = new DatePeriod(
                    new DateTime(Carbon::now()->subDays(14)->format('Y-m-d')),
                    new DateInterval('P1D'),
                    new DateTime(Carbon::now()->format('Y-m-d'))
                );

                // initialize the labels
                foreach ($period as $value) {
                    $chartLabels[] = $value->format('M. d, Y');
                }

                foreach ($productCategoriesCollection as $productCategory) {
                    if (!isset($response[$productCategory->category])) {
                        $response[$productCategory->category] = [];
                    }

                    if (!$response[$productCategory->category]) {
                        // initialize first the 0s
                        foreach ($period as $key => $value) {
                            $response[$productCategory->category][$value->format('Y-m-d')] = 0;
                        }
                    }

                    $date = Carbon::parse($productCategory->created_at)->format('Y-m-d');
                    $response[$productCategory->category][$date] = $productCategory->count;
                }

                break;
            case 'last-6-months':
                $productCategoriesCollection = Product::select('id', 'category', 'created_at', DB::raw('COUNT(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->groupBy('category', 'year', 'month')
                    ->whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()])
                    ->get();

                $period = new DatePeriod(
                    new DateTime(Carbon::now()->subMonths(6)->format('Y-m-d')),
                    new DateInterval('P1M'),
                    new DateTime(Carbon::now()->format('Y-m-d'))
                );

                // initialize the labels
                foreach ($period as $value) {
                    $chartLabels[] = $value->format('M. Y');
                }

                foreach ($productCategoriesCollection as $productCategory) {
                    if (!isset($response[$productCategory->category])) {
                        $response[$productCategory->category] = [];
                    }

                    if (!$response[$productCategory->category]) {
                        // initialize first the 0s
                        foreach ($period as $key => $value) {
                            $response[$productCategory->category][$value->format('Y-m')] = 0;
                        }
                    }

                    $date = Carbon::parse($productCategory->new_date)->format('Y-m');
                    $response[$productCategory->category][$date] = $productCategory->count;
                }

                break;
            case 'last-1-year':
                $productCategoriesCollection = Product::select('id', 'category', 'created_at', DB::raw('COUNT(id) as count'), DB::raw("DATE_FORMAT(created_at, '%Y-%m') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->groupBy('category', 'year', 'month')
                    ->whereBetween('created_at', [Carbon::now()->subYear(1), Carbon::now()])
                    ->get();

                $period = new DatePeriod(
                    new DateTime(Carbon::now()->subYear(1)->format('Y-m-d')),
                    new DateInterval('P1M'),
                    new DateTime(Carbon::now()->format('Y-m-d'))
                );

                // initialize the labels
                foreach ($period as $value) {
                    $chartLabels[] = $value->format('M. Y');
                }

                foreach ($productCategoriesCollection as $productCategory) {
                    if (!isset($response[$productCategory->category])) {
                        $response[$productCategory->category] = [];
                    }

                    if (!$response[$productCategory->category]) {
                        // initialize first the 0s
                        foreach ($period as $key => $value) {
                            $response[$productCategory->category][$value->format('Y-m')] = 0;
                        }
                    }

                    $date = Carbon::parse($productCategory->new_date)->format('Y-m');
                    $response[$productCategory->category][$date] = $productCategory->count;
                }

                break;
            default:
                $response = [];
        }

        $index = 0;
        $colors = ['#33691E', '#1A237E', '#B71C1C', '#FFD600', '#6D4C41', '#00B8D4', '#512DA8'];

        foreach ($response as $category => $records) {
            $chartDatasets[] = [
                'data' => array_values($records),
                'label' => $category,
                'borderColor' => $colors[$index],
                'fill' => true,
            ];

            $index++;
        }

        return response()->json([
            'labels' => $chartLabels,
            'datasets' => $chartDatasets,
        ]);
    }
}
