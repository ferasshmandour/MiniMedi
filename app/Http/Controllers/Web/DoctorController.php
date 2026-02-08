<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\DoctorStoreRequest;
use App\Services\DoctorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * List all doctors (Admin)
     */
    public function index()
    {
        $doctors = $this->doctorService->getAllDoctors();
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show create doctor form (Admin)
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store new doctor (Admin)
     */
    public function store(DoctorStoreRequest $request)
    {
        return $this->doctorService->store($request->validated());
    }

    /**
     * Show doctor details (Admin)
     */
    public function show($id)
    {
        $doctor = \App\Models\User::where('role', 'doctor')->with('doctor')->findOrFail($id);
        $roles = Role::all();
        return view('admin.doctors.show', compact('doctor', 'roles'));
    }

    /**
     * Assign role to doctor using Spatie
     */
    public function assignRole(Request $request, $doctorId): RedirectResponse
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $doctor = \App\Models\User::where('role', 'doctor')->findOrFail($doctorId);
        $role = Role::findOrFail($request->role_id);

        $doctor->assignRole($role);

        return redirect()->back()->with('success', 'Role assigned successfully!');
    }

    /**
     * Unassign role from doctor using Spatie
     */
    public function unassignRole(Request $request, $doctorId): RedirectResponse
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $doctor = \App\Models\User::where('role', 'doctor')->findOrFail($doctorId);
        $role = Role::findOrFail($request->role_id);

        $doctor->removeRole($role);

        return redirect()->back()->with('success', 'Role unassigned successfully!');
    }

    /**
     * Manage doctor roles page (Admin)
     */
    public function manageRoles()
    {
        $doctors = $this->doctorService->getAllDoctors();
        $roles = Role::all();
        return view('admin.doctors.roles', compact('doctors', 'roles'));
    }
}
