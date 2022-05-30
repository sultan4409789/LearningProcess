<?php

namespace App\Http\Controllers;

use App\Repository\PostRepo as repo;
use App\Validation\PostValidator;
use App\Entity\Post;
 
class PostController extends Controller
{
    private $repo;
 
    public function __construct(repo $repo)
    {
        $this->repo = $repo;
    }
 
    public function edit($id=NULL)
    {
        return View('admin.index')->with(['data' => $this->repo->postOfId($id)]);
    }
 
    public function editPost()
    {
        $all = Input::all();
        $validate = PostValidator::validate($all);
        if (!$validate->passes()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }
        $Id = $this->repo->postOfId($all['id']);
        if (!is_null($Id)) {
            $this->repo->update($Id, $all);
            Session::flash('msg', 'edit success');
        } else {
            $this->repo->create($this->repo->perpare_data($all));
            Session::flash('msg', 'add success');
        }
        return redirect()->back();
    }
 
    public function retrieve()
    {
        $input['title'] = 'test title';
        $input['body'] = 'test body';
        
        $post = new Post($input);

        $this->repo->create($post);

        echo "<pre>";print_r($this->repo->PostOfId(1));exit;

        return View('admin.index')->with(['Data' => $this->repo->PostOfId(1)]);
    }
 
    public function delete()
    {
        $id = Input::get('id');
        $data = $this->repo->postOfId($id);
        if (!is_null($data)) {
            $this->repo->delete($data);
            Session::flash('msg', 'operation Success');
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('operationFails');
        }
    }
}
