<?php

namespace App\Services\CMS;

use App\Exceptions\CustomException;
use App\Models\CMS\Page;
use Illuminate\Support\Facades\DB;

class CmsService
{
    public function __construct(protected Page $model){}

    public function show(string $slug)
    {
        $page = $this->model::where('slug', $slug)->first();

        if(!$page){
            throw new CustomException("Page Not Found");
        }

        return $page;
    }

    public function updatePage($request, string $slug)
    {
        return DB::transaction(function () use ($request, $slug) {
            $page = $this->model::where('slug',$slug)->first();


            if ($page) {

                $page->update([
                    'name'             => $request->name ?? $page->name,
                    'content'          => $request->content ?? $page->content,
                    'meta_title'       => $request->meta_title ?? $page->meta_title,
                    'meta_description' => $request->meta_description ?? $page->meta_description,
                    'meta_keywords'    => $request->meta_keywords ?? $page->meta_keywords,
                    'status'           => $request->status ?? $page->status,
                ]);

            } else {

                $page = $this->model::create([
                    'name'             => $request->name,
                    'content'          => $request->content,
                    'meta_title'       => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'meta_keywords'    => $request->meta_keywords,
                    'status'           => $request->status,
                ]);
            }
            return $page;
        });
    }
}
