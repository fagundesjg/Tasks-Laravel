<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet"> 
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}" defer></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tasks</title>
</head>
<body>
    <!-- Modal criar task -->
    <div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
          <form method="POST" action="{{route('addtask')}}" onsubmit="return validateCreate()">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="user_id" type="hidden" type="text" value="{{Auth::user()->id}}"/>
                    <div class="form-group">
                        <label for="date">Selecione a data</label>
                        <input id="create-date" name="date" type="date" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description">Digite a descrição</label>
                        <textarea id="create-description" name="description" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <!-- Modal editar task -->
    <div class="modal fade" id="alterTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form method="POST" action="#" id="form-update">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Selecione a data</label>
                        <input name="date" id="modal-edit-date" type="date" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="description">Digite a descrição</label>
                        <textarea name="description" id="modal-edit-description" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <input type="submit" class="btn btn-primary" value="Atualizar"/>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="header">
        <label class="header-title">Tasks</label>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle btn-dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{'Bem vindo ' . Auth::user()->name}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
        </form>
    </div>

    <div class="box-actions">
        <div class="box-actions-buttons">
            <button class="btn btn-dropdown" data-toggle="modal" data-target="#addTask">Adicionar tarefa</button>
            <span id="icon-visibility" class="icon-show" onclick="changeVisibility()"/></span>
        </div>
        <div class="box-actions-message">
            @if (session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>
            @endif
        </div> 
    </div>

    <div class="body">
        @foreach ($data['days'] as $day)
        <div class="box-col">
        <div class="box-col-title" style="background-color: {{$day['color']}}">{{$day['day']}}</div>
                <div class="box-col-body" id="box-col-body">
                        @foreach ($data['tasks'][$day['day']] as $task)
                        @if ($task['status'])
                        <section class="task-box completed">
                        @else
                        <section class="task-box">
                        @endif
                            <div class="task-date"><label id="task-date-{{$task['id']}}">{{ implode('/',array_reverse(explode('-',$task['date']))) }}</label></div>
                                <div class="task-description">
                                    @if ($task->status)
                                        <label style="overflow:auto; background-color: white;text-decoration:line-through" id="task-description-{{$task['id']}}">{{$task['description']}}</label>
                                    @else
                                        <label style="overflow:auto; background-color: white" id="task-description-{{$task['id']}}">{{$task['description']}}</label>
                                    @endif
                                </div>
                                <div class="task-actions">
                                <div class="icon-edit" data-toggle="modal" data-target="#alterTask" onclick="editTask('{{$task['id']}}')"></div>
                                @if ($task->status)
                                <div class="icon-checked" onclick="document.getElementById('toggle-check-{{$task['id']}}').submit()"></div>
                                @else
                                    <div class="icon-check" onclick="document.getElementById('toggle-check-{{$task['id']}}').submit()"></div>
                                @endif
                                <div class="icon-delete" onclick="document.getElementById('delete-task-{{$task['id']}}').submit()">
                                <form id="delete-task-{{$task['id']}}" action="/delete/{{$task['id']}}" method="POST" hidden>
                                    @csrf
                                        <input type="submit">
                                    </form> 
                                    <form id="toggle-check-{{$task['id']}}" action="/toggle-status/{{$task['id']}}" method="POST" hidden>
                                    @csrf
                                        <input type="submit">
                                    </form> 
                                </div>
                                </div>
                            </section> 
                        @endforeach
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>