<?php

namespace App\Http\Controllers;


use View;


class FAQController extends Controller {

    public function getFAQs(){

        $faqs = \Maven::get();

        return View::make('faqs',['faqs'=>$faqs]);

    }

    

    

}
