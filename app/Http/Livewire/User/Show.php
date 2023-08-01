<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Show extends Component
{
    public $selectuser,$userdata;
    public bool $self=false, $editmode=false,$editpassword=false;
    public $departmentList,$HODList;

    public function mount($id){
        $this->departmentList= User::all()->unique('department');
        // dd($this->departmentList);
        $this->selectuser = User::with('permissions')->firstWhere('staff_id',$id);
        // dd($this->selectuser);
        // dd($this->selectuser->staff_id,Auth::user()->staff_id);
        if($this->selectuser==Auth::user()){
            $this->self=true;
        }
    }
    public function toggleEditMode(){
        $this->editmode=!$this->editmode;
        $this->editpassword = false;
        $this->userdata = $this->selectuser->toArray();
        $this->HODList = $this->selectuser->colleague();
        $this->HODList = $this->selectuser->colleague();
        // dd($this->userdata);
    }
    public function togglePassword(){
        $this->editmode = false;
        $this->editpassword = !$this->editpassword;
    }
    
    public function updatedUserdataDepartment(){
        // dd('department changed');
        $user = User::firstWhere('department',$this->userdata['department']);
        $this->HODList = $user->colleague();
        // dd($this->HODList[0]);
        $this->userdata['department_head']=$this->HODList[0]->id;
        // dd($this->HODList);
    }
    public function editProfile(){
        /* $validatedData = $this->validate([
            'userdata.name' => 'required|String',
            'userdata.staff_id' => 'required|unique:users',
            'userdata.email' => 'nullable|Email',
            'userdata.position' => 'required|String',
            'userdata.department' => 'required|Enum',
            'userdata.department_head' => 'required|String',
            'userdata.user_level' => 'required|Enum',
        ]); */

        $this->selectuser->name = $this->userdata['name'];
        $this->selectuser->staff_id = $this->userdata['staff_id'];
        $this->selectuser->email = $this->userdata['email'];
        $this->selectuser->position = $this->userdata['position'];
        $this->selectuser->department = $this->userdata['department'];
        $this->selectuser->department_head = $this->userdata['department_head'];
        $this->selectuser->user_level = $this->userdata['user_level'];
        // $this->selectuser->status = $this->userdata['status'];
        $this->selectuser->save();
        $this->toggleEditMode();
        // dd($this->selectuser);
    }

    public function changePassword(){
        // Validated current password
        // match password confirm and password rule
        $validatedData = $this->validate([
            'userdata.currentPassword' => 'required|current_password',
            'userdata.newPassword' => 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'userdata.newPassword_cf' => 'required|same:userdata.newPassword',
        ],[
            'userdata.currentPassword.required' => 'จำเป็นต้องกรอก',
            'userdata.currentPassword.current_password' => 'password ไม่ถูกต้อง',

            'userdata.newPassword.required' => 'จำเป็นต้องกรอก',
            'userdata.newPassword.min' => 'password ต้องมีความยาวอย่างน้อย 6 ตัวอักษร',
            'userdata.newPassword.regex' => 'password ต้องประกอบด้วย ตัวอักษรภาษาอังกฤษ พิมพ์เล็ก พิมพ์ใหญ่ ตัวเลข อย่างน้อย 1 ตัวอักษร อักระพิเศษ อย่างน้อย 1 ตัวอักษร',

            'userdata.newPassword_cf.required' => 'จำเป็นต้องกรอก',
            'userdata.newPassword_cf.same' => 'password ใหม่ไม่ตรงกัน',
        ]);
        /* dd($this->userdata['newPassword'],
            Hash::make($this->userdata['newPassword']),
            $this->selectuser->password,
            Hash::check($this->userdata['newPassword'], $this->selectuser->password)); */
        $this->selectuser->password = Hash::make($this->userdata['newPassword']);
        $this->selectuser->password->save();

    }

    public function render()
    {
        return view('livewire.user.show',[
            'user'=>$this->selectuser,
        ])->extends('layouts.app');
    }
}
