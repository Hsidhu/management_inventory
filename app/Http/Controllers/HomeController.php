<?php

namespace App\Http\Controllers;
use App\Sale;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\ReceivedProduct;
use App\Receipt;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $monthlyBalanceByMethod = $this->getMonthlyBalance()->get('monthlyBalanceByMethod');
        $monthlyBalance = $this->getMonthlyBalance()->get('monthlyBalance');
        
        return view('dashboard', [
            'anualProductsUsage'        => $this->getAnnualProductsUsage(),
            'anualProductsReceived'     => $this->getAnnualReceived(),
            'anualOrders'               => $this->getAnnualOrders(),
            'monthlybalance'            => $monthlyBalance,
            'monthlybalancebymethod'    => $monthlyBalanceByMethod,
            'lasttransactions'          => Transaction::latest()->limit(20)->get(),
            'unfinishedsales'           => Sale::where('finalized_at', null)->get(),
            'lastmonths'                => array_reverse($this->getMonthlyTransactions()->get('lastmonths')),
            'lastincomes'               => $this->getMonthlyTransactions()->get('lastincomes'),
            'lastexpenses'              => $this->getMonthlyTransactions()->get('lastexpenses'),
            'semesterexpenses'          => $this->getMonthlyTransactions()->get('semesterexpenses'),
            'semesterincomes'           => $this->getMonthlyTransactions()->get('semesterincomes')
        ]);
    }

    public function getMonthlyBalance()
    {
        $methods = ['item_sold'=> 'Qty used', 'item_received' => 'Qty received'];
        $monthlyBalanceByMethod = [];
        $monthlyBalance = 0;

        foreach ($methods as $key => $method) {
            $balance = Transaction::where('type', $key)->thisMonth()->sum('qty');
            $monthlyBalance += (float) $balance;
            $monthlyBalanceByMethod[$method] = $balance;
        }
        return collect(compact('monthlyBalanceByMethod', 'monthlyBalance'));
    }

    public function getAnnualProductsUsage()
    {
        $products = [];
        foreach(range(1, 12) as $i) { 
            $monthproducts = SoldProduct::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->sum('qty');

            array_push($products, $monthproducts);
        }        
        return "[" . implode(',', $products) . "]";
    }

    public function getAnnualReceived()
    {
        $sales = [];
        foreach(range(1, 12) as $i) {
            $monthlySalesCount = ReceivedProduct::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->sum('stock');

            array_push($sales, $monthlySalesCount);
        }
        return "[" . implode(',', $sales) . "]";
    }

    public function getAnnualOrders()
    {
        $products = [];
        foreach(range(1, 12) as $i) { 
            $monthproducts = Receipt::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->count();

            array_push($products, $monthproducts);
        }
        return "[" . implode(',', $products) . "]";
    }

    public function getMonthlyTransactions()
    {
        $actualmonth = Carbon::now();

        $lastmonths = [];
        $lastincomes = '';
        $lastexpenses = '';
        $semesterincomes = 0;
        $semesterexpenses = 0;

        foreach (range(1, 6) as $i) {
            array_push($lastmonths, $actualmonth->shortMonthName);

            // product sold
            $incomes = Transaction::where('type', 'item_sold')
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('qty');

            $semesterincomes += $incomes;
            $lastincomes = round($incomes).','.$lastincomes;

            // product purshased
            $expenses = abs(Transaction::whereIn('type', ['item_received'])
                ->whereYear('created_at', $actualmonth->year)
                ->whereMonth('created_at', $actualmonth->month)
                ->sum('qty'));
            
            // amount spend to buy products
            $semesterexpenses += abs(ReceivedProduct::whereYear('created_at', $actualmonth->year)
                ->whereMonth('created_at', $actualmonth->month)
                ->sum('price'));
            
            $lastexpenses = round($expenses).','.$lastexpenses;

            $actualmonth->subMonth(1);
        }

        $lastincomes = '['.$lastincomes.']';
        $lastexpenses = '['.$lastexpenses.']';

        return collect(compact('lastmonths', 'lastincomes', 'lastexpenses', 'semesterincomes', 'semesterexpenses'));
    }
}
