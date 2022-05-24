@if(!empty($packages=$row->packages))
    <div class="gig-page-packages-table mb-4">
        <h4 class="section-title mb-4">{{ __("Compare Packages") }}</h4>
        <div class="table-responsive">
            <table>
                <tbody>
                <tr class="package-type">
                    <th>{{ Str::plural(__("Package"),count($packages)) }}</th>
                    @foreach($packages as $key => $item)
                        @php
                            $price = $row->basic_price;
                            if( $key == 1){
                                $price = $row->standard_price;
                            }
                            if( $key == 2){
                                 $price = $row->premium_price;
                            }
                            $packages[$key]['price'] = $price;
                        @endphp
                        @if(!empty($price))
                            <td class="text-center" style="min-width: 150px">
                                <p class="price">{{ format_money($price) }} </p>
                                <b class="type">{{ $item['name'] ?? "" }}</b>
                                <b class="title"></b>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                <tr class="description">
                    <th></th>
                    @foreach($packages as $key => $item)
                        @if(!empty($item['price']))
                            <td class="text-center">
                                {{$item['desc'] ?? ""}}
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                @if(!empty($package_compare = $row->package_compare) and !empty($package_compare[0]['name']))
                    @foreach($package_compare as $key2=>$item2)
                        @if(!empty($item['price']))
                            <tr>
                                <th>
                                    {{ $item2['name'] }}
                                </th>

                                <td>
                                    {{ $item2['content'] }}
                                </td>
                                <td>
                                    {{ $item2['content1'] }}
                                </td>
                                <td>
                                    {{ $item2['content2'] }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                <tr>
                    <th>
                        {{ __('Revisions') }}
                    </th>
                    @foreach($packages as $key => $item)
                        @if(!empty($item['price']))
                            <td>
                                @if($item['revision'] == -1)
                                    {{ __("Unlimited") }}
                                @else
                                    {{ __(":number Revisions",['number'=>$item['revision'] ?? ""]) }}
                                @endif
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                <tr class="delivery-time">
                    <th>{{ __("Delivery Time") }}</th>
                    @foreach($packages as $key => $item)
                        @if(!empty($item['price']))
                            <td>
                                {{ __(":number Day Delivery",['number'=>$item['delivery_time'] ?? ""]) }}
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif

