<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        // $docs_req_category = DocumentCategoryRequirement::select([
        //     'requirement_types.data_type as data_type',
        //     'requirement_types.description as title', 'document_category_requirements.*',
        // ])
        // ->leftJoin('requirement_types', 'requirement_types.requirement_type', 'document_category_requirements.requirement_type')
        // ->whereNull(['document_category_requirements.deleted_at', 'requirement_types.deleted_at'])
        // ->get();

        return view('admin.profile.index');
    }
}
