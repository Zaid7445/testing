=============================== Front User Start ===============================
    ---------------- chat.blade.php Start -------------------
        <div class="card">
            <div class="card-body" style="flex: 1 1 auto;height: 400px!important;padding: 1.25rem;overflow: scroll;">
                <div id="messages"></div>
            </div>
            <form action="{{url('send-message')}}" method="post" id="send-message">
                @csrf
                <input type="hidden" name="from" id="from" value="{{isset($from) ? $from : auth()->id()}}">
                <input type="hidden" name="to" id="to" value="{{isset($to) ? $to : ''}}">
                <div class="form-group">
                    <textarea name="message" id="message" cols="30" rows="3" placeholder="Write Message" style="overflow: hidden;width: 100%;border: 1px solid lightgray;"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-warning" value="Send Message" />
                </div>
            </form>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
        
        $(document).ready(function(){    
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });         
            setTimeout(() => {   
                $('.card-body').scrollTop($('.card-body').height()+100000);         
            }, 100);     
        
            let from_id = $('#from').val();
            let to_id = $('#to').val();
            getMessage(from_id, to_id);    
            function getMessage(from, to){
                $.ajax({
                    url : '{{url("get-messages")}}',
                    type : 'post',
                    data : {from:from,to:to},            
                    success : function(res){
                        $('#messages').html(res);
                        setTimeout(() => {   
                            $('.card-body').scrollTop($('.card-body').height()+100000);         
                        }, 100); 
                    }
                });
            }
            $('#send-message').on('submit', function(e){                
                e.preventDefault();
                var data = new FormData(this);
                var url = $(this).attr('action');
                $('#message').val('');
                $.ajax({
                    url : url,
                    type : 'post',
                    data : data,
                    contentType : false,
                    processData : false,
                    success : function(res){       
                        $('#messages').append(res);
                        $('.card-body').scrollTop($('.card-body').height()+100000);         
                    }
                })
            });
        
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = false;
            var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: 'ap2'
            });
        
            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                from_id = $('#from').val();
                to_id = $('#to').val();
                console.log(data.from, from_id, data.to, to_id);
            if(data.from == from_id){
                if(data.to == to_id){
                    getMessage(data.from, data.to);
                }
            }
            if(data.to == from_id){
                if(data.from == to_id){
                    getMessage(data.to, data.from);
                }
            }
            });
        });
        </script>
        
        <style>
            @media(max-width:767px){
                .from, .to{
                    min-width: 65%!important;
                    max-width: 65%!important;
                    display: inline-block!important;
                    padding: 0px 11px 9px 11px!important;
                    min-height: 30px!important;
                }
            }
            .from, .to{
                    min-width: 23%;
                    max-width: 65%;
                    display: inline-block!important;
                    padding: 0px 11px 9px 11px;
                    min-height: 30px;
                }
            .from{        
                background: lightcyan;        
                position: relative;
                margin: 10px 0px 10px 35%;
                border-radius: 15px 0;
            }
            .to{
                background: #e5e8ff;        
                position: relative;
                display: block;
                margin: 10px 35% 10px 0;
                border-radius: 0 15px;
                
            }
            #send-message{
                margin:0 0 20px 0;
            }
            #message::placeholder{
                color: lightgray;
                padding: 5px;
            }
        </style>  
    ---------------- chat.blade.php End ---------------------
    ---------------- index.blade.php Start ------------------
        <section class="user-dashboard">
            <div class="dashboard-outer">
            
                <div class="row">
                    <div class="col-lg-12" style="margin-top:53px">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="d-flex" style="margin: 0px 0px;background: lightblue;padding: 2px;"> 
                                            <div style="width:60px">
                                                @if(!empty($user->profile))
                                                <img style="height: 50px;width: 50px;border-radius: 50%;overflow: hidden;" src="{{ asset('/uploads/profile/'.$user->profile) }}" alt="">
                                                @else
                                                <img style="width: 211px;padding: 10px;;" src="{{ asset ('images/logo.png') }}" alt="Employee">
                                                @endif
                                            </div>
                                            <div style="width:80%">
                                                {{-- Accountier --}}
                                            </div>
                                    </div>
                                    {!!view('front.chat.chat', ['user' => $user, 'from' => $from, 'to' => $to])!!}
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    ---------------- index.blade.php End --------------------
    ---------------- message.blade.php Start ----------------
        {{-- 1. Use front_user instead of auth()->id() bcoz incase of multiple guard like web, admin, superadmin 
        2. It will create the issue --}}
        @if(isset($messages))
        @foreach($messages as $item)
            @if($item->to == $front_user)    
            <div style="text-align:right">
                <div class="from" style="text-align:left">
                    <span>
                        <p>{{ $item->message}}</p>                
                        <p style="position: absolute;right: 7px;bottom:-7px;font-size: 11px;font-weight: 600;color:#c0a9a9">{{date('d M,Y h:i A',strtotime($item->created_at))}}</p>
                    </span>                       
                </div> 
            </div>    
            @else
            <div class="to">
                <div>            
                    <span style="float: right;width:100%;">
                        <p>{{ $item->message}}</p>                
                        <p style="position: absolute;right: 7px;bottom:-7px;font-size: 11px;font-weight: 600;color:#c0a9a9">{{date('d M,Y h:i A',strtotime($item->created_at))}}</p>
                    </span>
                </div> 
            </div>
            @endif    
            {{updateReadUnreadStatus($item->id)}}     
        @endforeach
        @else 
        <h3>No chat found!</h3>
        @endif
    ---------------- message.blade.php End ------------------
    ---------------- Routes Start ---------------------------
        Route::get('/chat', 'FrontController@chat')->middleware('auth');
        Route::post('get-messages', 'FrontController@fetchMessage');
        Route::post('send-message', 'FrontController@sendMessage');    
    ---------------- Routes End -----------------------------
    ---------------- FrontController Start ------------------
        <?php 
            public function chat()
            {
                $from = auth()->id();
                $to = 1;
                $user = auth()->user();                
            return view('front.chat.index',compact('from','to','user'));
            }
            public function fetchMessage(Request $request){
                $from = $request->from;
                $to = $request->to;
                $messages = Message::where(function($q) use($to, $from){                                
                                        $q->where('from', $from)->where('to', $to);
                                    })->orWhere(function($q)use($to, $from){
                                        $q->where('to', $from)->where('from', $to);
                                    })->get();
                                    // dd($messages);
                                    $front_user = $to;
                return view('front.chat.message', compact('messages', 'front_user'))->render();
            }    
            public function sendMessage(Request $request){

                $options = array(
                    'cluster' => 'ap2',
                    'userTLS' => false
                );

                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );  
                $from = $request->from;
                $to = $request->to;        
                $message = $request->message;
                $data = ['from'=>$from, 'to'=>$to, 'message' => $message];

                $output = '';
                if($pusher->trigger('my-channel', 'my-event', $data)){
                    $insert_message = new Message;
                    $insert_message->from = $from;
                    $insert_message->to = $to;
                    $insert_message->message = $message;
                    $insert_message->save();

                    $check = Message::where(function($q) use($from, $to){
                                $q->whereFrom($from)->whereTo($to);
                            })->orWhere(function($q) use($from, $to){
                                $q->whereTo($from)->whereFrom($to);
                            })->get();                                         
                    $data['from'] = $insert_message->from;
                    $data['to'] = $insert_message->to;
                    $data['message'] = $insert_message->message;
                    $data['created_at'] = $insert_message->created_at;
                    
                    $output = view('front.chat.message', compact('data'))->render();
                }
            
                return $output;      
            }
        ?>
    ---------------- FrontController End --------------------
=============================== Front User End =================================




=============================== Admin And SuperAdmin Routes Start =================================
        <?php 
            Route::get('chat', 'HomeController@chat');
            Route::get('practitioner/chat', 'HomeController@practitionerChat');
            Route::get('get-user-chat/{user_id}', 'HomeController@getUserChat');
        ?>
=============================== Admin And SuperAdmin Routes End =================================


=============================== SuperAdmin End =================================
    ---------------- index.blade.php Start ------------------
        @extends('admin.layout.default', ['title' => 'Chat'])
        @section('content')
        <div class="app-content">
        <x-header header="Chat" link1="Service Management" />
        <x-card collapse="no">
            <div class="row">          
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="radio" name="type" class="type" id="practitioner" value="practitioners" checked>&nbsp;<label for="practitioner">Practitioner</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" name="type" class="type" id="User" value="users">&nbsp;<label for="User">User</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search here..">
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-12 mt-3 user-list-container">
                            <ul class="users d-none">
                                @foreach ($users as $item)                                 
                                @php
                                    $userId = $item->id;
                                    $last_message = App\Models\Message::where(function($q) use($userId){
                                                        $q->where('from', $userId)->where('to', authId());
                                                    })->orWhere(function($q) use($userId){
                                                        $q->where('from', authId())->where('to', $userId);
                                                    })->orderByDESC('id')->first();                             
                                    $unread_count = App\Models\Message::where('to', $item->id)->where('isRead', '0')->count();
                                @endphp           
                                    <li class="userlist" data-id="{{$item->id}}" data-value="{{$item->first_name.' '.$item->last_name}}">
                                        <img src="{{asset($item->image ? $item->image : config('constant.dummy_profile'))}}" alt="">                        
                                        @if($unread_count > 0)
                                            {{-- <span class="count">{{$unread_count}}</span> --}}
                                        @endIf
                                        <span class="name">
                                        <span>{{$item->first_name.' '.$item->last_name}}</span>
                                        <br>
                                        @if($last_message)
                                            <span>
                                                @php
                                                    if($last_message->from == $item->id){
                                                        echo $item->first_name.' : '.$last_message->message;
                                                    }else{
                                                        echo 'You : '.substr($last_message->message,0,20).'...';
                                                    }
                                                @endphp
                                            </span>
                                        @endif
                                        </span>                        
                                    </li>
                                @endforeach                
                            </ul>
                            <ul class="practitioners">                        
                                @foreach ($practitioner as $item)                    
                                @php
                                $userId1 = $item->id;
                                $last_message1 = App\Models\Message::where(function($q) use($userId1){
                                                    $q->where('from', $userId1)->where('to', authId());
                                                })->orWhere(function($q) use($userId1){
                                                    $q->where('from', authId())->where('to', $userId1);
                                                })->orderByDESC('id')->first();                         
                                $unread_count1 = App\Models\Message::where('to', $item->id)->where('isRead', '0')->count();
                            @endphp     
                                    <li class="userlist" data-id="{{$item->id}}" data-value="{{$item->first_name.' '.$item->last_name}}">
                                        <img src="{{asset($item->image ? $item->image : config('constant.dummy_profile'))}}" alt="">                        
                                        @if($unread_count1 > 0)
                                            {{-- <span class="count">{{$unread_count1}}</span> --}}
                                        @endIf
                                        <span class="name">
                                        <span>{{$item->first_name}}</span>
                                        <br>
                                        @if($last_message1)
                                            <span>
                                                @php
                                                    if($last_message1->from == $item->id){
                                                        echo $item->first_name.' : '.$last_message1->message;
                                                    }else{
                                                        echo 'You : '.substr($last_message1->message,0,20).'...';
                                                    }
                                                @endphp
                                            </span>
                                        @endif
                                        </span>                        
                                    </li>
                                @endforeach                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">  
                    <div class="row">
                        <div class="col-md-12">                                            
                            <span class="chat-header">
                                <span id="userName">No user selected.</span> 
                            </span>                        
                        </div>
                        <div class="col-md-12">
                            {!!view('front.chat.chat', ['user' => auth()->user()])!!}                            
                        </div>
                    </div>                          
                </div>
            </div>
        </x-card>
        </div>
        @endsection
        @push('scripts')
        <script>
            $(document).ready(function () {    
                $('.userlist').click(function(){
                    $('.userlist').removeClass('active');
                    $(this).addClass('active');
                    let id = $(this).data('id');            
                    $.ajax({
                        url : "{{url(guardName().'/get-user-chat')}}/"+id,
                        success : function(res){                                        
                            $('#messages').html(res.output);
                            $('#to').val(id);
                            $('#userName').html(res.userName);
                            setTimeout(() => {   
                                $('.card-body').scrollTop($('.card-body').height()+100000);         
                            }, 100); 
                        }
                    })
                })   
                $('input[name="type"]').click(function(){
                    var id = $('input[name="type"]:checked').val();            
                    $('.practitioners , .users').addClass('d-none');
                    $('.'+id).removeClass('d-none');
                    $('#search').val('');
                })
                $("#search").on("input", function() {
                    var value = $(this).val().toLowerCase();
                    var id = $('input[name="type"]:checked').val();            
                    $('.'+id+' li').filter(function() {
                        $(this).toggle($(this).data('value').toLowerCase().indexOf(value) > -1)
                    });
                });
            });    
        </script>
        @endpush
    ---------------- index.blade.php End ------------------
=============================== SuperAdmin End =================================
=============================== HomeController Start =================================
    <?php
        public function chat(){
            $users = User::where('user_type', 'User')->get();
            $practitioner = User::where('user_type', '!=', 'User')->get();
            return view('common.chat.index', compact('users', 'practitioner'));
        }
        public function getUserChat($user_id){
            $messages = Message::where(function($q) use($user_id){
                            $q->where('from', $user_id)->where('to', authId());
                        })->orWhere(function($q) use($user_id){
                            $q->where('from', authId())->where('to', $user_id);
                        })->get();        
            $user = User::find($user_id);
            $userName = $user->first_name.' '.$user->last_name.' ( '.$user->user_type.' ) ';
            $front_user = $user_id;
            $output = view('front.chat.message', compact('messages', 'front_user'))->render();
            return response()->json(['userName' => $userName, 'output' => $output]);
        }

        // Practitioner
        public function practitionerChat(){        
            return view('common.chat.practitioner.index');
        }
     ?>
=============================== HomeController End =================================