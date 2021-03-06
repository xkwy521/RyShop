@section('title')
    我的工单
@stop
@include('header')
@include('nav')

@if(Auth::user())
    <section class="container grid-960">
        <div class="container">
            <div class="columns">
                <div class="column col-3 col-md-12">
                    @include("sidebar")
                </div>
                <div class="column col-9 col-md-12">
                    <div class="item-title">
                        您的工单提问共 <b>{{Auth::user()->ticket()->count()}}</b> 个
                        <a href="/my_ticket/new" class="new_ticket_btn"> 提交新工单</a>
                        <a href="/my_ticket/closed" class="new_ticket_btn"> 关闭的（{{Auth::user()->ticket()->whereRaw("valid='0'")->count()}}）</a>
                        <a href="/my_ticket/open" class="new_ticket_btn"> 有效的（{{Auth::user()->ticket()->whereRaw("valid='1'")->count()}}）</a>

                    </div>

                        @if(Auth::user()->ticket->count())
                        <div class="ticket-panel">
                        <table class="table table-striped table-hover" style="border-top: 1px solid #eee">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th style="text-align: center">时间</th>
                                <th style="text-align: center">状态</th>
                                <th style="text-align: center">回复情况</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tic as $ticinfo)
                                <tr>
                                    <td><a href="/my_ticket/{{$ticinfo->id}}">{{$ticinfo->title}}</a></td>
                                    <td style="text-align: center"><?php echo $ticinfo->created_at->toDateString();?></td>
                                    <td style="text-align: center">
                                        @if($ticinfo->valid=="1")
                                            <div class="inline" style="color: #4CAF50">有效</div>
                                        @else
                                            <div class="inline" style="color: #607D8B">已关闭</div>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if($ticinfo->reply==Auth::user()->id)
                                            <div class="inline" style="color: #607D8B;">尚未</div>
                                        @else
                                            <div class="inline" style="color: #4CAF50;">√</div>
                                        @endif

                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif
                        <div class="host-tips toast" @if(Auth::user()->ticket->count()) style="margin-top:10px;" @endif>
                            {!! \App\Setings::whereRaw("name='ticket_text'")->first()->value !!}
                        </div>

                </div>

            </div>
        </div>
    </section>
@else
    <section class="container grid-960">
        <div class="card user-info">
            <div class="empty">
                <div class="empty-icon">
                    <i class="icon icon-people"></i>
                </div>
                <h4 class="empty-title">您还没有登录</h4>
                <p class="empty-subtitle">您还没有登录系统，请登录之后再进行操作哦！</p>
                <div class="empty-action">
                    <a href="/auth/login" class="btn btn-primary">登录</a>
                    <a href="/auth/resigter" class="btn">注册</a>
                </div>
            </div>
        </div>
    </section>

@endif
@include('footer')