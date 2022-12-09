<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportCustomerExport;
use App\Exports\ReportCustomerHoseExport;
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
use Maatwebsite\Excel\Facades\Excel;

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

   /**
    * It returns a JSON response with a HTML string that contains a list of priorities and the number
    * of tickets for each one
    * 
    * @param Request request The request object.
    * 
    * @return A JSON object with the HTML code for the report.
    */
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

   /**
    * It returns a JSON response with an HTML string that contains a list of ticket categories and the
    * number of tickets in each category
    * 
    * @param Request request The request object.
    * 
    * @return A JSON object with the HTML to be displayed in the modal.
    */
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

   /**
    * It returns a JSON response with a HTML string that contains a list of ticket statuses and their
    * respective counts
    * 
    * @param Request request The request object.
    */
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

   /**
    * It exports the data to an excel file.
    * 
    * @param Request request The request object.
    */
   public function exportCustomer(Request $request){
      $tickets = $this->buildQuery($request, (new Ticket))
         ->select([DB::raw('count(cust_id) as count'), 'cust_id'])
         ->with('cust')
         ->groupBy('cust_id')
         ->has('cust')
         ->get()
         ;
      $customers = $tickets->map(function ($e) {
         $e->cust->total_tickets = $e->count;
         return $e->cust;
      });
      // Categories
      $ticketsCategories = $this->buildQuery($request, (new Ticket))
         ->select([DB::raw('count(category_id) as count'), 'category_id', 'cust_id'])
         ->groupBy(['category_id', 'cust_id'])
         ->get();
      // STATUS
      $ticketsStatuses = $this->buildQuery($request, (new Ticket))
         ->select([DB::raw('count(status) as count'), 'status', 'cust_id'])
         ->groupBy(['status', 'cust_id'])
         ->get();

      $prioritiesStatuses = $this->buildQuery($request, (new Ticket))
         ->select([DB::raw('count(priority) as count'), 'priority', 'cust_id'])
         ->groupBy(['priority', 'cust_id'])
         ->get();
      // dd($ticketsStatuses->toArray());

      $categories = Category::whereIn('display', ['ticket', 'both'])->where('status', '1')->get();
      $statuses = $this->getStatuses();
      $priorities = $this->getPriorities();
      
      
      foreach ($customers as $key => $customer) {
         // CATEGORIES
         $customer->categories_list = collect();
         $customer->total_categories = 0;
         $items = $ticketsCategories->where('cust_id', $customer->id);
         foreach ($categories as $key => $category) {
            $ctgFind = $items->firstWhere('category_id', $category->id);
            $countCtg = 0;
            if($ctgFind != null){
               $countCtg = $ctgFind->count;
            }
            $customer->categories_list->push( $countCtg);
            $customer->total_categories += $countCtg;
         }
         // STATUSES
         $customer->statuses_list = collect();
         $customer->total_status = 0;
         $items = $ticketsStatuses->where('cust_id', $customer->id);
         foreach ($statuses as $key => $statusObj) {
            $statusesFind = $items->whereIn('status', $statusObj['options']);
            $countStatus = 0;
            if(count($statusesFind) > 0 ){
               foreach ($statusesFind as $key => $statusFn) {
                  $countStatus = $statusFn->count;
               }
            }
            $customer->statuses_list->push( $countStatus);
            $customer->total_status += $countStatus;
         }
         // PRIORITY
         $customer->priorities_list = collect();
         $customer->total_priorities = 0;
         $items = $prioritiesStatuses->where('cust_id', $customer->id);
         foreach ($priorities as $key => $priority) {
            $priorityFind = $items->firstWhere('priority', $priority['priority']);
            $countPriority = 0;
            if($priorityFind != null){
               $countPriority = $priorityFind->count;
            }
            $customer->priorities_list->push( $countPriority);
            $customer->total_priorities += $countPriority;
         }
      }
      // dd($customers->toArray());
      return Excel::download(new ReportCustomerExport($customers, (object) [
         'priorities'   => $priorities,
         'statuses'   => $statuses,
         'categories'   => $categories
      ]
      ), 'Reporte de tickets por estaciones -'.Carbon::now()->format('d-m-Y').'.xlsx');
   }

   public function exportHoses(Request $request)
   {
      $tickets = $this->buildQuery($request, (new Ticket))
         ->select([DB::raw('count(hose_id) as count'), 'hose_id','cust_id'])
         ->whereNotNull('hose_id')
         ->groupBy(['hose_id', 'cust_id'])
         ->with('cust')
         ->with('hose')
         ->has('hose')
         ->has('cust')
         ->get();

      $customers = collect();
      foreach ($tickets as $key => $ticket) {
         $ticket->hose->count_tickets = $ticket->count; 
         $exist = $customers->firstWhere('id', $ticket->cust_id);
         if($exist == null){
            $ticket->cust->list_hoses = collect([$ticket->hose]);
            $customers->push($ticket->cust);
            continue;
         }
         $hose = $exist->list_hoses->firstWhere('id', $ticket->hose_id);
         if($hose == null){
            $exist->list_hoses->push($ticket->hose);
         }
      }
      return Excel::download(new ReportCustomerHoseExport($customers), 'Reporte de tickets por estaciones -'.Carbon::now()->format('d-m-Y').'.xlsx');

   }
   
   public function getPriorities()
   {
      return [
         [
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
   }
   public function getStatuses()
   {
      return [
         [
            'status'  => 'active',
            'translate' => 'Tickets Activos',
            'options'   => ['New', 'Re-Open', 'Inprogress'],
            'count'     => 0
         ],[
            'status'  => 'onhold',
            'translate' => 'Tickets en espera',
            'options'   => ['On-Hold'],
            'count'     => 0
         ],[
            'status'  => 'overdue',
            'translate' => 'Tickets atrasado',
            'options'   => ['Overdue'],
            'count'     => 0
         ],[
            'status'  => 'reopen',
            'translate' => 'Tickets cerrados',
            'options'   => ['Re-Open'],
            'count'     => 0
         ],[
            'status'  => 'closed',
            'translate' => 'Tickets cerrados',
            'options'   => ['Closed'],
            'count'     => 0
         ]
      ];
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
      }else if($request->priority_id != 'all'){
         $data = $data->whereNotNull('priority');
      }

      if ($request->customers_id != null && $request->customers_id != 'all' && is_array($request->customers_id) && count($request->customers_id) > 0) {
         $data = $data->whereIn('cust_id', $request->customers_id);
      }
      return $data;
   }
}
