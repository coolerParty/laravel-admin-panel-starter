<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserComponent extends Component
{

    public function destroy($user_id)
    {
        if (!auth()->user()->can('user-delete', 'admin-access')) {
            abort(404);
        }
        $user = User::find($user_id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('delete-success', 'User has been deleted successfully.');
    }

    public function render()
    {
        if (!auth()->user()->can('user-show')) {
            abort(404);
        }

        $users = User::with('roles')->get();

        return view('livewire.user-component', ['users'=>$users])->layout('layouts.base');
    }
}
