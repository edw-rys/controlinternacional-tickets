<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\User;
use App\Models\Customer;
use App\Models\Ticket\Category;
use App\Models\Ticket\Ticket;
use App\Models\usersettings;
use DB;
use DataTables;
use Carbon\Carbon;

class AdminReportController extends Controller
{
   public function index()
   {

      $this->authorize('Reports Access');

      if (request()->ajax()) {

         $data = User::get();
         return DataTables::of($data)
            ->addColumn('name', function ($data) {
               if (!empty($data->getRoleNames()[0])) {
                  $name = '<div class="h5 mb-0">' . $data->name . '</div><small class="fs-12 text-muted"><span class="font-weight-normal1"><b>(' . $data->getRoleNames()[0] . ')</b></span></small>';
               } else {
                  $name = '<div class="h5 mb-0">' . $data->name . '</div><small class="fs-12 text-muted"></small>';
               }



               return $name;
            })
            ->addColumn('rating', function ($data) {

               $avgrating1 = usersettings::where('users_id', $data->id)->sum('star1');
               $avgrating2 = usersettings::where('users_id', $data->id)->sum('star2');
               $avgrating3 = usersettings::where('users_id', $data->id)->sum('star3');
               $avgrating4 = usersettings::where('users_id', $data->id)->sum('star4');
               $avgrating5 = usersettings::where('users_id', $data->id)->sum('star5');

               $avgr = ((5 * $avgrating5) + (4 * $avgrating4) + (3 * $avgrating3) + (2 * $avgrating2) + (1 * $avgrating1));
               $avggr = ($avgrating1 + $avgrating2 + $avgrating3 + $avgrating4 + $avgrating5);

               if ($avggr == 0) {
                  $avggr = 1;
                  $avg = $avgr / $avggr;
               } else {
                  $avg = $avgr / $avggr;
               }

               $rating = $avg;

               return '<div class="allemployeerating pt-1" data-rating="' . $rating . '"></div>';
            })
            ->addColumn('replycount', function ($data) {

               $replycount = $data->comments()->count();

               return $replycount;
            })


            ->rawColumns(['name', 'replycount', 'rating'])
            ->addIndexColumn()
            ->make(true);
      }

      $title = Apptitle::first();
      $data['title'] = $title;

      $footertext = Footertext::first();
      $data['footertext'] = $footertext;

      $seopage = Seosetting::first();
      $data['seopage'] = $seopage;

      $post = Pages::all();
      $data['page'] = $post;

      $agentactivec = User::where('status', '1')->count();
      $data['agentactivec'] = $agentactivec;
      $agentinactive = User::where('status', '0')->count();
      $data['agentinactive'] = $agentinactive;

      $customeractive = Customer::where('status', '1')->count();
      $data['customeractive'] = $customeractive;
      $customerinactive = Customer::where('status', '0')->count();
      $data['customerinactive'] = $customerinactive;

      $newticket = Ticket::where('status', 'New')->count();
      $data['newticket'] = $newticket;

      $closedticket = Ticket::where('status', 'Closed')->count();
      $data['closedticket'] = $closedticket;

      $inprogressticket = Ticket::where('status', 'Inprogress')->count();
      $data['inprogressticket'] = $inprogressticket;

      $onholdticket = Ticket::where('status', 'On-Hold')->count();
      $data['onholdticket'] = $onholdticket;

      $reopenticket = Ticket::where('status', 'Re-Open')->count();
      $data['reopenticket'] = $reopenticket;

      $data['categories'] = Category::whereIn('display', ['ticket', 'both'])->where('status', '1')->get();

      return view('admin.reports.index')->with($data);
   }

   public function exportPriority(Request $request)
   {

      $tickets = (new Ticket);
      $priorities = [
         [
            'priority'  => 'all',
            'translate' => 'Todos'
         ],[
            'priority'  => 'Critical',
            'translate' => 'Crítico',
            'count'     => 0
         ],[
            'priority'  => 'High',
            'translate' => 'Alto',
            'count'     => 0
         ],[
            'priority'  => 'Medium',
            'translate' => 'Medio',
            'count'     => 0
         ],[
            'priority'  => 'Low',
            'translate' => 'Bajo',
            'count'     => 0
         ]
      ];
      $html = '<h4 style="color: #0022ff;">Tickets por Prioridad</h4><ul>';
      foreach ($priorities as $key => $priority) {
         $request->merge([
            'priority_id'  => $priority['priority']
         ]);
         $priority['count'] = $this->buildQuery($request, $tickets)->count();
         $html .= '<li><strong>' . $priority['translate']. ': </strong> '.$priority['count'].'</li>';
      }
      $html .= '</ul>';

      return response()->json([
         'html'   => $html
      ]);
   }

   public function exportCategory(Request $request)
   {

      $categories = Category::whereIn('display', ['ticket', 'both'])->where('status', '1')->get();

      $tickets = (new Ticket);


      $html = '<h4 style="color: #0022ff;">Tickets por Categoría</h4><ul>';
      $request->merge([
         'category_id'  => 'all'
      ]);

      $html .= '<li><strong>Todos: </strong> '.$this->buildQuery($request, $tickets)->count().'</li>';
      foreach ($categories as $key => $category) {
         $request->merge([
            'category_id'  => $category->id
         ]);
         $category->count = $this->buildQuery($request, $tickets)->count();
         $html .= '<li><strong>' . $category->name . ': </strong> '.$category->count.'</li>';
      }
      $html .= '</ul>';

      return response()->json([
         'html'   => $html
      ]);
   }

   public function exportStatus(Request $request)
   {

      $tickets = (new Ticket);

      $statuses = [
         [
            'status'  => 'all',
            'translate' => 'Todos'
         ],[
            'status'  => 'active',
            'translate' => 'Tickets Activos',
            'count'     => 0
         ],[
            'status'  => 'onhold',
            'translate' => 'Tickets en espera',
            'count'     => 0
         ],[
            'status'  => 'overdue',
            'translate' => 'Tickets atrasado',
            'count'     => 0
         ],[
            'status'  => 'reopen',
            'translate' => 'Tickets cerrados',
            'count'     => 0
         ],[
            'status'  => 'closed',
            'translate' => 'Tickets cerrados',
            'count'     => 0
         ]
      ];
      $html = '<h4 style="color: #0022ff;">Tickets por Estado</h4><ul>';
      foreach ($statuses as $key => $status) {
         $request->merge([
            'status'  => $status['status']
         ]);
         $status['count'] = $this->buildQuery($request, $tickets)->count();
         $html .= '<li><strong>' . $status['translate']. ': </strong> '.$status['count'].'</li>';
      }
      $html .= '</ul>';

      return response()->json([
         'html'   => $html
      ]);
   }

   

   public function buildQuery(Request $request, $data)
   {
      if (isset($request->created_start) && $request->created_start != null && $request->created_start != 'all' && $request->created_start) {
         // dd($request->created_start);
         $data = $data->whereDate('created_at', '>=', $request->created_start);
      }

      if ($request->created_end != null && $request->created_end != 'all' && $request->created_end) {
         $data = $data->whereDate('created_at', '<=', $request->created_end);
      }

      if ($request->category_id != null && $request->category_id != 'all') {
         $data = $data->where('category_id', $request->category_id);
      }

      if ($request->status != null && $request->status != 'all') {
         switch ($request->status) {
            case 'active':
               $data = $data->whereIn('status', ['New', 'Re-Open', 'Inprogress']);
               break;
            case 'closed':
               $data=$data->where('status', 'Closed');
               break;
            case 'close':
               $data = $data->where('status', 'Closed');
               break;
            case 'onhold':
               $data = $data->where('status', 'On-Hold');
               break;
            case 'overdue':
               $data = $data->whereIn('overduestatus', ['Overdue']);
               break;
            case 'reopen':
               $data = $data->whereIn('overduestatus', ['Re-Open']);
               break;
               
            default:
               break;
         }
      }
      if ($request->priority_id != null && $request->priority_id != 'all') {
         $data = $data->where('priority', $request->priority_id);
      }

      if ($request->customers_id != null && $request->customers_id != 'all' && is_array($request->customers_id) && count($request->customers_id) > 0) {
         $data = $data->whereIn('cust_id', $request->customers_id);
      }
      return $data;
   }
}
