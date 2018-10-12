<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaginateController extends Controller
{
    public function getPagination($paginate, $data, $url){

        $respons['current_page']   = $paginate->currentPage();
        $respons['data']           = $data;
        $respons['first_page_url'] = $paginate->firstItem();
        $respons['from']           = 1;
        $respons['last_page']      = $paginate->lastPage();
        $respons['last_page_url']  = $paginate->lastPage();
        $respons['next_page_url']  = $paginate->nextPageUrl();
        $respons['path']           = url($url);
        $respons['per_page']       = $paginate->perPage();
        $respons['prev_page_url']  = $paginate->previousPageUrl();
        $respons['to']             = $paginate->perPage();
        $respons['total']          = $paginate->total();

        return $respons;
    }
}
