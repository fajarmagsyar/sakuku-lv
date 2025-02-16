<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Incomes;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;

class ApiController extends Controller
{
    // Authentication: Register, Login, Logout
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // CRUD for Users
    public function getUsers()
    {
        return response()->json(User::all());
    }

    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->all();

        try {
            $request->validate([
                'name' => 'sometimes|string|max:255|unique:users,name,' . $user->id,
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|min:6',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if ($request->has('password')) {
                $data['password'] = Hash::make($request->input('password'));
            }
            $user->update($data);
            return response()->json($user);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    // CRUD for Categories
    public function getCategories()
    {
        return response()->json(Category::all());
    }

    public function createCategory(Request $request)
    {
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function updateCategory(Request $request, Category $category)
    {
        $category->update($request->all());
        return response()->json($category);
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }

    // CRUD for Income
    public function getIncome()
    {
        return response()->json(Incomes::all());
    }

    public function createIncome(Request $request)
    {
        $income = Incomes::create($request->all());
        return response()->json($income, 201);
    }

    public function updateIncome(Request $request, Incomes $income)
    {
        $income->update($request->all());
        return response()->json($income);
    }

    public function deleteIncome(Incomes $income)
    {
        $income->delete();
        return response()->json(null, 204);
    }

    // CRUD for Expenses
    public function getExpenses()
    {
        return response()->json(Expense::all());
    }

    public function createExpense(Request $request)
    {
        $expense = Expense::create($request->all());
        return response()->json($expense, 201);
    }

    public function updateExpense(Request $request, Expense $expense)
    {
        $expense->update($request->all());
        return response()->json($expense);
    }

    public function deleteExpense(Expense $expense)
    {
        $expense->delete();
        return response()->json(null, 204);
    }

    // CRUD for Transactions
    public function getTransactions()
    {
        return response()->json(Transaction::all());
    }

    public function createTransaction(Request $request)
    {
        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function updateTransaction(Request $request, Transaction $transaction)
    {
        $transaction->update($request->all());
        return response()->json($transaction);
    }

    public function deleteTransaction(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(null, 204);
    }
}
