<?php

namespace Modules\System\ApiHelpers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    abstract protected function getModel(): Model;

    public function index(Request $request): JsonResponse|LengthAwarePaginator|Collection
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

        return Result::successWithData($this->translateWithModelName('crud.list_of'), $resources);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            Validator::make($request->all(), $this->validationRules, $this->validationMessages)->validate();
            $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__);
            $newResource = $query->create($request->all());

            if (! $newResource) {
                throw new Exception($this->translateWithModelName('crud.failed'), 500);
            }

            return Result::successWithData($this->translateWithModelName('crud.created'), $newResource);
        } catch (Exception $e) {
            return Result::exception($e);
        }
    }

    public function show(int $resourceId): JsonResponse
    {
        $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__);

        if ($resource = $query->find($resourceId)) {
            $this->columnVisibilities($resource);
            $data = $resource->toArray();
            if (isset($this->overrideFunctions[__FUNCTION__])) {
                $data[$this->overrideFunctions[__FUNCTION__]['key']] = $this->overrideFunctions[__FUNCTION__]['function']($resource);
            }

            return Result::successWithData($this->translateWithModelName('crud.found'), $data);
        }

        return Result::fail($this->translateWithModelName('crud.not_found'), 404);
    }

    public function update(Request $request, int $resourceId): JsonResponse
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

            return Result::successWithData($this->translateWithModelName('crud.updated'), $resource);
        } catch (Exception $e) {
            return Result::exception($e);
        }
    }

    public function destroy($resourceId): JsonResponse
    {
        try {
            $query = $this->executeModelFunction($this->getModel()::query(), __FUNCTION__);

            if (! $resource = $query->find($resourceId)) {
                throw new Exception($this->translateWithModelName('crud.not_found'), 404);
            }

            $resource->delete();

            return Result::success($this->translateWithModelName('crud.deleted'));
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
