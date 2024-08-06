<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendence;
use App\Models\MemberSalary;
use App\Models\Salary;
use Carbon\Carbon;
use PhpParser\Node\Stmt\If_;

class MemberController extends Controller
{
    public function showMember(){
        $user=Auth::user();

        if($user->usertype=='admin'){
            $users=Member::get();
            $totalmember=member::count();
            return view('admin.member',compact('user','users','totalmember'));
        }

    }

    public function addFormMember(){
        $user=Auth::user();
        if ($user->usertype=='admin') {
       

            return view('admin.addMember',compact('user'));
        }

    }
    public function addMember(Request $request){
        $user=Auth::user();
        if ($user->usertype=='admin') {
            $member=new Member();
            $member->first_name=$request->first_name;
            $member->last_name=$request->last_name;
            $member->email=$request->email;
            $member->phone=$request->phone;
            $member->address=$request->address;
            $member->gender=$request->gender;
            $member->date_of_birth=$request->date_of_birth;
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $member->photo_path = $imagePath;
            $member->designation=$request->designation;
            $IdCard=$request->file('national_id');
            $IdCardPath=$IdCard->store('national_id', 'public');
            $member->national_id=$IdCardPath;
           $certifecates=$request->file('certificates');
           $certifecatesPath=$certifecates->store('certificates','public');
           $member->certificates=$certifecatesPath;
            $member->joining_date=$request->date_of_joining;
            $member->status=$request->status;
            $member->short_biography=$request->bio;
            $member->save();
            return response()->json(['success' => true, 'message' => 'Member added successfully']);
        }
        return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'], 401);
           

}
public function editmember($id){
    $user=Auth::user();
    if ($user->usertype=='admin') {
        $member=Member::find($id);
        return view('admin.editMember',compact('member','user'));
    }
}
public function updatemember(Request $request,$id){
    $user=Auth::user();
    if ($user->usertype=='admin') {
        $member=Member::find($id);
        $member->first_name=$request->first_name;
        $member->last_name=$request->last_name;
        $member->email=$request->email;
        $member->phone=$request->phone;
        $member->address=$request->address;
        $member->gender=$request->gender;
        $member->date_of_birth=$request->date_of_birth;
        if($request->image){
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $member->photo_path = $imagePath;
        }
        
        $member->designation=$request->designation;
        if($request->national_id){
            $IdCard=$request->file('national_id');
            $IdCardPath=$IdCard->store('national_id', 'public');
            $member->national_id=$IdCardPath;
        }
      
        if($request->certificates){
            $certifecates=$request->file('certificates');
            $certifecatesPath=$certifecates->store('certificates','public');
            $member->certificates=$certifecatesPath;
        }
     
        $member->joining_date=$request->date_of_joining;
        $member->status=$request->status;
        $member->short_biography=$request->bio;
        $member->save();
        return response()->json(['success' => true, 'message' => 'Member updated successfully']);
    }
    return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'], 401);
  
}
public function deletemember($id){
          $user = Auth::user();
        if ($user->usertype == 'admin') {
              $member = Member::find($id);
            $member->delete();
            return redirect()->back()->with(compact('user'));
            }else{
                return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'],
                401);
                }
   
}
// attendence
public function attendenceMember(Request $request)
{
    $user = Auth::user();
    if ($user->usertype == 'admin') {
        $members = Member::get();
        
        // Retrieve filter dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Filter attendance records based on date range if provided
        $query = Attendence::with('members');
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        $attendence = $query->get();
        
        return view('admin.attendence', compact('attendence', 'user', 'members'));
    }
}


public function addAttendence(Request $request){
    $user = Auth::user();   
    if ($user->usertype == 'admin') {
       
        $attendence = new Attendence();
        $attendence->member_id = $request->member_id;
        $attendence->date = $request->date;
        $attendence->sign_in = $request->sign_in;

        $signInTime = Carbon::parse($request->sign_in);
        $signOutTime = Carbon::parse($request->sign_out ?? '18:00:00'); // Default sign-out time if not provided

        // Calculate the difference using diff method
        $diff = $signInTime->diff($signOutTime);

        // Calculate total minutes
        $stayTimeInMinutes = ($diff->h * 60) + $diff->i;
        
        // Set sign_out time
        $attendence->sign_out = $signOutTime->toTimeString();
        $attendence->stay_time = $stayTimeInMinutes * 60; // Store in seconds
        $attendence->save();

        return response()->json(['success' => true, 'message' => 'Attendance added successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
}



public function deleteAttendence($id){
    $user=Auth::user();
    if($user->usertype=='admin'){
        $id=Attendence::find($id);
        $id->delete();
        $attendence=Attendence::with('members')->get();
        return view('admin.attendence',compact('attendence','user'));  
    }
}

public function editAttendece($id){
    $user=Auth::user();
    if($user->usertype=='admin'){
        $members=Member::get();
        $attendence=Attendence::with('members')->find($id);
        return view('admin.editAttendece',compact('user','members','attendence'));  
    }
}
public function updateAttendence(Request $request, $id)
{
    $user = Auth::user();   

    if ($user->usertype=='admin') { // Ensure the user is authenticated

        $attendence = Attendence::find($id);
        $attendence->member_id = $request->member_id;
        $attendence->date = $request->date;
        $attendence->sign_in = $request->sign_in;

        $signInTime = Carbon::parse($request->sign_in);
        $signOutTime = Carbon::parse($request->sign_out ?? '18:00:00'); // Default sign-out time if not provided

        // Calculate the difference using diff method
        $diff = $signInTime->diff($signOutTime);

        // Calculate total minutes
        $stayTimeInMinutes = ($diff->h * 60) + $diff->i;

        // Set sign_out time
        $attendence->sign_out = $signOutTime->toTimeString();
        $attendence->stay_time = $stayTimeInMinutes * 60; // Store in seconds
        $attendence->save();

        return response()->json(['success' => true, 'message' => 'Attendance updated successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
}

/////salaryMember
public function salaryMember(){
    $user=Auth::user();

    if($user->usertype=='admin'){
       $members=Member::get();
        $salaries=MemberSalary::with('member')->get();
     
        return view('admin.salary',compact('user','salaries','members'));
    }

}
public function addSalary(Request $request){
    $user=Auth::user();
    if($user->usertype=='admin'){

        $salary=new MemberSalary();
        $salary->member_id=$request->member_id;
        $salary->date=$request->date;
        $salary->totalSalary=$request->totalSalary;
        $salary->workingDays=$request->workingDays;
        $salary->GenratedBy=$user->usertype;
        $salary->satus='Unpaid';
        $salary->save();     
        return response()->json(['success' => true, 'message' => 'Salary added successfully']);
    }   
}

public function deleteSalary($id){
    $user = Auth::user();
    if ($user->usertype == 'admin') {
          $member = MemberSalary::find($id);
        $member->delete();
        return redirect()->back();
        }else{
            return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'],
            401);
            }

}

public function editSalary($id){
    $user=Auth::user();
    if($user->usertype=='admin'){
        $members=Member::get();
        $salary=MemberSalary::with('member')->find($id);
        return view('admin.editSalary',compact('user','salary','members'));  
    } 
}

public function updateSalary(Request $request,$id){
    $user=Auth::user();
    if($user->usertype=='admin'){

        $salary=MemberSalary::find($id);
        $salary->member_id=$request->member_id;
        $salary->date=$request->date;
        $salary->totalSalary=$request->totalSalary;
        $salary->workingDays=$request->workingDays;
        $salary->GenratedBy=$user->usertype;
        $salary->satus='Unpaid';
        $salary->save();     
        return response()->json(['success' => true, 'message' => 'Salary Updated successfully']);
    }  
}
}
