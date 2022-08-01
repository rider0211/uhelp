<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Installer\PermissionsChecker;

class PermissionsController extends Controller
{
     /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @param PermissionsChecker $checker
     */
    public function __construct(PermissionsChecker $checker)
    {
        $this->permissions = $checker;
    }

    public function index(){

        $permissions = $this->permissions->check(
            config('installer.requirements.permissions')
        );

        return view('installer.permissions', compact('permissions'));
    }
}
