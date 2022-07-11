@extends('layouts/admin/app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="addon-wrapping"><i class="fa fa-search"></i></span>
                </div>
                <input oninput="fetch_accounts()" list="names" id="filterByName" name="filterByName"
                       autocomplete="off" class="form-control" placeholder="{{ __('accounts.index_search')}}" aria-label="Email"
                       aria-describedby="addon-wrapping">
            </div>
        </div>
        <div class="card-body">
            <div id="accountsDisplay">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('accounts.index_name')}}</th>
                        <th scope="col">{{ __('accounts.index_role')}}</th>
                        <th scope="col">{{ __('accounts.index_email')}}</th>
                        <th scope="col">{{ __('accounts.index_verified')}}</th>
                        <th scope="col">{{ __('accounts.index_created')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr class="accounts-table on_hover_pointer" onclick="window.location='{{url('/admin/accounts/'. $account->id)}}';">
                            <th scope="row"><img class="img-fluid rounded-circle my-auto avatar"
                                                 src="data:image/jpeg;base64, {{base64_encode($account->avatar)}}"/>
                            </th>
                            <td>{{$account->firstName .' '. $account->middleName .' '. $account->lastName}}</td>
                            <td>{{$account->accountRole}}</td>
                            <td>{{$account->email}}</td>
                            <td>
                                @if($account->email_verified_at != null)
                                    <span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
                                @else
                                    <span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>
                                @endif
                            </td>
                            <td>{{$account->written_created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        //AJAX request
        function fetch_accounts() {
            $('#accountsDisplay').html("<h1 class=\"text-center\">...</h1>");
            var inputName = $(filterByName).val();
            $.ajax({
                url: "{{ route('admin_accounts_controller.action')}}",
                method: 'POST',
                data: {
                    inputName: inputName,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data == "") {
                        $('#eventsToDisplay').html(
                            //TODO remove inline style
                            "<div style='text-align:center; width:100%; padding-top:50px;'><h1>{{__('accounts.index_no_event_found')}}</h1><div>"
                        );
                    } else {
                        var html = "" +
                            "<table class=\"table table-striped table-hover\">\n" +
                            "   <thead>\n" +
                            "       <tr>\n" +
                            "           <th scope=\"col\">#</th>\n" +
                            "           <th scope=\"col\">{{ __('accounts.index_name')}}</th>\n" +
                            "           <th scope=\"col\">{{ __('accounts.index_role')}}</th>\n" +
                            "           <th scope=\"col\">{{ __('accounts.index_email')}}</th>\n" +
                            "           <th scope=\"col\">{{ __('accounts.index_verified')}}</th>\n" +
                            "           <th scope=\"col\">{{ __('accounts.index_created')}}</th>\n" +
                            "       </tr>\n" +
                            "   </thead>\n" +
                            "<tbody>";
                        data.forEach(function (element) {
                            html = html +
                                "<tr class=\"accounts-table on_hover_pointer\" onclick=\"window.location='" + element['url'] + " ';\">\n" +
                                "   <th scope=\"row\"><img class=\"img-fluid rounded-circle my-auto avatar\"\n" +
                                "       src=\"data:image/jpeg;base64, " + element['avatar'] + "\"/>\n" +
                                "   </th>\n" +
                                "   <td>" + element['fullName'] + "</td>\n" +
                                "   <td>" + element['accountRole'] + "</td>\n" +
                                "   <td>" + element['email'] + "</td>\n" +
                                "   <td>" + element['email_verified_at'] + "</td>\n" +
                                "   <td>" + element['created_at'] + "</td>\n" +
                                "</tr>";
                        });
                        html = html + "" +
                            "       </tbody>\n" +
                            "   </table>" +
                            "";
                        $('#accountsDisplay').html(html);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    $('#eventsToDisplay').html(
                        "<div style='text-align:center; width:100%; padding-top:50px;'><h1>{{__('accounts.index_loading_error')}}</h1><div>"
                    );
                }
            })
        }
    </script>
@endsection