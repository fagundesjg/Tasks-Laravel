<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

function filtrar_datas($tasks)
{
    $stamp_today_start = mktime(0,0,0,date('m'),date('d'),date('Y'));
    $stamp_today_end = mktime(23,59,59,date('m'),date('d'),date('Y'));

    $stamp_tomorrow_start = mktime(0,0,0,date('m'),date('d')+1,date('Y'));
    $stamp_tomorrow_end = mktime(23,59,59,date('m'),date('d')+1,date('Y'));

    $stamp_week_start = mktime(0,0,0,date('m'),date('d')+2,date('Y'));
    $stamp_week_end = mktime(23,59,59,date('m'),date('d')+5,date('Y'));

    $stamp_month_start = mktime(0,0,0,date('m'),date('d')+8,date('Y'));
    $stamp_month_end = mktime(23,59,59,date('m')+1,date('d'),date('Y'));

    $today = array();
    $tomorrow = array();
    $week = array();
    $month = array();

    foreach($tasks as $task)
    {
        $splited = array_reverse(explode('-',$task['date'])); // d/m/Y
        $date = mktime(0,0,0,date($splited[1]),date($splited[0]),date($splited[2]));

        if($date >= $stamp_today_start && $date <= $stamp_today_end):
             array_push($today,$task);
        elseif($date >= $stamp_tomorrow_start && $date <= $stamp_tomorrow_end):
            array_push($tomorrow,$task);
        elseif($date >= $stamp_week_start && $date <= $stamp_week_end):
             array_push($week,$task);
        elseif($date >= $stamp_month_start && $date <= $stamp_month_end):
             array_push($month,$task);
        endif;
    }

    return ['Hoje' => $today,
            'Amanhã' => $tomorrow,
            'Semana' => $week,
            'Mês' => $month];
}

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = Task::all()->where('user_id','=',Auth::user()->id);

        $tasks = filtrar_datas($tasks);
        
        /*$tasks = DB::table('tasks')
                 ->where('user_id','=',Auth::user()->id)
                 ->orderBy('date','DESC')
                 ->get();*/

        $days = [
            ['day'=>'Hoje','color'=>'#D92A40'],
            ['day'=>'Amanhã','color'=>'#F3C802'],
            ['day'=>'Semana','color'=>'#009900'],
            ['day'=>'Mês','color'=>'#0088CC'],
        ];

        $data = [
            'tasks' => $tasks,
            'days' => $days,
        ];

        return view('index')->with(compact('data'));
    }

    public function store(Request $request)
    {
        Task::create($request->all());
        return redirect('/')->with('success_message','Task inserida com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->date = $request->date;
        $task->description = $request->description;
        $task->save();
        return redirect('/')->with('success_message','Task atualizada com sucesso!');
    }

    public function toggle_status(Request $Request, $id)
    {
        $task = Task::findOrFail($id);
        $task->status = ($task->status)? 0: 1;
        $task->save();
        return redirect('/');
    }

    public function delete(Request $Request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect('/')->with('success_message','Task deletada com sucesso!');
    }

    public function toggle_visibility()
    {
        return redirect('/hidden');
    }

}
