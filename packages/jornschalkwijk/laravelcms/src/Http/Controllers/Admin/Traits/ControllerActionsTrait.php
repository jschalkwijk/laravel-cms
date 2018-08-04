<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits;

    use Illuminate\Http\Request;

    trait ControllerActionsTrait
    {
        public function destroy($id)
        {
            $model = $this->model::findOrFail($id);
            $model->delete();
            return back();
        }

        public function hide($id)
        {
            $model = $this->model::findOrFail($id);
            $model->hide();
            return back();
        }

        public function approve($id)
        {
            $model = $this->model::findOrFail($id);
            $model->approve();
            return back();
        }

        public function trash($id)
        {
            $model = $this->model::findOrFail($id);
            $model->trash();
            return back();
        }

        public function restore($id)
        {
            $model = $this->model::findOrFail($id);
            $model->restore();

            return back();
        }

        public function action(Request $r)
        {
            $model = new $this->model;

            if(isset($r['trash-selected'])){
                $model->trash($r['checkbox']);
            }
            if(isset($r['approve-selected'])){

                $model->approve($r['checkbox']);
            }
            if(isset($r['hide-selected'])){

                $model->hide($r['checkbox']);
            }
            if(isset($r['restore-selected'])){

                $model->restore($r['checkbox']);
            }
            if(isset($r['delete-selected'])){
                $model->removeMany($r['checkbox']);
            }

            return back();
        }

    }
