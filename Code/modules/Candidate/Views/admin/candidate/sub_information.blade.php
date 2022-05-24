    @php
        $candidate = $row->candidate;
    @endphp
    <h3 class="panel-body-title">{{__('Education')}}</h3>
    <div class="form-group-item">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-2">{{__("Time")}}</div>
                <div class="col-md-3">{{__('Location')}}</div>
                <div class="col-md-3">{{__('Reward')}}</div>
                <div class="col-md-3">{{__('More Information')}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $educations = @$candidate->education;?>
            @if(!empty($educations))
                @foreach($educations as $key=>$item)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-1">
                                <input type="text" name="education[{{$key}}][from]" class="form-control" value="{{@$item['from']}}" placeholder="{{__('From')}}">
                            </div>
                            <div class="col-md-1">
                                <input type="text" name="education[{{$key}}][to]" class="form-control" value="{{@$item['to']}}" placeholder="{{__('To')}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="education[{{$key}}][location]" class="form-control" value="{{@$item['location']}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="education[{{$key}}][reward]" class="form-control" value="{{@$item['reward']}}">
                            </div>
                            <div class="col-md-3">
                                <textarea name="education[{{$key}}][information]" class="form-control" >{{@$item['information']}}</textarea>
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="text-right">
            <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
        </div>
        <div class="g-more hide">
            <div class="item" data-number="__number__">
                <div class="row">
                    <div class="col-md-1">
                        <input type="text" __name__="education[__number__][from]" class="form-control" value="" placeholder="{{__('From')}}">
                    </div>
                    <div class="col-md-1">
                        <input type="text" __name__="education[__number__][to]" class="form-control" value="" placeholder="{{__('To')}}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" __name__="education[__number__][location]" class="form-control" value="">
                    </div>
                    <div class="col-md-3">
                        <input type="text" __name__="education[__number__][reward]" class="form-control" value="">
                    </div>
                    <div class="col-md-3">
                        <textarea __name__="education[__number__][information]" class="form-control" ></textarea>
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <h3 class="panel-body-title">{{__('Experience')}}</h3>
    <div class="form-group-item">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-2">{{__("Time")}}</div>
                <div class="col-md-3">{{__('Location')}}</div>
                <div class="col-md-3">{{__('Position')}}</div>
                <div class="col-md-3">{{__('More Information')}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $experiences = @$candidate->experience; ?>
            @if(!empty($experiences))
                @foreach($experiences as $key=>$item)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-1">
                                <input type="text" name="experience[{{$key}}][from]" class="form-control" value="{{@$item['from']}}" placeholder="{{__('From')}}">
                            </div>
                            <div class="col-md-1">
                                <input type="text" name="experience[{{$key}}][to]" class="form-control" value="{{@$item['to']}}" placeholder="{{__('To')}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="experience[{{$key}}][location]" class="form-control" value="{{@$item['location']}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="experience[{{$key}}][position]" class="form-control" value="{{@$item['position']}}">
                            </div>
                            <div class="col-md-3">
                                <textarea name="experience[{{$key}}][information]" class="form-control" >{{@$item['information']}}</textarea>
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="text-right">
            <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
        </div>
        <div class="g-more hide">
            <div class="item" data-number="__number__">
                <div class="row">
                    <div class="col-md-1">
                        <input type="text" __name__="experience[__number__][from]" class="form-control" value="" placeholder="{{__('From')}}">
                    </div>
                    <div class="col-md-1">
                        <input type="text" __name__="experience[__number__][to]" class="form-control" value="" placeholder="{{__('To')}}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" __name__="experience[__number__][location]" class="form-control" value="">
                    </div>
                    <div class="col-md-3">
                        <input type="text" __name__="experience[__number__][position]" class="form-control" value="">
                    </div>
                    <div class="col-md-3">
                        <textarea __name__="experience[__number__][information]" class="form-control" value=""></textarea>
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <h3 class="panel-body-title">{{__('Award')}}</h3>
    <div class="form-group-item">
        <div class="g-items-header">
            <div class="row">
                <div class="col-md-2">{{__("Time")}}</div>
                <div class="col-md-3">{{__('Location')}}</div>
                <div class="col-md-3">{{__('Reward')}}</div>
                <div class="col-md-3">{{__('More Information')}}</div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="g-items">
            <?php $educations = @$candidate->award; ?>
            @if(!empty($educations))
                @foreach($educations as $key=>$item)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-1">
                                <input type="text" name="award[{{$key}}][from]" class="form-control" value="{{@$item['from']}}" placeholder="{{__('From')}}">
                            </div>
                            <div class="col-md-1">
                                <input type="text" name="award[{{$key}}][to]" class="form-control" value="{{@$item['to']}}" placeholder="{{__('To')}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="award[{{$key}}][location]" class="form-control" value="{{@$item['location']}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="award[{{$key}}][reward]" class="form-control" value="{{@$item['reward']}}">
                            </div>
                            <div class="col-md-3">
                                <textarea name="award[{{$key}}][information]" class="form-control" >{{@$item['information']}}</textarea>
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="text-right">
            <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
        </div>
        <div class="g-more hide">
            <div class="item" data-number="__number__">
                <div class="row">
                    <div class="col-md-1">
                        <input type="text" __name__="award[__number__][from]" class="form-control" value="" placeholder="{{__('From')}}">
                    </div>
                    <div class="col-md-1">
                        <input type="text" __name__="award[__number__][to]" class="form-control" value="" placeholder="{{__('To')}}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" __name__="award[__number__][location]" class="form-control" value="">
                    </div>
                    <div class="col-md-3">
                        <input type="text" __name__="award[__number__][reward]" class="form-control" value="">
                    </div>
                    <div class="col-md-3">
                        <textarea __name__="award[__number__][information]" class="form-control" ></textarea>
                    </div>
                    <div class="col-md-1">
                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>



