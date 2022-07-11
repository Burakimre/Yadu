<?php

namespace App\Http\Controllers\Admin;

use App\Testimonial;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateTestimonialRequest;

class TestimonialsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$testimonials = Testimonial::simplePaginate(10);
		return view('admin.testimonials.index', compact('testimonials'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$testimonial = Testimonial::findOrFail($id);
		return view('admin.testimonials.show', compact('testimonial'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.testimonials.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateTestimonialRequest $request)
	{
		$newTestimonial = new Testimonial;
		$newTestimonial->name = $request['name'];
		$newTestimonial->experience = $request['experience'];

		$newTestimonial->save();
		return redirect('/admin/testimonials/'.$newTestimonial->id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$testimonial = Testimonial::findOrFail($id);
		return view('admin.testimonials.edit', compact('testimonial'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(CreateTestimonialRequest $request, $id)
	{
		$newTestimonial = Testimonial::findOrFail($id);
		$newTestimonial->name = $request['name'];
		$newTestimonial->experience = $request['experience'];

		$newTestimonial->save();

		return redirect('/admin/testimonials/'.$newTestimonial->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$testimonial = Testimonial::findOrFail($id);
		
		if(Auth::user()->accountRole == 'Admin')
		{
			$testimonial->delete();
		}

		return redirect('/admin/testimonials');
	}
}
