<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;
use AuthenticatesUsers;
use App\Models\User;
use App\Models\Ticket\Ticket;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Ticket\Category;
use DataTables;
use Str;
class DashboardController extends Controller
{
    

   public function userTickets(Request $request)
   {
       $tickets = Ticket::where('cust_id', Auth::guard('customer')->user()->id)->count();

       $active = Ticket::where('cust_id', Auth::guard('customer')->user()->id)
       ->whereIn('status', ['New', 'Re-Open'])->get();

       $closed = Ticket::where('cust_id', Auth::guard('customer')->user()->id)
        ->where('status', 'Closed')->get();

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Ticket::where('cust_id', Auth::guard('customer')->user()->id)->latest('updated_at');
    
            if($request->category_id != null && $request->category_id != 'all'){
                $data->where('category_id', $request->category_id);
            }
            if($request->priority_id != null && $request->priority_id != 'all'){
                $data->where('priority', $request->priority_id);
            }

            if($request->created_start != null && $request->created_start != 'all' && $request->created_start){
                $data->whereDate('created_at', '>=',$request->created_start);
            }

            if($request->created_end != null && $request->created_end != 'all' && $request->created_end){
                $data->whereDate('created_at', '<=', $request->created_end);
            }
            
            return DataTables::of($data)
        
            ->addColumn('ticket_id', function($data){
                
                return '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.$data->ticket_id.'</a>';
            })
            ->addColumn('subject', function($data){
                $subject = '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.Str::limit($data->subject, '10').'</a>';
                return $subject;
            })
            ->addColumn('priority',function($data){
                if($data->priority != null){
                    $trans = trans('langconvert.newwordslang.' . (strtolower($data->priority)));
                    // $trans = trans('langconvert.admindashboard.newwordslang.' .($data->priority));
                    if($data->priority == "Low"){
                        $priority = '<span class="badge badge-success-light">'.$trans.'</span>';
                    }
                    elseif($data->priority == "High"){
                        $priority = '<span class="badge badge-danger-light">'.$trans.'</span>';
                    }
                    elseif($data->priority == "Critical"){
                        $priority = '<span class="badge badge-danger-dark">'.$trans.'</span>';
                    }
                    else{
                        $priority = '<span class="badge badge-warning-light">'.$trans.'</span>';
                    }
                }else{
                    $priority = '~';
                }
                return $priority;
            })
            ->addColumn('created_at',function($data){
                $created_at = $data->created_at->format(setting('date_format'));
                return $created_at;
            })
            ->addColumn('hose_id', function($data){
                if($data->hose_id != null){
                    $hose = Str::limit($data->hose->name, '50');
                    return $hose;
                }else{
                    return '~';
                }
            })
            ->addColumn('category_id', function($data){
                if($data->category_id != null){
                    $category_id = Str::limit($data->category->name, '10');
                    return $category_id;
                }else{
                    return '~';
                }
            })
            ->addColumn('status', function($data){

                $lang = trans('langconvert.admindashboard.' . (strtolower($data->status)));
                if($data->status == "New"){
                    $status = '<span class="badge badge-burnt-orange"> '.$lang.' </span>';
                }
                elseif($data->status == "Re-Open"){
                    $status = '<span class="badge badge-teal">'.$lang.'</span> ';
                }
                elseif($data->status == "Inprogress"){
                    $status = '<span class="badge badge-info">'.$lang.'</span>';
                }
                elseif($data->status == "On-Hold"){
                    $status = '<span class="badge badge-warning">'.$lang.'</span>';
                }
                else{
                    $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                }
    
                return $status;
            })
            ->addColumn('last_reply', function($data){
                if($data->last_reply == null){
                    $last_reply = $data->created_at->diffForHumans();
                }else{
                    $last_reply = $data->last_reply->diffForHumans();
                }
    
                return $last_reply;
            })
            ->addColumn('action', function($data){
    
                $button = '<div class = "d-flex">';
                $button .= '<a href="'.route('loadmore.load_data',$data->ticket_id).'" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Ticket"><i class="feather feather-edit text-primary"></i></a>
                            <a href="javascript:void(0)" class="action-btns1" data-id="'.$data->id.'" id="show-delete" data-bs-toggle="tooltip" data-placement="top" title="Delete Ticket"><i class="feather feather-trash-2 text-danger"></i></a>';
                $button .= '</div>';
              return $button;
            })
            ->addColumn('checkbox', '<input type="checkbox" name="student_checkbox[]" class="checkall" value="{{$id}}" />')
              ->rawColumns(['action','subject','status','priority','created_at','last_reply','ticket_id','checkbox'])
              ->addIndexColumn()
              ->make(true);
             
        }
        
        $data['status'] = 'all';
        $data['categories'] = Category::whereIn('display',['ticket', 'both'])->where('status', '1')->get();

        return view('user.dashboard', compact('tickets','active','closed', 'title','footertext'))->with($data);
   }


   public function notify(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;


        return view('user.notification')->with($data);
   }

   public function markNotification(Request $request)
   {
       auth()->guard('customer')->user()
        ->unreadNotifications
        ->when($request->input('id'), function ($query) use ($request) {
            return $query->where('id', $request->input('id'));
        })
        ->markAsRead();

       return response()->noContent();
   }
   
}
