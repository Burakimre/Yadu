@extends('layouts/admin/app')

@section('content')

@if ($errors->has('email'))
@foreach($errors->get('email') as $error)
<div class="alert alert-danger alert-dismissible fade show">
    <strong>Error!</strong> {{$error}}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endforeach
@endif
@if ($errors->has('link'))
@foreach($errors->get('link') as $error)
<div class="alert alert-danger alert-dismissible fade show" style="float:right; margin-right: 10px;">
    <strong>Error!</strong> {{$error}}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endforeach
@endif

<h1>Edit Links</h1>
<div class="card-body">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">{{__('contact.admin_id')}}</th>
                <th scope="col">{{__('contact.admin_name')}}</th>
                <th scope="col">{{__('contact.admin_link')}}</th>
                <th scope="col">{{__('contact.admin_status')}}</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="linksToDisplay">
            <?php $y=0 ?>
            @foreach ($socialmedia as $social)
            <tr>
                <td>{{$y+=1}}</td>
                <td>{{ucfirst($social->name)}}</td>
                <td>{{$social->link}}</td>
                <td>{{ucfirst($social->type)}}</td>
                <td><button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#change{{$social->name}}Link"
                        data-whatever="@mdo">{{__('contact.show_edit')}}</button>

                    <div class="modal fade" id="change{{$social->name}}Link" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{__('contact.show_edit_link',['name'=>$social->name])}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <form method="POST" action="/admin/{{$social->type}}"
                                            id="submitEdit{{$social->name}}">
                                            @csrf
                                            <label for="{{$social->name}}" class="col-form-label">Link:</label>
                                            <input type="hidden" name="name" value="{{$social->name}}">
                                            <input type="text" class="form-control" name="{{$social->type}}"
                                                value="{{$social->link}}">
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{__('contact.edit_close')}}</button>
                                    <button type="submit" form="submitEdit{{$social->name}}" value="Submit"
                                        class="btn btn-primary">{{__('contact.edit_update')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection