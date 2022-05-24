@extends("Layout::app")
@section('content')
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{__('My Orders')}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li>{{__('My Orders')}}</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="container pt-5 pb-5">
        <div class="row">
            <div class="col-md-12 ">
                <div class="booking-form">
                    <div class="cart_page_form">
                        <form action="#">
                            <div class=" table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr class="carttable_row">
                                        <th class="cartm_title">{{__('No')}}</th>
                                        <th class="cartm_title">{{__('Product')}}</th>
                                        <th class="cartm_title">{{__('Price')}}</th>
                                        <th class="cartm_title">{{__('Order Date')}}</th>
                                        <th class="cartm_title">{{__('Gateway')}}</th>
                                        <th class="cartm_title">{{__('Status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table_body">

                                    @foreach($rows as $k=>$row)
                                        <?php $model = $row->model();
                                        ?>
                                        <tr>
                                            <th>{{$rows ->perPage() * ($rows->currentPage()-1) + $k + 1}}</th>
                                            <th scope="row">
                                                @if($model)
                                                    <?php $url = $model->getDetailUrl()?>
                                                    <ul class="cart_list d-flex align-center list-unstyled">
                                                        @if($model->image_id)
                                                            <li class="list-inline-item pr20">
                                                                {!! get_image_tag($model->image_id ?? '','thumb',['class'=>'float-left img-120 mw-80'])!!}
                                                            </li>
                                                        @endif
                                                        <li class="list-inline-item"><a class="cart_title" href="{{$url ? $url : '#'}}">{{$model->title}}</a></li>
                                                    </ul>
                                                @else
                                                    <ul class="cart_list d-flex align-center list-unstyled">
                                                        <li class="list-inline-item pr20">
                                                        </li>
                                                        <li class="list-inline-item"><a class="cart_title" >{{$row->name}}</a></li>
                                                    </ul>
                                                @endif
                                            </th>
                                            <td>{{format_money($row->price)}}</td>
                                            <td>{{display_datetime($row->created_at)}}</td>
                                            <td>{{$row->order->gateway ?? ''}}</td>
                                            <td>{{$row->status_name}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$rows->links()}}
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
