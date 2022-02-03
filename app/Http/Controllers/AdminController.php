<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->save();

        return redirect()->route('admin.index')->with('success', 'Added a new user successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            return view('admin.show', compact('user'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->id != $id) {
            return redirect()->route('admin.show', $id)->with('warning', "You are viewing other profile. Please take caution in updating!");
        } else {
            return redirect()->route('admin.show', $id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('warning', 'User not found. Please try again.');
        } else {
            Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,id,' . $user->id],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,' . $user->id],
            ])->validate();

            $user->update([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
            ]);

            return redirect()->route('admin.index')->with('success', 'User profile has been updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id);

        if ($user) {
            $user->delete();
            return redirect()->route('admin.index')->with('success', 'User has been removed successfully.');
        } else {
            return redirect()->back()->with('warning', 'User not found. Please try again.');
        }
    }

    public function showDeletedUsers()
    {
        $users = User::onlyTrashed()->get();
        $count = $users->count();

        return view('admin.deleted-users', [
            'users' => $users,
            'count' => $count,
        ]);
    }
}
