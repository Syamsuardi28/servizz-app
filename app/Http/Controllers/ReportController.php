<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;

class ReportController extends Controller
{
    public function reportMitra()
    {
        $techRes = ApiHelper::get('/technicians');
        $techs   = ApiHelper::extractData($techRes, 'technicians', []);
        $techs   = is_array($techs) ? array_filter($techs, 'is_array') : [];

        return view('reports.mitra', compact('techs'));
    }

    public function reportServices()
    {
        $res      = ApiHelper::get('/services');
        $services = ApiHelper::extractData($res, 'services', []);
        $services = is_array($services) ? array_filter($services, 'is_array') : [];

        return view('reports.services', compact('services'));
    }
}
