<?php

namespace Modules\System\Helpers\Api;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class ApiCrud extends Controller
{
    public const JUST_PAGINATOR_KEY = 'just_return_paginator';

    protected array $validationRules = [];

    protected array $overrideFunctions = [];

    protected array $validationMessages = [];

    protected array $overrideModelFunctions = [];

    protected array $visibleColumns = [];

    protected array $hiddenColumns = [];

    protected bool $isReturnJson = false;

    abstract protected function getModel(): Model;

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);

        $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__)
                      ->orderByDesc('id');

        if ($request->exists('paginate')) {
            $resources = $query->paginate($perPage);
        } else {
            $resources = $query->get();
        }

        if ($request->exists(self::JUST_PAGINATOR_KEY)) {
            return $resources;
        }
        if ($this->isReturnJson) {
            return Result::successWithData($this->translateWithModelName('crud.list_of'), $resources);
        }

        return $resources;
    }

    public function store(Request $request)
    {
        try {
            Validator::make($request->all(), $this->validationRules, $this->validationMessages)->validate();
            $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__);
            $newResource = $query->create($request->all());

            if (! $newResource) {
                throw new Exception($this->translateWithModelName('crud.failed'), 500);
            }
            if ($this->isReturnJson) {
                return Result::successWithData($this->translateWithModelName('crud.created'), $newResource);
            }

            return $newResource;
        } catch (Exception $e) {
            return Result::exception($e);
        }
    }

    public function show(int $resourceId)
    {
        $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__);

        if ($resource = $query->find($resourceId)) {
            $this->columnVisibilities($resource);
            $data = $resource->toArray();
            if (isset($this->overrideFunctions[__FUNCTION__])) {
                $data[$this->overrideFunctions[__FUNCTION__]['key']] = $this->overrideFunctions[__FUNCTION__]['function']($resource);
            }
            if ($this->isReturnJson) {
                return Result::successWithData($this->translateWithModelName('crud.found'), $data);
            }

            return $data;
        }

        return Result::fail($this->translateWithModelName('crud.not_found'), 404);
    }

    public function update(Request $request, int $resourceId)
    {
        try {
            if (! $resource = $this->getModel()::query()->find($resourceId)) {
                throw new Exception($this->translateWithModelName('crud.not_found'), 404);
            }
            $request->merge(['id' => $resourceId]);
            Validator::make($request->all(), $this->validationRules, $this->validationMessages)->validate();
            if (! $resource->update($request->all())) {
                throw new Exception($this->translateWithModelName('crud.update_failed'), 500);
            }
            if ($this->isReturnJson) {
                return Result::successWithData($this->translateWithModelName('crud.updated'), $resource);
            }

            return $resource;
        } catch (Exception $e) {
            return Result::exception($e);
        }
    }

    public function destroy($resourceId): JsonResponse|bool|array
    {
        try {
            $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__);

            if (! $resource = $query->find($resourceId)) {
                throw new Exception($this->translateWithModelName('crud.not_found'), 404);
            }

            $resource->delete();
            if ($this->isReturnJson) {
                return Result::success($this->translateWithModelName('crud.deleted'));
            }

            return true;
        } catch (Exception $e) {
            return Result::exception($e);
        }
    }

    public function translateWithModelName($key): string
    {
        return __($key, ['attribute' => $this->translateModelName(class_basename($this->getModel()))]);
    }

    public function translateModelName(string $className): string
    {
        return __('model.'.Str::camel($className));
    }

    protected function executeModelFunction(Builder $query, string $functionName): Builder
    {
        if (isset($this->overrideModelFunctions[$functionName])) {
            $query = $this->overrideModelFunctions[$functionName]['function']($query);
        }

        return $query;
    }

    protected function columnVisibilities(Model $model): void
    {
        if (! empty($this->visibleColumns)) {
            $model->makeVisible($this->visibleColumns);
        }

        if (! empty($this->hiddenColumns)) {
            $model->makeHidden($this->hiddenColumns);
        }
    }
}
