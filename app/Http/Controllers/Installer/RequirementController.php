<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Installer\RequirementChecker;

class RequirementController extends Controller
{
    protected $requirements;

    public function __construct(RequirementChecker $checker)
    {
        $this->requirements = $checker;
    }


    public function index(){

        $requirements = $this->requirements->check(
            config('installer.requirements.requirements')
        );

        $phpSupportInfo = $this->requirements->checkPHPversion(
            config('installer.requirements.core.minPhpVersion')
        );

        return view('installer.requirement', compact('requirements', 'phpSupportInfo'));

    }
}
