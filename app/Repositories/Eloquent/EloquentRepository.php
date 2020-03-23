<?php


namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get Model
     * @return string
     */
    abstract public function getModel();

    /**
     * set Model
     */
    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll($orderBy = 'created_at', $direction = 'DESC')
    {
        $result = $this->model->orderBy($orderBy, $direction)->get();
        return $result;
    }

    public function create($object)
    {
        return $object->save();
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function update($object)
    {
        return $object->save();
    }

    public function find($id, $columns = array('*'))
    {
        $result = $this->model->find($id);
        return $result;
    }

    public function getPaging()
    {
        $result = $this->model->orderBy('created_at', 'desc')->paginate(15);
        return $result;
    }

    public function findByClauses(array $data, $orderBy = 'created_at', $direction = 'DESC')
    {
        $model = $this->model;
        foreach ($data as $d){
            $model = $model->where($d['field'], $d['operator'], $d['value']);
        }
        return $model->orderBy($orderBy, $direction)->get();
    }
}
