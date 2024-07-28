@extends('layouts.master')

@section('content')

<div class="container-fluid pl-3 pr-3">
    <div class="row">
        <div class="col-12 p-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 nodecorationlist">
                    <li class="breadcrumb-item green"><a href="{{route('home')}}" class="green"><i class="fas fa-home mr-2"></i>Home</a></li>
                    <li class="breadcrumb-item active gray" aria-current="page">Chat</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('_partialstest._messages')
    <style>
        ul {
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;
        }

        .user-wrapper,
        .message-wrapper {
            border: 1px solid #dddddd;
            overflow-y: auto;
        }

        .user-wrapper {
            height: 600px;
        }

        .user {
            cursor: pointer;
            padding: 5px 0;
            position: relative;
        }

        .user:hover {
            background: #eeeeee;
        }

        .user:last-child {
            margin-bottom: 0;
        }

        .pending {
            position: absolute;
            left: 13px;
            top: 9px;
            background: #b600ff;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .media-left {
            margin: 0 10px;
        }

        .media-left img {
            width: 64px;
            border-radius: 64px;
        }

        .media-body p {
            margin: 6px 0;
        }

        .message-wrapper {
            padding: 10px;
            height: 350px;
            background: #bfe3e9;
        }

        .messages .message {
            margin-bottom: 15px;
        }

        .messages .message:last-child {
            margin-bottom: 0;
        }

        .received,
        .sent {
            width: 45%;
            padding: 3px 10px;
            border-radius: 10px;
        }

        .received {
            background: #ffffff;
        }

        .sent {
            background: #3bebff;
            float: right;
            text-align: right;
        }

        .message p {
            margin: 5px 0;
        }

        .date {
            color: #777777;
            font-size: 12px;
        }

        .active {
            background: #eeeeee;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 15px 0 0 0;
            display: inline-block;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
            border: 1px solid #cccccc;
        }

        input[type=text]:focus {
            border: 1px solid #aaaaaa;
        }

    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="user-wrapper">
                    <ul class="users">
                        @forelse($users as $user)
                        <li class="user" id="{{$user->id}}">
                            <div class="media">
                                <div class="media-left">
                                    @if($user->isOnline() && $user->seeker )
                                    @if($user->role == 2)
                                    <img src="{{ (($user->seeker->image != '') && file_exists(public_path('images/seeker/profile/'.$user->seeker->image))) ? asset('images/seeker/profile/'.$user->seeker->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="media-object rounded-circle" height="50px" style="border: 2px solid #1abb9c; object-fit: cover;">
                                    <span class="label label-default label-danger" style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; background-color: rgb(13, 116, 16);"></span>
                                    @else
                                    <img src="{{ (($user->owner->image != '') && file_exists(public_path('images/owner/profile/'.$user->owner->image))) ? asset('images/owner/profile/'.$user->owner->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="media-object rounded-circle" height="50px" style="border: 2px solid #1abb9c; object-fit: cover;">
                                    <span class="label label-default label-danger" style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; background-color: rgb(10, 100, 32);"></span>
                                    @endif
                                    @else
                                    <img src="{{asset('backend/assets/img/logo.jpg')}}" alt="" class="media-object rounded-circle" height="50px" style="border: 3px solid #e31538; object-fit: cover;">
                                    <span class="label label-default label-danger" style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; background-color: rgb(10, 100, 32);"></span>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <p class="name">{{$user->name}}</p>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="user">No Users</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-md-8" id="messages">
            </div>
        </div>
    </div>
</div>
@endsection

@section('chat')
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    var receiver_id = "";
    var sender_id = "{{auth()->id()}}";
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Pusher.logToConsole = true;
        var pusher = new Pusher('8085e3ccd0091b7fe4a0', {
            cluster: 'ap2'
            , forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            if (sender_id == data.from) {
                $('#' + data.to).click();
            } else if (sender_id == data.to) {
                if (receiver_id == data.from) {
                    $('#' + data.from).click();
                } else {
                    var pending = parseInt($('#' + data.from).find('.pending').html());

                    if (pending) {
                        $('#' + data.from).find('.pending').html(pending + 1);
                    } else {
                        $('#'.data.from).append('<span class="pending">1</span>');
                    }
                }
            }
        });
        $('.user').click(function() {
            $('.user').removeClass('active');
            $(this).addClass('active');

            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get"
                , url: "message/" + receiver_id
                , data: ""
                , cache: false
                , success: function(data) {
                    $('#messages').html(data);
                    scrollToBottomFunc();
                }
            })
        });

        $(document).on('keyup', '.input-text input', function(e) {
            var message = $(this).val();
            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val('');

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post"
                    , url: "message"
                    , data: datastr
                    , cache: false
                    , success: function(data) {

                    }
                    , error: function(jqXHR, status, err) {

                    }
                    , complete: function() {
                        scrollToBottomFunc();
                    }
                })
            }
        });
    });

    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }

</script>
@endsection
