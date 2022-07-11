<?php

namespace App\Http\Controllers\Admin;

use App\BannedIp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuspensionsController extends Controller
{
    //
	public function index()
    {
        $ips = BannedIp::simplePaginate(10);
        return view('admin.suspensions.index', compact('ips'));
    }

    public function destroy($id)
    {
    	$ip = BannedIp::findOrFail($id);
        $ip->delete();

        return redirect('admin/suspensions/ip');
    }
}
