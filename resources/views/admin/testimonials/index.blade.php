@extends('layouts/admin/app')

@section('content')
	<div class="card">
		<div class="card-header">
			{{ __('testimonials.header_testimonial')}} 
			<div class="float-right">
				<a href="/admin/testimonials/create" class="btn btn_prohibitedWord">{{ __('testimonials.header_new')}} <i class="fas fa-plus-square"></i></a>
			</div>
		</div>
		<div class="card-body">
			{{ $testimonials->links() }}
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">{{ __('testimonials.table_name')}}</th>
						<th scope="col">{{ __('testimonials.table_experience')}}</th>
						<th scope="col">{{ __('testimonials.table_date')}}</th>
						<th scope="col"></th>
						<th scope="col"></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($testimonials as $testimonial)
					<tr>						
						<td>{{ $testimonial->id }}</td>
						<td>
							{{ $testimonial->name }}
						</td>
						<td>{{ str_limit($testimonial->experience, $limit = 15, $end = '...') }}</td>
						<td>{{ $testimonial->created_at }}</td>
						<td>
							<a href="/admin/testimonials/{{ $testimonial->id }}">
								<i class="fas fa-eye"></i>
							</a>
						</td>
						<td>
							<a href="/admin/testimonials/{{ $testimonial->id }}/edit">
								<i class="fas fa-edit"></i>
							</a>
						</td>
						<td>
							<form class="form_submit_ays" method="POST" id="deleteAccount{{$testimonial->id}}" action="/admin/testimonials/{{$testimonial->id}}">
								@method('DELETE')
								@csrf
								<div>
									<div>
										<button type="button" class="button-remove" data-toggle="modal" data-target="#confirmDeleteAccount{{$testimonial->id}}">
											<i class="fas fa-trash-alt"></i>
										</button>
									</div>

									<div class="modal fade" id="confirmDeleteAccount{{$testimonial->id}}" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{__('testimonials.delete_title_confirm')}}</h5>
													<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													{{__('testimonials.delete_confirm_text')}}
												</div>
												<div class="modal-footer">
													<input type="submit" form="deleteAccount{{$testimonial->id}}" class="btn btn-danger"
														   value="{{__('testimonials.delete_confirm_delete')}}">
													<button type="button" class="btn btn-primary"
															data-dismiss="modal">{{__('testimonials.delete_dismiss_delete')}}
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection