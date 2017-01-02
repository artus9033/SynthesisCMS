<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
	// Add methods to add, edit, delete and show pages

     // create method to create new pages
     // submit the form to this method
     public function create(array $data)
     {
         $inputs = Input::all();
         $page = Page::create(['slug' => $data['slug'], 'title' => $data['title'], 'page_content' => $data['page_content']]);
     }

     // Show a page by slug
     public function show($slug = 'home')
     {
         $page = Page::whereSlug($slug)->first();
         return \View::make('pages.index')->with('page', $page);
     }
}
