<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{User, UserDetail, Address};
use Spatie\Permission\Models\{Permission, Role};
use Illuminate\Support\Facades\{DB, Hash, Storage,Log};

/**
 * Class UserController
 *
 * This controller manages user administration in the admin panel.
 */
class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Administrator');
            })->get();

            // dd($users);
            return view('admin.users.user_list', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $roles = Role::get();
            $permissions = Permission::get();

            return view('admin.users.create', compact('roles', 'permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at '=> now(),
                'password' => Hash::make($request->password),
                'encrypt_password' => jsencode_userdata($request->password),
                'status' => 'ACTIVE',
            ]);

            $role = Role::findOrFail($request->input('role'));
            $permissions = $request->permissions;
            $user->assignRole($role);
            $user->givePermissionTo($permissions);

            // if ($request->hasFile('profile_picture')) {
            //     $profilePicPath = $request->file('profile_picture')->store('profile_pictures', 'public');
            //     $userDetailsData['profile_pic_path'] = $profilePicPath;
            // }
            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'User creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::all();
            return view('admin.users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $this->validateUserData($request, $id);

        try {
            DB::beginTransaction();

            $this->updateUser($user, $validatedData);
            $this->syncUserRole($user, $request->input('role'));

            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('User update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $id,
            ]);

            return redirect()->back()->with('error', 'User update failed. Check logs for details,'.$e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display a listing of sub-admin users.
     *
     * @return \Illuminate\View\View
     */
    public function subAdmin()
    {
        try {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'sub-admin');
            })->get();
            return view('admin.subadmin.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the profile picture of the specified user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function removeProfilePic(User $user)
    {
        try {
            if ($user->user_detail->profile_pic_path) {
                Storage::delete($user->user_detail->profile_pic_path);
                $user->user_detail->update(['profile_pic_path' => null]);
            }
            return response()->json(['message' => 'Profile picture removed successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the status of the specified user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, User $user)
    {
        try {
            $status = $request->input('status');
            $user->update(['status' => $status]);
            return response()->json(['status' => $status, 'message' => 'User status updated successfully.']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Validate user data.
     */
    private function validateUserData(Request $request, $id): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'encrypt_password' => 'nullable|string',

        ]);
    }

    /**
     * Update the user model.
     * @param App\Models\User $user
     * @param array $validatedData
     * @return null
     */
    private function updateUser(User $user, array $validatedData): void
    {
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
            'encrypt_password' => isset($validatedData['password']) ? jsencode_userdata($validatedData['password']) : $user->encrypt_password,
        ]);
    }

    /**
     * Update user details (profile picture, about me, phone number).
     * @param App\Models\User $user
     * @param Request $request
     * @return void
     */
    private function updateUserDetails(User $user, Request $request): void
    {
        $userDetailsData = [
            'about_me' => $request->input('about_me'),
            'phone_number' => $request->input('phone_number'),
        ];

        if ($request->hasFile('profile_pic')) {
            $profilePicPath = $request->file('profile_pic')->store('profile_pictures', 'public');
            $userDetailsData['profile_pic_path'] = $profilePicPath;
        }

        UserDetail::updateOrCreate(['user_id' => $user->id], $userDetailsData);
    }

    /**
     * Update user address.
     * @param App\Models\User $user
     * @param Request $request
     * @return void
     */
    private function updateUserAddress(User $user, Request $request): void
    {
        Address::updateOrCreate(
            ['user_id' => $user->id],
            $this->setAddressData($request)
        );
    }

    /**
     * Sync user role.
     * @param App\Models\User $user
     * @param App\Models\User $roleId
     * @return null
     */
    private function syncUserRole(User $user, $roleId): void
    {
        $role = Role::findOrFail($roleId);
        $user->syncRoles([$role->name]);
    }

    /**
     * getting the request data in to array
     *
     * @param Request $request
     * @param User $user
     * @return array $addressData
     */
    private function setAddressData($request): array
    {
        try {
            $addressData = [
            'address' => $request->input('address'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'pincode' => $request->input('pincode'),
            ];
            return $addressData;
        } catch (\Throwable $th) {
            throw new \Exception("Error in getting data from request".$th->getMessage());
        }
    }
}
