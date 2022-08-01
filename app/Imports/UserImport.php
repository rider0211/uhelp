<?php

namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Hash;
use Throwable;

class UserImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         $user = new User([
            'firstname'     => $row['Firstname'],
            'lastname'     => $row['Lastname'],
            'name'     => $row['Firstname'].' '.$row['Lastname'],
            'email'    => $row['Email'], 
            'gender'    => $row['Gender'], 
            'empid'    => $row['EMPID'], 
            'password' => Hash::make($row['Password']),
            'status' => '1',
            'verified' => '1',
            'darkmode' => setting('DARK_MODE')
        ]);
        

        $user->assignRole($row['Role']); 
        
        return $user;
    }
  
    public function rules(): array
      {
          return  [
              '*.firstname' => ['required','string',],
              '*.lastname' => ['required','string',],
              '*.email' => ['required','string','unique:users,email'],
              '*.gender' => ['required','string',],
              '*.password' => ['required'],
              '*.empid' => ['required'],
              '*.role' => ['required'],
          ];
  
         
      }
}
